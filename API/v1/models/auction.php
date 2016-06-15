<?php 
	class Auction 
	{
		private $id;
		private $user_id;
		private $description;
		private $start_time;
		private $end_time;
		private $on_site;
		private $privacy;
		private $title;
		private $category_id;
		private $highest_bid_id;
		private $highest_bider_id;
		private $starting_price;
		private $conn;
		function __construct($id=0,$user_id=0,$description="",$start_time=0,$end_time=0,$on_site=false,$privacy="public",
							$title="",$category_id=0,$highest_bid_id=0,$highest_bider_id=0,$starting_price=0,$description="")
		{
			# code...
			$this->id = $id;
			$this->user_id = $user_id;
			$this->description = $description;
			$this->start_time = $start_time;
			$this->end_time = $end_time;
			$this->on_site = $on_site;
			$this->privacy = $privacy;
			$this->title = $title;
			$this->category_id = $category_id;
			$this->highest_bid_id = $highest_bid_id;
			$this->highest_bider_id = $highest_bider_id;
			$this->starting_price = $starting_price;


			$this->conn = new PDO("mysql:host=localhost;dbname=Mazadna", "root", "Ahmed2512011");
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			
		}

		public function create($user_id,$description,$title,$starting_price,$privacy,$end_time,$on_site,$category_id)
		{	
			$response = array();
			$start_time = date("Y-m-d H:i:s");
			if ($end_time <= $start_time) {
				$response["status"] = "failed";
			    $response["message"] = "Failed to create auction. the end_time is less than the start_time";

			    return $response;
			}

			try {
					$stmt = $this->conn->prepare("INSERT INTO auction (user_id, description, title,starting_price,privacy,end_time,start_time,on_site,category_id)
				    						VALUES (:user_id, :description,:title, :starting_price, :privacy,:end_time,:start_time,:on_site,:category_id)");
				    
				    $stmt->bindParam(':user_id', $user_id);
				    $stmt->bindParam(':description', $description);
				    $stmt->bindParam(':title', $title);
				    $stmt->bindParam(':starting_price', $starting_price);
				    $stmt->bindParam(':privacy', $privacy);
				    $stmt->bindParam(':end_time', $end_time);
				    $stmt->bindParam(':start_time', $start_time);
				    $stmt->bindParam(':on_site', $on_site);
				    $stmt->bindParam(':category_id', $category_id);

			        $result = $stmt->execute();

			        if ($result != NULL) {
			        	$response["status"] = "success";
			            $response["message"] = "Auction created successfully";
			            $response["auction_id"] = $this->conn->lastInsertId();
			            return $response;
			        } else {
			            $response["status"] = "failed";
			            $response["message"] = "Failed to create auction. Please try again";
			            return $response;
			        }
			    } catch(PDOException $e) {
    			return "Error: " . $e->getMessage();
			}	
			
		}

	}
	// // $user_id,$description,$title,$starting_price,$privacy,$end_time,$on_site,$category_id
	// $var = new Auction();
	// $response = $var->create(4,"firstDDD","title",20,"public",date("2016-06-20 14:44:39"),1,1);
	// if ($response["status"] == "success") {
	// 	echo "string1";
	// } else {
	// 	echo $response["message"]."\n";
	// }
	

 ?>
