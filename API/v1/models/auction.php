<?php 
	/**
	* 
	*/
	class Auction 
	{
		private $id;
		private $name;
		private $categoryId;
		private $ownerId;
		function __construct($id=0,$name="",$categoryId=0,$ownerId=0)
		{
			# code...
			$this->$id = $id;
			$this->$name = $name;
			$this->$categoryId = $categoryId;
			$this->$ownerId = $ownerId;
			$this->conn = new PDO("mysql:host=localhost;dbname=Mazadna", "root", "Ahmed2512011");
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}


		public function create_auction($user_id,$duration,$price,$privacy)
		{
			$response = array();
			try {
				$stmt = $this->conn->prepare("INSERT INTO auction (user_id, duration, p, privacy)
				VALUES (:id, :dur, :pr, :priv)");
				$stmt->bindParam(':id' , $user_id);
				$stmt->bindParam(':dur' , $duration);
				$stmt->bindParam(':pr' , $price);
				$stmt->bindParam(':priv' , $privacy);

				$result = $stmt->execute();
				if($result != NULL){
					$response["status"] = "success";
					$response["message"] = "auction submitted successfully !";
					
				}else{
					$response["status"] = "error";
					$response["message"] = "failed to submit auction.";
				}
				return $response;
			} catch (PDOException $e) {
				return "Error: " . $e->getMessage();
			}
		}

		public function setId($id)
		{
			$this->$id = $id;
		}
		public function setName($name)
		{
			$this->$name = $name;
		}

		public function getId()
		{
			return $id;
		}
		public function getName()
		{
			return $name;
		}
		
		public function setCategoryId($categoryId)
		{
			$this->$categoryId = $categoryId;
		}

		public function getCategoryId()
		{
			return $categoryId;
		}

		public function setOwnerId($ownerId)
		{
			$this->$ownerId = $ownerId;
		}

		public function getOwnerId()
		{
			return $ownerId;
		}

	}


 ?>