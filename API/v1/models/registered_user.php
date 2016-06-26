<?php
	// require '../passwordHash.php';
	require_once 'user.php';
	/**
	*
	*/
	class RegisteredUser
	{
		private $id;
		private $name;
		private $user_name;
		private $email;
		private $password;
		private $facebook_key;
		private $followers; // array of users id
		private $following; // array of users id
		private $conn;

		public function __construct($id='',$name='',$user_name='',$email='',$password='',$facebook_key='',$followers='',$following='')
		{
			$this->id = $id;
			$this->name = $name;
			$this->email = $email;
			$this->password = $password;
			$this->facebook_key = $facebook_key;
			$this->followers = $followers;
			$this->following = $following;
			$this->conn = new PDO("mysql:host=localhost;dbname=Mazadna", "root", "Ahmed2512011");
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if (!isset($_SESSION)) {
				session_start();
			    }
		}

		// first_name:'',
        // last_name:'',
        // username:'',
        // email:'',
        // phone_number:'',
        // password:'',

		public function sign_up($first_name,$last_name,$username,$email,$phone_number,$password)
		{
			$response = array();
			try{
			    $stmt = $this->conn->prepare("SELECT 1 FROM `user` WHERE username=:username or email=:email or phone_number=:phone_number ");
			    $stmt->bindParam(':username',$username);
			    $stmt->bindParam(':email',$email);
			    $stmt->bindParam(':phone_number',$phone_number);
			    $stmt->execute();

			    $isUserExists = $stmt->fetch(PDO::FETCH_ASSOC);

			    if(!$isUserExists){
			        $password = passwordHash::hash($password);

			        $stmt = $this->conn->prepare("INSERT INTO user (first_name, last_name, username,email,phone_number,password)
				    						VALUES (:first_name, :last_name,:username, :email, :phone_number,:password)");
				    $stmt->bindParam(':first_name', $first_name);
				    $stmt->bindParam(':last_name', $last_name);
				    $stmt->bindParam(':username', $username);
				    $stmt->bindParam(':email', $email);
				    $stmt->bindParam(':phone_number', $phone_number);
				    $stmt->bindParam(':password', $password);

			        $result = $stmt->execute();

			        if ($result != NULL) {
			        	$response["status"] = "success";
			            $response["message"] = "User account created successfully";
			            $response["uid"] = $this->conn->lastInsertId();
			            if (!isset($_SESSION)) {
			                session_start();
			            }
			            $_SESSION['uid'] = $response["uid"];
			            $_SESSION['name'] = $first_name." ".$last_name;
			            $_SESSION['email'] = $email;
			            return $response;
			        } else {
			            $response["status"] = "error";
			            $response["message"] = "Failed to create customer. Please try again";
			            return $response;
			        }
			    }else{
			        $response["status"] = "error";
			        $response["message"] = "An user with the provided phone or email or username exists!";
			        return $response ;
			    }
		    }catch(PDOException $e) {
    			return "Error: " . $e->getMessage();
			}
		}


		public function sign_in($username,$password)
		{
			$response = array();
			try {
				$stmt = $this->conn->prepare("SELECT * FROM `user` WHERE username=:username");
			    $stmt->bindParam(':username',$username);

			    $stmt->execute();

			    $isUserExists = $stmt->fetch(PDO::FETCH_ASSOC);
			    if ($isUserExists != NULL) {
			    	if (passwordHash::check_password($isUserExists['password'],$password)) {
			    		# code...
				    	$response["status"] = "success";
				    	$response["message"] = "Loging successfully";
				    	$response["uid"] = $isUserExists['id'];
				    	$response["first_name"] = $isUserExists['first_name'];
				    	
			            $_SESSION['uid'] = $isUserExists["id"];
			            $_SESSION['name'] = $isUserExists["first_name"]." ".$isUserExists["last_name"];
			            $_SESSION['email'] = $isUserExists["email"];
			            session_commit();
			            $response['session'] = $_SESSION['uid'];
			            return $response;
			    	} else {
			    		$response["status"] = "Failed";
			    		$response["message"] =" Wrong password";
			    		return $response;
			    	}

			    } else {
			    	$response["status"] = "Failed";
			    	$response["message"] = "No such user exists";
			    	return $response;
			    }
			} catch (PDOException $e) {
				return "Error: ".$e->getMessage();
			}
		}
		
		public function islogged()
		{
			$response = array();
			if (isset($_SESSION['uid'])) {
				# code...
				$response['status'] = "success";
			}else{
				$response['status'] = "Failed";
			}
			return $response;
		}
		
		public function getSession(){
		    if (!isset($_SESSION)) {
		        session_start();
		    }
		    $response = array();
		    if(isset($_SESSION['uid']))
		    {
		        $response["uid"] = $_SESSION['uid'];
		        $response["name"] = $_SESSION['name'];
		        $response["email"] = $_SESSION['email'];
		    }
		    else
		    {
		        $response["uid"] = '';
		        $response["name"] = 'Guest';
		        $response["email"] = '';
		    }
		    return $response;
		}

		public function destroySession(){
		    if (!isset($_SESSION)) {
		    session_start();
		    }
		    if(isSet($_SESSION['uid']))
		    {
		        unset($_SESSION['uid']);
		        unset($_SESSION['name']);
		        unset($_SESSION['email']);
		        $info='info';
		        if(isSet($_COOKIE[$info]))
		        {
		            setcookie ($info, '', time() - $cookie_time);
		        }
		        $msg="Logged Out Successfully...";
		    }
		    else
		    {
		        $msg = "Not logged in...";
		    }
		    return $msg;
		}
		public function getUser($user_id){
			$response = array();
			try {
				$stmt = $this->conn->prepare("SELECT * FROM `user` WHERE id=:user_id");
			    $stmt->bindParam(':user_id',$user_id);

			    $stmt->execute();

			    $isUserExists = $stmt->fetch(PDO::FETCH_ASSOC);
			    if ($isUserExists != NULL) {
				    $user = array('first_name' => $isUserExists["first_name"],
				    			  'last_name' => $isUserExists["last_name"],
				    			  'user_name' => $isUserExists["username"],
				    			  'email' => $isUserExists["email"],
				    			  'password' => $isUserExists["password"],
				    			  'phone_number' => $isUserExists["phone_number"]);
				    $response["status"] = "success";
				    $response["message"] = "user is retrived successfully";
				    $response["user"] = $user;
			    }

			} catch (PDOException $e) {
				$response["status"] = "Failed";
				$response["message"] = $e->getMessage();
			}
			return $response;
		}

		public function updateUser($user_id,$first_name,$last_name,$username,$email,$phone_number,$new_password,$old_password)
		{
			$response = array();
			// INSERT INTO user (first_name, last_name, username,email,phone_number,password)
			// 	    						VALUES (:first_name, :last_name,:username, :email, :phone_number,:password)"
			try {
				$stmt = $this->conn->prepare("SELECT 1 FROM `user` WHERE username=:username and id != :id" );
				// or email=:email or phone_number=:phone_number 
			    $stmt->bindParam(':id',$user_id);
			    $stmt->bindParam(':username',$username);
			    $stmt->execute();

			    $isUserExists = $stmt->fetch(PDO::FETCH_ASSOC);
			    if ($isUserExists != NULL) {
			    	$response["status"] = "Failed";
			    	$response["message"] = "username already exists";
			    	return $response;
			    }

				$stmt = $this->conn->prepare("SELECT 1 FROM `user` WHERE email=:email and id != :id");
				// or phone_number=:phone_number 
			    $stmt->bindParam(':id',$user_id);
			    $stmt->bindParam(':email',$email);
			    $stmt->execute();

			    $isUserExists = $stmt->fetch(PDO::FETCH_ASSOC);
			    if ($isUserExists != NULL) {
			    	$response["status"] = "Failed";
			    	$response["message"] = "email already exists";
			    	return $response;
			    }

				$stmt = $this->conn->prepare("SELECT 1 FROM `user` WHERE phone_number=:phone_number and id != :id");
				//  

			    $stmt->bindParam(':id',$user_id);
			    $stmt->bindParam(':phone_number',$phone_number);
			    $stmt->execute();

			    $isUserExists = $stmt->fetch(PDO::FETCH_ASSOC);
			    if ($isUserExists != NULL) {
			    	$response["status"] = "Failed";
			    	$response["message"] = "username or email or phone_number already exists";
			    	return $response;
			    }
			    $stmt = $this->conn->prepare("SELECT * FROM `user` WHERE id=".$user_id);
			    $stmt->execute();

			    $isUserExists = $stmt->fetch(PDO::FETCH_ASSOC);

			    if ($isUserExists != NULL) {
			    	if (passwordHash::check_password($isUserExists['password'],$old_password)) {
			    		if ($new_password != "") {
			    			$new_password = passwordHash::hash($new_password);
			    		$stmt = $this->conn->prepare("UPDATE user SET first_name=:first_name , last_name=:last_name , username=:username, email=:email, phone_number=:phone_number ,password=:password WHERE id=:id");
						    $stmt->bindParam(':first_name',$first_name);
						    $stmt->bindParam(':last_name',$last_name);
						    $stmt->bindParam(':username',$username);
						    $stmt->bindParam(':email',$email);
						    $stmt->bindParam(':phone_number',$phone_number);
						    $stmt->bindParam(':password',$new_password);
			 				$stmt->bindParam(':id',$user_id);
			    		}else{
			    			$stmt = $this->conn->prepare("UPDATE user SET first_name=:first_name , last_name=:last_name , username=:username, email=:email, phone_number=:phone_number WHERE id=:id");
						    $stmt->bindParam(':first_name',$first_name);
						    $stmt->bindParam(':last_name',$last_name);
						    $stmt->bindParam(':username',$username);
						    $stmt->bindParam(':email',$email);
						    $stmt->bindParam(':phone_number',$phone_number);
			    			$stmt->bindParam(':id',$user_id);
			    		}

			    			// execute the query
						if ($stmt->execute()) {
			    			$response["status"] = "success";
			    			$response["message"] =" records UPDATED successfully";
						}
			    	}else{
			    			$response["status"] = "Failed";
			    			$response["message"] ="Wrong old password";
						
			    	}
			    }
				    // Prepare statement


			} catch (PDOException $e) {
				$response["status"] = "Failed";
				$response["message"] = $e->getMessage();
			}
			# code...
			return $response;
		}
		/*
			author: Eslam Ebrahim

			description:
				this function handles the operation of replying an invitation
				assuming that the invitee_username is valid from submitting the invitation, the owner of the auction
				submits his reply either "accept" or "reject"

				in either cases the record of the invitation is deleted
				but in the accept state, the user joins the auction by inserting an initital bid for the user with initial
				price 0.0 that can be changed when user submits his bid in the auction

				there is a case that the reply is neither "accept" nor "reject"
				at this case, the record of the invitaton is not dropped and return in the message that the reply was not valid
			input:
				 $inviter_id : the id of the user who invites the invitee to the auction
				 $invitee_username : the username of the invitee
				 $auction_id : the id of the auction on which the inviter sent the invitation to the invitee
				 $reply : the auction's owner reply on the invitation
			output:
				$response["status"] : the status of the operation
				$response["message"] : describes the status further more
		*/
		public function reply_invitation($inviter_id,$invitee_username,$auction_id,$reply)
		{
			$response = array();
			try {
				$statement = $this->conn->prepare("SELECT * FROM `user` WHERE username=:uname");
				$statement->bindParam(':uname',$invitee_username);
				$statement->execute();

				$user_data = $statement->fetch(PDO::FETCH_ASSOC);

				$invitee_id = $user_data['id'];

				echo $user_data['id'];

				$isInvitationExist = $this->conn->query("SELECT COUNT(*) FROM `auctioninvitation` WHERE inviter_id=".$inviter_id." AND invitee_id=".$invitee_id." AND auction_id=".$auction_id)->fetchColumn();
				if($isInvitationExist > 0)
				{
					if($reply == "accept")
					{
						$drop_invitation = $this->conn->prepare("DELETE FROM `auctioninvitation` WHERE inviter_id=:inviter AND invitee_id=:invitee AND auction_id=:auction");
						$drop_invitation->bindParam(':inviter',$inviter_id);
						$drop_invitation->bindParam(':invitee',$invitee_id);
						$drop_invitation->bindParam(':auction',$auction_id);

						$res = $drop_invitation->execute();

						if($res != NULL)
						{
							$stmt = $this->conn->prepare("INSERT INTO `bid` ( auction_id, user_id, price) VALUES (:auction , :invitee , 0.0)");
							$stmt->bindParam(':auction',$auction_id);
							$stmt->bindParam(':invitee',$invitee_id);

							$output = $stmt->execute();
							if($output != NULL)
							{
								$response["status"] = "success";
								$response["message"] = "invitation accepted successfully";
							}
							else
							{
								$response["status"] = "failed";
								$response["message"] = "Error in accepting invitation";
							}
						}
						else
						{
							$response["status"] = "failed";
							$response["message"] = "Error in deleting the invitation after accepting";
						}
					}
					elseif($reply == "reject") 
					{
						$drop_invitation = $this->conn->prepare("DELETE FROM `auctioninvitation` WHERE inviter_id=:inviter AND invitee_id=:invitee AND auction_id=:auction");
						$drop_invitation->bindParam(':inviter',$inviter_id);
						$drop_invitation->bindParam(':invitee',$invitee_id);
						$drop_invitation->bindParam(':auction',$auction_id);

						$res = $drop_invitation->execute();

						if($res != NULL)
						{
							$response["status"] = "success";
							$response["message"] = "invitation rejected successfully";
						}
						else
						{
							$response["status"] = "failed";
							$response["message"] = "Error in deleting the invitation after rejecting";
						}
					}
					else
					{
						$response["status"] = "failed";
						$response["message"] = "Error in the sent reply";
	 				}

				}
				else
				{
					$response["status"] = "failed";
					$response["message"] = "auction invitation not found";
				}
				return $response;
			} catch (Exception $e) {
				return "Error: ".$e->getMessage();
			}
		}

	}
	/*
	$var = new RegisteredUser();
	print_r($var->reply_invitation(1,"Ali",1,"reject"));
	*/
	// $s = new RegisteredUser();
	// print_r($s->islogged());
	// // session_start();
	// if (isset($_SESSION['uid'])) {
	// 	echo "stringvvvvvvvvvvvvvvvvvvvvvvvv";
	// }
	// print_r($_SESSION)

 ?>