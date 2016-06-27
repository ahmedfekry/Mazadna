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
				this function handles the operation of submitting a bid from a user into an auction
				assuming that any user that in an auction has an initial bid
				this function just updates the user's bid
				then we check if that bid is the highest bid. if so, then the highest bid id and 
				highest bider id is updates in the auction record

				if the highest bid id is NULL, that means this bid is the first one and it's submitted as the
				highest bid for the auction

				if there is no bid exist for the user in the auction, he's considered that he's not
				registered for the auction

			input:
				$user_id : the id of the user who submits the bid the auction
				$auction_id : the id of the auction that the bid is submitted for
				$price : the amount of money that the user offers in his bid for the auction
			output
				$response["status"] : contains the status of the operation
				$response["message"] : contains the details for the status of the operation
		*/
		public function submit_bid($user_id,$auction_id,$price)
		{
			$response = array();
			try {
				$isBidExist = $this->conn->query("SELECT COUNT(*) FROM `bid` WHERE user_id=".$user_id." AND auction_id=".$auction_id)->fetchColumn();
				if($isBidExist > 0)
				{
					$stmt = $this->conn->prepare("UPDATE `bid` SET price=:price WHERE user_id=:user AND $auction_id=:auction");
					$stmt->bindParam(':price',$price);
					$stmt->bindParam(':user',$user_id);
					$stmt->bindParam(':auction',$auction_id);
					$res = $stmt->execute();

					if($res != NULL)
					{

						$auctionInfo = $this->conn->prepare("SELECT * FROM `auction` WHERE id=:auction");
						$auctionInfo->bindParam(':auction',$auction_id);
						$auctionInfo->execute();

						$auctionRecord = $auctionInfo->fetch(PDO::FETCH_ASSOC);
						$highest_bid_id = $auctionRecord['highest_bid_id'];

						if($highest_bid_id != NULL)
						{
							$highestBidInfo = $this->conn->prepare("SELECT * FROM `bid` WHERE id=:highest");
							$highestBidInfo->bindParam(':highest',$highest_bid_id);
							$highestBidInfo->execute();

							$highestBidRecord = $highestBidInfo->fetch(PDO::FETCH_ASSOC);
							$highest_bid_price = $highestBidRecord['price'];
							echo $highest_bid_price;
							if($price > $highest_bid_price)
							{
								$userBidInfo = $this->conn->prepare("SELECT * FROM `bid` WHERE auction_id=:auction AND user_id=:user");
								$userBidInfo->bindParam(':auction',$auction_id);
								$userBidInfo->bindParam(':user',$user_id);
								$userBidInfo->execute();
								$userBidRecord = $userBidInfo->fetch(PDO::FETCH_ASSOC);

								$user_bid_id = $userBidRecord['id'];

								$update = $this->conn->prepare("UPDATE `auction` SET highest_bid_id = :bid_id , highest_bider_id=:bider_id WHERE id=:auction_id");
								$update->bindParam(':bid_id',$user_bid_id);
								$update->bindParam(':bider_id',$user_id);
								$update->bindParam(':auction_id',$auction_id);

								$output = $update->execute();
								if($output != NULL)
								{
									$response["status"] = "success";
									$response["message"] = "bid submitted successfully and you are the highest bidder";
								}
								else
								{
									$response["status"] = "failed";
									$response["message"] = "bid submittes successfully and Error in submitting you as the highest bidder";
								}
							}
							elseif($price == $highest_bid_price)
							{
								$response["status"] = "failed";
								$response["message"] = "you submitted a bid equal to the highest bid";
							}
							else
							{
								$response["status"] = "failed";
								$response["message"] = "you submitted a bid less than the highest bid";
							}
						}
						else
						{
							$userBidInfo = $this->conn->prepare("SELECT * FROM `bid` WHERE auction_id=:auction AND user_id=:user");
							$userBidInfo->bindParam(':auction',$auction_id);
							$userBidInfo->bindParam(':user',$user_id);
							$userBidInfo->execute();
							$userBidRecord = $userBidInfo->fetch(PDO::FETCH_ASSOC);

							$user_bid_id = $userBidRecord['id'];

							$update = $this->conn->prepare("UPDATE `auction` SET highest_bid_id = :bid_id , highest_bider_id=:bider_id WHERE id=:auction_id");
							$update->bindParam(':bid_id',$user_bid_id);
							$update->bindParam(':bider_id',$user_id);
							$update->bindParam(':auction_id',$auction_id);

							$output = $update->execute();
							if($output != NULL)
							{
								$response["status"] = "success";
								$response["message"] = "bid submitted successfully and you are the highest bidder";
							}
							else
							{
								$response["status"] = "failed";
								$response["message"] = "bid submittes successfully and Error in submitting you as the highest bidder";
							}
						}
					}
					else
					{
						$response["status"] = "failed";
						$response["message"] = "Error in submitting bid";
					}
				}
				else
				{
					$response["status"] = "failed";
					$response["message"] = "user is not registered in the auction";
				}
				return $response;
			} catch (Exception $e) {
				return "Error".$e->getMessage();
			}
		}

	}
	
	$var = new RegisteredUser();
	print_r($var->submit_bid(2,1,9.9));
	
	// $s = new RegisteredUser();
	// print_r($s->islogged());
	// // session_start();
	// if (isset($_SESSION['uid'])) {
	// 	echo "stringvvvvvvvvvvvvvvvvvvvvvvvv";
	// }
	// print_r($_SESSION)

 ?>