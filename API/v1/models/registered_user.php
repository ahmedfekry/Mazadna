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
			            $_SESSION['first_name'] = $first_name;
			            $_SESSION['last_name'] = $last_name;
			            $_SESSION['username'] = $username;
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
				    	if (!isset($_SESSION)) {
				            session_start();
			            }
			            $_SESSION['uid'] = $isUserExists["id"];
			            $_SESSION['first_name'] = $isUserExists["first_name"] ;
			            $_SESSION['last_name'] = $isUserExists["last_name"];
			            $_SESSION['username'] = $isUserExists["username"];
			            $_SESSION['email'] = $isUserExists["email"];
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

		public function deactivate_account($id)
		{
			$response = array();
			try {
				$stmt = $this->conn->prepare("UPDATE `user` SET deactivated=1 WHERE id=:id");
				$stmt->bindParam(':id' , $id);
				if($stmt->execute())
				{
					$response["status"] = "success";
					$response["message"] = "account deactivated successfully !";
					return $response;
				}
				else
				{
					$response["status"] = "fail";
					$response["message"] = "ERROR";
					return $response;
				}
			} catch (Exception $e) {
				return "Error: ".$e->getMessage();
			}
		}

		public function delete_account($id)
		{
			$response = array();
			try {

				//delete user's auction invitations

				$stmt = "DELETE FROM `auctioninvitation` WHERE inviter_id=".$id." OR invitee_id=".$id;
				$this->conn->exec($stmt);

				//delete user's auction review

				$stmt = "DELETE FROM `auctionreview` WHERE user_id=".$id;
				$this->conn->exec($stmt);


				//delete user's bids
				$stmt = "DELETE FROM `bid` WHERE user_id=".$id;
				$this->conn->exec($stmt);

				//delete user's requests
				$stmt = "DELETE FROM `reqest` WHERE user=".$id;
				$this->conn->exec($stmt);


				//delete user's auctions
				$stmt = "DELETE FROM `auction` WHERE user_id=".$id;
				$this->conn->exec($stmt);

				//delete users followers and following relations
				$stmt = "DELETE FROM `following` WHERE follower_id=".$id." OR being_followd_id=".$id;
				$this->conn->exec($stmt);

				//delete user's reports made by him or on him
				$stmt = "DELETE FROM `userreport` WHERE user_reported_id=".$id." OR user_reporter_id=".$id;
				$this->conn->exec($stmt);

				//delete user's reviews on him or made by him
				$stmt = "DELETE FROM `userreview` WHERE reviewer_id=".$id;
				// $stmt->bindParam(':uid' , $id);
				$this->conn->exec($stmt);

				//delete user's record in database
				$stmt = "DELETE FROM `user` WHERE id=".$id;
				$this->conn->exec($stmt);

				$response["status"] = "success";
				$response["message"] = "account deleted successfully !";
				return $response;
			} catch (Exception $e) {
				return "Error: ".$e->getMessage();
			}
		}

		public function follow_user($followerId,$followedId)
		{
			$response = array();
			try {

				$isFollowExist = $this->conn->query("SELECT COUNT(*) FROM `following` WHERE follower_id=".$followerId." AND being_followd_id=".$followedId)->fetchColumn();
				if($isFollowExist > 0)
				{
					$response["status"] = "fail";
					$response["message"] = "follow already exists";
				}
				else
				{
					$stmt = $this->conn->prepare("INSERT INTO `following` (follower_id , being_followd_id) VALUES (:follower,:followed)");
					$stmt->bindParam(':follower',$followerId);
					$stmt->bindParam(':followed',$followedId);

					$result = $stmt->execute();
					if($result != NULL)
					{
						$response["status"] = "success";
						$response["message"] = "follow is done";
					}
					else
					{
						$response["status"] = "fail";
						$response["message"] = "ERROR";
					}
				}
				return $response;
			} catch (Exception $e) {
				return "Error: ".$e->getMessage();
			}
		}


	}
	/*$var = new RegisteredUser();
	print_r($var->follow_user(1,2));*/
 ?>