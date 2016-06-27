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
			$this->conn = new PDO("mysql:host=localhost;dbname=mazadna", "root", "Ahmed2512011");
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


		/*
			author: Eslam Ebrahm

			description:
				this functions returns the total number of users in the site
			input:
				NONE
			output:
				$response["usersNum"] : returns the total number of users in the site
		*/
		public function get_users_num()
		{
			$response = array();
			try {
				$response["usersNum"] = $this->conn->query("SELECT COUNT(*) FROM `user` WHERE 1")->fetchColumn();
				return $response;
			} catch (Exception $e) {
				return "Error: ".$e->getMessage();
			}
		}

		/*
			author: Eslam Ebrahm

			description:
				this functions returns the total number of auctions in the site
			input:
				NONE
			output:
				$response["auctionsNum"] : returns the total number of auctions in the site
		*/
		public function get_auctions_num()
		{
			$response = array();
			try {
				$response["auctionsNum"] = $this->conn->query("SELECT COUNT(*) FROM `auction` WHERE 1")->fetchColumn();
				return $response;
			} catch (Exception $e) {
				return "Error: ".$e->getMessage();
			}
		}

		/*
			author: Eslam Ebrahm

			description:
				this functions returns the total number of active auctions in the site
			input:
				NONE
			output:
				$response["auctionsNum"] : returns the total number of active auctions in the site
		*/
		public function get_active_auctions()
		{
			$response = array();
			try {
					$timeStamp = date("Y-m-d H:i:s");
					$response["auctionsNum"] = $this->conn->query("SELECT COUNT(*) FROM `auction` WHERE end_time > '".$timeStamp."'")->fetchColumn();
					return $response;
			} catch (Exception $e) {
				return "Error: ".$e->getMessage();
			}		
		}

		/*
			author: Eslam Ebrahm

			description:
				this functions returns the total number of completed auctions in the site
			input:
				NONE
			output:
				$response["auctionsNum"] : returns the total number of completed auctions in the site
		*/
		public function get_complete_auctions()
		{
			$response = array();
			try {
					$timeStamp = date("Y-m-d H:i:s");
					$response["auctionsNum"] = $this->conn->query("SELECT COUNT(*) FROM `auction` WHERE end_time < '".$timeStamp."'")->fetchColumn();
					return $response;
			} catch (Exception $e) {
				return "Error: ".$e->getMessage();
			}		
		}

		/*
			author: Eslam Ebrahm

			description:
				this functions returns the total sum of prices that has been paid for auctions in the site
			input:
				NONE
			output:
				$response["auctionsNum"] : returns the total sum of prices that has been paid for auctions in the site
		*/
		public function auction_prices_sum()
		{
			$response = array();
			try {
				$stmt = $this->conn->prepare("SELECT * FROM `auction` WHERE 1");
				$stmt->execute();
				$response["auctionsSum"] = 0.0;

				while($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$bidID = $row["highest_bid_id"];

					$stmt2 = $this->conn->prepare("SELECT * FROM `bid` WHERE id=:id");
					$stmt2->bindParam(':id' , $bidID);

					$stmt2->execute();

					$res = $stmt2->fetch(PDO::FETCH_ASSOC);

					$response["auctionsSum"] = $response["auctionsSum"]  + $res["price"];
				}
				return $response;
			} catch (Exception $e) {
				return "Error: ".$e->getMessage();
			}
		}
	}
	/*$var = new Admin();
	print_r($var->auction_prices_sum());*/

 ?>
