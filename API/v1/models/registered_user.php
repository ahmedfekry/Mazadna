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

		public function updateUser($first_name,$last_name,$username,$email,$phone_number,$new_password,$old_password)
		{
			$response = array();
			// INSERT INTO user (first_name, last_name, username,email,phone_number,password)
			// 	    						VALUES (:first_name, :last_name,:username, :email, :phone_number,:password)"
			try {
				$stmt = $this->conn->prepare("SELECT 1 FROM `user` WHERE username=:username and id != 4");
				// or email=:email or phone_number=:phone_number 
			    $stmt->bindParam(':username',$username);
			    $stmt->execute();

			    $isUserExists = $stmt->fetch(PDO::FETCH_ASSOC);
			    if ($isUserExists != NULL) {
			    	$response["status"] = "Failed";
			    	$response["message"] = "username already exists";
			    	return $response;
			    }

				$stmt = $this->conn->prepare("SELECT 1 FROM `user` WHERE email=:email and id != 4");
				// or phone_number=:phone_number 
			    $stmt->bindParam(':email',$email);
			    $stmt->execute();

			    $isUserExists = $stmt->fetch(PDO::FETCH_ASSOC);
			    if ($isUserExists != NULL) {
			    	$response["status"] = "Failed";
			    	$response["message"] = "email already exists";
			    	return $response;
			    }

				$stmt = $this->conn->prepare("SELECT 1 FROM `user` WHERE phone_number=:phone_number and id != 4");
				//  
			    $stmt->bindParam(':phone_number',$phone_number);
			    $stmt->execute();

			    $isUserExists = $stmt->fetch(PDO::FETCH_ASSOC);
			    if ($isUserExists != NULL) {
			    	$response["status"] = "Failed";
			    	$response["message"] = "username or email or phone_number already exists";
			    	return $response;
			    }
			    $stmt = $this->conn->prepare("SELECT * FROM `user` WHERE id=4");
			    $stmt->execute();

			    $isUserExists = $stmt->fetch(PDO::FETCH_ASSOC);

			    if ($isUserExists != NULL) {
			    	if (passwordHash::check_password($isUserExists['password'],$old_password)) {
			    		if ($new_password != "") {
			    			$new_password = passwordHash::hash($new_password);
			    		$stmt = $this->conn->prepare("UPDATE user SET first_name=:first_name , last_name=:last_name , username=:username, email=:email, phone_number=:phone_number ,password=:password WHERE id=4");
						    $stmt->bindParam(':first_name',$first_name);
						    $stmt->bindParam(':last_name',$last_name);
						    $stmt->bindParam(':username',$username);
						    $stmt->bindParam(':email',$email);
						    $stmt->bindParam(':phone_number',$phone_number);
						    $stmt->bindParam(':password',$new_password);
			    		}else{
			    			$stmt = $this->conn->prepare("UPDATE user SET first_name=:first_name , last_name=:last_name , username=:username, email=:email, phone_number=:phone_number WHERE id=4");
						    $stmt->bindParam(':first_name',$first_name);
						    $stmt->bindParam(':last_name',$last_name);
						    $stmt->bindParam(':username',$username);
						    $stmt->bindParam(':email',$email);
						    $stmt->bindParam(':phone_number',$phone_number);
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
	}

	// $user = new RegisteredUser();
	// $response = $user->updateUser("Fekry","mohammed","username","email","phone_number","","12345");
	// print_r($response);
	// echo passwordHash::check_password("$2a$10$7e4ec9a878ea1bf77b636u9AYucfBvMf718v6Z4Y3QuU/dg3yoJm2","12345");

 ?>