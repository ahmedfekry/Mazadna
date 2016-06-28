<?php 
	class Auction 
	{
		private $user_id;
		private $description;
		private $start_time;
		private $end_time;
		private $privacy;
		private $title;
		private $category_id;
		private $highest_bid_id;
		private $highest_bider_id;
		private $starting_price;
		private $conn;
		function __construct($id=0,$user_id=0,$description="",$start_time=0,$end_time=0,$privacy="public",
							$title="",$category_id=0,$highest_bid_id=0,$highest_bider_id=0,$starting_price=0,$description="")
		{
			# code...
			$this->id = $id;
			$this->user_id = $user_id;
			$this->description = $description;
			$this->start_time = $start_time;
			$this->end_time = $end_time;
			$this->privacy = $privacy;
			$this->title = $title;
			$this->category_id = $category_id;
			$this->highest_bid_id = $highest_bid_id;
			$this->highest_bider_id = $highest_bider_id;
			$this->starting_price = $starting_price;


			$this->conn = new PDO("mysql:host=localhost;dbname=Mazadna", "root", "91013");
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			
		}

		function searchByCategory($categoryId){
			//do the code here
			$response1 = array();
			
			try {

				if($categoryId != 0){
					$sql = "SELECT * FROM `auction` WHERE category_id = '$categoryId' ";
				}
				else{
					$sql = "SELECT * FROM `auction` ";
				}

				$result = $this->conn->query($sql);
				$i=0;

				if ($result) {

				    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				    	$auction_id = $row['id'];
				 		$private="public";

				         if($row['privacy'] == 1)
				                             $private="private";
				        $id = $row['id'];
				        $user_id = $row['user_id'];
				        //get the username
				        $stmt ="select username from user where id ='". str_replace('\\','\\\\',$user_id) . "'";
				        $result1 =$this->conn->query($stmt);
				        $temp = $result1->fetch(PDO::FETCH_ASSOC);
				        $name =$temp['username'];
				        //get the item name
				        $stmt ="select name from item where auction_id ='". str_replace('\\','\\\\',$id) . "'";
				        $result2=$this->conn->query($stmt);
				        $temp2 = $result2->fetch(PDO::FETCH_ASSOC);
				        $item_name =$temp2['name'];
				        //add the results to the an array
				        $auction = array(
				        'id'=>$id,	
				        'username'=>$name,
				        'description'=>$row['description'],
				        'item' => $item_name,
				        'start_time' => $row['start_time'],
				        'end_time' => $row['end_time'],
				        'title' => $row['title'],
				        'starting_price'=>$row['starting_price'],
				        'active' =>$row['active'],
				        'status' => "success",
				        'highest_bid_id'=>$row['highest_bid_id'],
				        'highest_bider_id'=>$row['highest_bider_id'],
				        
				        'privacy'=>$private);
				        //create 2D array

				        $response1[$i] = $auction;
        				$i++; 
				    }
				    return $response1;
				    
				} else {
				    $Auction->setstatus = "error";
		            $Auction->setmassege = "empty!";
		            $response1[$i] = $Auction;
		            return $response1;
				}

			}
			 catch(PDOException $e) {
			    echo "Error: " . $e->getMessage();   
			}
		
	}

	function viewAuction($auctionId){
			//do the code here
			$response1 = array();
			
			try {

				$sql = "SELECT * FROM `auction` WHERE id = '$auctionId' ";				

				$result = $this->conn->query($sql);
				$i=0;

				if ($result) {

				    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				    	$category_id = $row['category_id'];
				 		$private="public";

				         if($row['privacy'] == 1)
				                             $private="private";
				        $id = $row['id'];
				        $user_id = $row['user_id'];
				        //get the username
				        $stmt ="select username from user where id ='". str_replace('\\','\\\\',$user_id) . "'";
				        $result1 =$this->conn->query($stmt);
				        $temp = $result1->fetch(PDO::FETCH_ASSOC);
				        $name =$temp['username'];
				        //get the item name

				        $stmt ="select name from item where auction_id ='". str_replace('\\','\\\\',$id) . "'";
				        $result2=$this->conn->query($stmt);
				        $temp2 = $result2->fetch(PDO::FETCH_ASSOC);
				        $item_name =$temp2['name'];
						//get the item name				        
				        $stmt ="select name from category where id ='". str_replace('\\','\\\\',$category_id) . "'";
				        $result3=$this->conn->query($stmt);
				        $temp3 = $result3->fetch(PDO::FETCH_ASSOC);
				        $category_name =$temp3['name'];
				        //add the results to the an array
				        $auction = array(
				        'id'=>$id,	
				        'username'=>$name,
				        'description'=>$row['description'],
				        'item' => $item_name,
				        'start_time' => $row['start_time'],
				        'end_time' => $row['end_time'],
				        'title' => $row['title'],
				        'starting_price'=>$row['starting_price'],
				        'active' =>$row['active'],
				        'status' => "success",
				        'highest_bid_id'=>$row['highest_bid_id'],
				        'highest_bider_id'=>$row['highest_bider_id'],
				        'category_name'=>$category_name,
				        'privacy'=>$private);
				        //create 2D array

				        $response1[$i] = $auction;
        				$i++; 
				    }
				    return $response1;
				    
				} else {
				    $Auction->setstatus = "error";
		            $Auction->setmassege = "empty!";
		            $response1[$i] = $Auction;
		            return $response1;
				}

			}
			 catch(PDOException $e) {
			    echo "Error: " . $e->getMessage();   
			}
		
	}

	function joinAuction($auctionID,$userID){
         $response = array();	
         // $userID = 1;
        try{
			    $stmt = "SELECT id FROM `bid` WHERE auction_id = '$auctionID' and user_id = '$userID' ";
			    $temp = $this->conn->query($stmt);
                $exist = $temp->fetch(PDO::FETCH_ASSOC);

                if(!$exist){
                	$stmt = "INSERT INTO bid (user_id, auction_id) VALUES ('$auctionID', '$userID')";
                    $result = $this->conn->query($stmt);
                    $response["status"] = "success";
                    $response["message"] = "joined successfully";
                }

			    else{
			    	$response["status"] = "failed";
                    $response["message"] = "already joined";
			       
                }

            return $response;
	        }catch(PDOException $e) {
    			return "Error: " . $e->getMessage();
			}

    }
    public function create($user_id,$description,$title,$starting_price,$privacy,$end_time,$start_time,$category_id)
		{	
			$response = array();
			$start_time = date_create($start_time);	
			$start_time = date_format($start_time,"Y-m-d H:i:s");
			$end_time = date_create($end_time);
			$end_time = date_format($end_time,"Y-m-d H:i:s");
			$active = 1;
			if ($end_time <= $start_time) {
				$response["status"] = "failed";
			    $response["message"] = "Failed to create auction. the end_time is less than the start_time";

			    return $response;
			}

			try {
					$stmt = $this->conn->prepare("INSERT INTO auction (user_id, description, title,starting_price,privacy,end_time,start_time,category_id,active)
				    						VALUES (:user_id, :description,:title, :starting_price, :privacy,:end_time,:start_time,:category_id,:active)");
				    
				    $stmt->bindParam(':user_id', $user_id);
				    $stmt->bindParam(':description', $description);
				    $stmt->bindParam(':title', $title);
				    $stmt->bindParam(':starting_price', $starting_price);
				    $stmt->bindParam(':privacy', $privacy);
				    $stmt->bindParam(':end_time', $end_time);
				    $stmt->bindParam(':start_time', $start_time);
				    $stmt->bindParam(':category_id', $category_id);
				    $stmt->bindParam(':active', $active);

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
		public function delete($auction_id)
		{
			$response = array();
			try {
				
				$sql = "DELETE FROM auction WHERE id=".$auction_id;
				if ($this->conn->exec($sql)) {
					$sql = "DELETE FROM item WHERE auction_id=".$auction_id;	
					$this->conn->exec($sql);
					$response["status"] = "success";
				    $response["message"] = "Auction deleted successfully";
				}else{
					$response["status"] = "failed";
				    $response["message"] = "Failed to delete auction. Please try again";
				}
			} catch (PDOException $e) {
				$response["status"] = "failed";
				$response["message"] = $e->getMessage();
			}
			return $response;
		}

		public function deactivate($auction_id)
		{
			$response = array();
			try {
				$stmt = $this->conn->prepare("UPDATE auction SET active=0 WHERE id=".$auction_id);
				
				if ($stmt->execute()) {
					$response["status"] = "success";
				    $response["message"] = "Auction deactivated successfully";
				}else{
					$response["status"] = "failed";
				    $response["message"] = "Failed to deactivate auction. Please try again";
				}
			} catch (PDOException $e) {
				$response["status"] = "failed";
				$response["message"] = $e->getMessage();
			}
			return $response;
		}
}
?>
	
