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


			$this->conn = new PDO("mysql:host=localhost;dbname=Mazadna", "root", "");
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			
		}

	function searchByCategory($categoryId){
			//do the code here
			$response1 = array();
			
			try {
				if($categoryId != 0){
					$sql = "SELECT * FROM `auction` WHERE category_id = '$categoryId' and privacy = 'Public' ";
				}
				else{
					$sql = "SELECT * FROM `auction` WHERE  privacy = 'Public' ";
				}

				$result = $this->conn->query($sql);
				$i=0;

				if ($result) {

				    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				    	$auction_id = $row['id'];
				 		$private=$row['privacy'];

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
				        'image' => $row['image'],
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

	public function submit_rating($user_id,$auction_id,$description,$stars)
		{
			$response = array();
			try {
				$isRatingExist = $this->conn->query("SELECT count(*) FROM `auctionrating` WHERE auction_id= ".$auction_id." and user_id = ".$user_id." ")->fetchColumn();
				$response["count"]=$isRatingExist;
 				if($isRatingExist > 1)
 				{
 					$response["status"] = "failed";
 					$response["message"] = "rating already exist";
				}
 				else
 				{
 					$stmt = $this->conn->prepare("INSERT INTO `auctionrating` (auction_id,user_id,description,numofstars) VALUES (:auction , :user , :description , :stars)");
 					$stmt->bindParam(':auction',$auction_id);
 					$stmt->bindParam(':user',$user_id);
 					$stmt->bindParam(':description',$description);
 					$stmt->bindParam(':stars',$stars);
 
 					$res = $stmt->execute();
 					if($res != NULL)
 					{
 						$response["status"] = "success";
 						$response["message"] = "rating submitted successfully";
 					}
 					else
 					{
 						$response["status"] = "failed";
 						$response["message"] = "Error in submitting rating";
 					}
 				}
 				return $response;

 			} catch (Exception $e) {
 				return "Error: ".$e->getMessage();
 			}
 		}
 

	function viewAuction($auction_id){
			//do the code here
			$response = array();
			try {
				$stmt = $this->conn->prepare("SELECT * FROM `auction` WHERE id=:auction_id");
			    $stmt->bindParam(':auction_id',$auction_id);

			    $stmt->execute();

			    $temp = $stmt->fetch(PDO::FETCH_ASSOC);
			    if ($temp != NULL) {
				    $response["status"] = "success";
				    $response["message"] = "auction is retrived successfully";
				    $response["auction"] = $temp;
	
					$stmt = $this->conn->prepare("SELECT * FROM `bid` WHERE auction_id=:auction_id ORDER BY price DESC");
				    $stmt->bindParam(':auction_id',$auction_id);

				    $stmt->execute();
			    	$response["bid"] = array();
			    	$response["userNames"] = array();
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$userId = $row['user_id'];
						array_push($response["bid"], $row);
				    $res2 = $this->conn->query("SELECT username FROM `user` WHERE id=".$userId." ")->fetchColumn();;
				    	array_push($response["userNames"],$res2);
					 	
					 } 
			    	
			    	$stmt = $this->conn->prepare("SELECT * FROM `auctionrating` WHERE auction_id=:auction_id ORDER BY numofstars DESC");
				    $stmt->bindParam(':auction_id',$auction_id);

				    

				    $stmt->execute();
			    	$response["ratings"] = array();
					while($temp = $stmt->fetch(PDO::FETCH_ASSOC)){
						array_push($response["ratings"], $temp);
					}
			    	//=====================================
			    	$res = $this->conn->query("SELECT count(*) FROM `auctionrating` WHERE auction_id= '.$auction_id.' and numofstars = 5")->fetchColumn();;
				    $response["number_of_five_stars"] = $res;

			    	//=====================================
					$res = $this->conn->query("SELECT count(*) FROM `auctionrating` WHERE auction_id=".$auction_id." and numofstars = 4")->fetchColumn();;
				    $response["number_of_four_stars"] = $res;

			    	//=====================================
					$res = $this->conn->query("SELECT count(*) FROM `auctionrating` WHERE auction_id=".$auction_id." and numofstars = 3")->fetchColumn();;
				    $response["number_of_three_stars"] = $res;

			    	//=====================================
					$res = $this->conn->query("SELECT count(*) FROM `auctionrating` WHERE auction_id=".$auction_id." and numofstars = 2")->fetchColumn();;
				    $response["number_of_two_stars"] = $res;
			    	//=====================================
					$res = $this->conn->query("SELECT count(*) FROM `auctionrating` WHERE auction_id=".$auction_id." and numofstars = 1")->fetchColumn();;
				    $response["number_of_one_stars"] = $res;
			    	//=====================================
					$res = $this->conn->query("SELECT count(*) FROM `auctionrating` WHERE auction_id=".$auction_id)->fetchColumn();;
			    	$response["number_of_users"] = $res;
			    }else{
			    	$response['status'] = "Failed";
			    	$response['message'] = "auction not found";
			    }

			}catch(PDOException $e) {
			   $response['status'] = 'Failed';
			   $response['message'] = $e->getMessage();   
			}
		return $response;
	}

	function joinAuction($auctionID,$userID){
         $response = array();	
         // $userID = 1;
        try{
			    $stmt = "SELECT COUNT(*) FROM `bid` WHERE auction_id = ".$auctionID." and user_id = ".$userID." ";

			    $temp = $this->conn->query($stmt);
                $exist = $temp->fetch(PDO::FETCH_ASSOC);
                $response['id']=$exist;
                $response['id1']=$userID;
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
			$now = date_create();
			$now = date_create($now,"Y-m-d H:i:s");
			if ($end_time < $now || $start_time < $now) {
				# code...
				$response["status"] = "failed";
			    $response["message"] = "Failed to create auction. the end_time or start_time is old";

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
				
				$sql = "DELETE FROM auctionrating WHERE auction_id=".$auction_id;
				$this->conn->exec($sql);
				$sql = "DELETE FROM bid WHERE auction_id=".$auction_id;	
				$this->conn->exec($sql);
				$sql = "DELETE FROM auction WHERE id=".$auction_id;	
				$this->conn->exec($sql);
				$response["status"] = "success";
				$response["message"] = "Auction deleted successfully";
				
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

		function getMyAuctions($user_id){
			//do the code here
			$response1 = array();
			
			try {
				$sql = "SELECT * FROM `auction` WHERE user_id = '$user_id' ";
				
				$result = $this->conn->query($sql);
				$i=0;

				if ($result) {

				    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				    	$auction_id = $row['id'];
				 		$private=$row['privacy'];

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

		
		public function submit_bid($user_id,$auction_id,$price)
		{
			$response = array();
			try {
				$isBidExist = $this->conn->query("SELECT COUNT(*) FROM `bid` WHERE user_id=".$user_id." AND auction_id=".$auction_id." ")->fetchColumn();
				if($isBidExist > 1)
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


					$stmt = $this->conn->prepare("UPDATE `bid` SET price=:price WHERE user_id=:user AND $auction_id=:auction");
					$stmt->bindParam(':price',$price);
					$stmt->bindParam(':user',$user_id);
					$stmt->bindParam(':auction',$auction_id);
					$res = $stmt->execute();

					if($res != NULL)
					{
							//the success status are written up there
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

	// $var = new Auction();
	// print_r($var->searchByCategory(1));
	       // $var = new Auction();
	       // print_r($var->joinAuction(1,5));
?>
	
