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

		public function sign_in2()
		{
			$response = array();
			try {
				$stmt = $this->conn->query("SELECT LAST(*) FROM `user` ");
			    $stmt->execute();

			    $isUserExists = $stmt->fetch(PDO::FETCH_ASSOC);
			    if ($isUserExists != NULL) {
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
		
		public function view_user_profile($id)
		{
			$response =array();
			try {

				$stmt = $this->conn->prepare("SELECT * FROM `user` WHERE id=:uid");
			    $stmt->bindParam(':uid',$id);

			    $stmt->execute();

			    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

			    if($userInfo != NULL)
			    {
			    	$response["userStatus"] = "success";
			    	$response["userInfo"]["id"] = $userInfo['id'];
			    	$response["userInfo"]["username"] = $userInfo['username'];
			    	$response["userInfo"]["email"] = $userInfo['email'];
			    	$response["userInfo"]["phoneNumber"] = $userInfo['phone_number'];
			    	$response["userInfo"]["firstName"] = $userInfo['first_name'];
			    	$response["userInfo"]["lastName"] = $userInfo['last_name'];
			    	$response["userInfo"]["image"] = $userInfo['image'];
			    	$response["userInfo"]["commuliteveStars"] = $userInfo['commuliteve_stars'];

			    	$numOfRows = $this->conn->query("SELECT COUNT(*) FROM `auction` WHERE user_id=".$id)->fetchColumn();

					if($numOfRows > 0)
					{
						$response["auctionStatus"] = "success";
						$response["message"] = "user found auctions found";
						$stmt = $this->conn->prepare("SELECT * FROM `auction` WHERE user_id=:userid");
						$stmt->bindParam(':userid' , $id);

						$stmt->execute();

						$response["auctions"] = array();
						while($row = $stmt->fetch(PDO::FETCH_ASSOC))
						{
							//print_r($row);

							array_push($response["auctions"], $row);
						}
						return $response;
					}
					else
					{
						$response["auctionStatus"] = "failed";
						$response["message"] = "No auction(s) found";
						return $response;
					}
			    }
			    else{
			    	$response["userStatus"] = "failed";
			    	$response["message"] = "No user found";
			    	return $response;
			    }
				
			} catch (Exception $e) {
				return "Error: ".$e->getMessage();
			}
		}

		public function checkIfFollow($user1_id,$user2_id)
		{
			$response = array();
			try {
				$stmt = $this->conn->prepare("SELECT * FROM `following` WHERE being_followd_id=:user1_id and follower_id=:user2_id");
			    $stmt->bindParam(':user1_id',$user1_id);
			    $stmt->bindParam(':user2_id',$user2_id);

			    $stmt->execute();

			    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
			    if ($userInfo != null) {
			    	# code...
			    	$response['status'] = 'success';
			    	$response['message'] = 'isfollowers';
			    }else{
			    	$response['status'] = 'success';
			    	$response['message'] = 'isnotfollowers';

			    }
			} catch (PDOException $e) {
				$response['status'] = "Failed";
				$response['message'] = $e->getMessage();
			}
			# code...
			return $response;
		}

	}

	// $s = new RegisteredUser();
	// print_r($s->checkIfFollow(1,2));
	// // session_start();
	// if (isset($_SESSION['uid'])) {
	// 	echo "stringvvvvvvvvvvvvvvvvvvvvvvvv";
	// }
	// print_r($_SESSION)

 ?>