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
			$this->conn = new PDO("mysql:host=localhost;dbname=mazadna", "root", "Ahmed2512011");
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
		
		/*
			author: Eslam Ebrahim

			description:
				this function handles the operation of submitting a report on a user
				the function takes the id of both the reporter and the reported and checks 
				if there is an existing report. if so, the function respond that the report already exist
				if not, the reprot is submitted

			input:
				$reporterID : the id of the user who submits the report
				$reportedID : the id of the user who is being reported

			output:
				$response["status"] : returns the status of the operation
				$response["message"] = describes the status further more
		*/
		public function report_user($reporterID,$reportedID)
		{
			$response = array();
			try {
				$isReportExist = $this->conn->query("SELECT COUNT(*) FROM `userreport` WHERE user_reporter_id=".$reporterID." AND user_reported_id=".$reportedID)->fetchColumn();
				if($isReportExist > 0)
				{
					$response["status"] = "failed";
					$response["message"] = "report already exist";
				}
				else
				{
					$stmt = $this->conn->prepare("INSERT INTO `userreport` (user_reporter_id , user_reported_id) VALUES (:reporter , :reported)");
					$stmt->bindParam(':reporter',$reporterID);
					$stmt->bindParam(':reported',$reportedID);

					$res = $stmt->execute();
					if($res > 0)
					{
						$response["status"] = "success";
						$response["message"] = "report submitted successfully";
					}
					else
					{
						$response["status"] = "failed";
						$response["message"] = "failed to submit report";
					}
				}
				return $response;
			} catch (Exception $e) {
				return "Error: ".$e->getMessage();
			}
		}

	}

	/*
	$var = new RegisteredUser();
	print_r($var->report_user(1,2));
	*/
	// $s = new RegisteredUser();
	// print_r($s->islogged());
	// // session_start();
	// if (isset($_SESSION['uid'])) {
	// 	echo "stringvvvvvvvvvvvvvvvvvvvvvvvv";
	// }
	// print_r($_SESSION)

 ?>