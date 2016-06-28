<?php

	/*
	require_once 'user.php';
	*/
	class Admin
	{
		private $id;
		private $username;
		private $password;
		private $conn;

		public function  __construct($id='',$username='',$password='')
		{
			$this->id = $id;
			$this->username = $username;
			$this->password = $password;
			$this->conn = new PDO("mysql:host=localhost;dbname=Mazadna", "root", "");
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}

		function sign_in($username,$password){
			//do the code here
			$response = array();
			try {
				$stmt = $this->conn->prepare("SELECT * FROM `admin` WHERE username=:username");
			    $stmt->bindParam(':username',$username);

			    $stmt->execute();

			    $isUserExists = $stmt->fetch(PDO::FETCH_ASSOC);
			    if ($isUserExists != NULL) {
			    	if ($isUserExists['password']) {
			    		# code...
				    	$response["status"] = "success";
				    	$response["message"] = "Loging successfully";
				    	$response["uid"] = $isUserExists['id'];
				    	if (!isset($_SESSION)) {
				            session_start();
			            }
			            $_SESSION['aid'] = $isUserExists["id"];
			            $_SESSION['username'] = $isUserExists["username"];
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
	}


 ?>
