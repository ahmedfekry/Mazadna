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
		private $conn;
		
		function __construct($id=0,$name="",$categoryId=0,$ownerId=0)
		{
			# code...
			$this->id = $id;
			$this->name = $name;
			$this->categoryId = $categoryId;
			$this->ownerId = $ownerId;
			$this->conn = new PDO("mysql:host=localhost;dbname=mazadna", "root", "");
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
				 		$onsite ="online";
				        $private="public";

				         if($row['on_site'] == 1)
				                             $onsite="onsite";
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
				        $auction = array('auction_id'=>$auction_id,'username'=>$name,'item' => $item_name,'start_time' => $row['start_time'],'duration' => $row['duration'],'status' => "success",'massege'=>"this is auction",'highest_bid_id'=>$row['highest_bid_id'],'highest_bider_id'=>$row['highest_bider_id'],'category_id'=>$row['category_id'],
				        'onsite'=>$onsite,'privacy'=>$private);
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
				 		$onsite ="online";
				        $private="public";

				         if($row['on_site'] == 1)
				                             $onsite="onsite";
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
				        $auction = array('username'=>$name,'item' => $item_name,'start_time' => $row['start_time'],'duration' => $row['duration'],'status' => "success",'massege'=>"this is auction",'highest_bid_id'=>$row['highest_bid_id'],'highest_bider_id'=>$row['highest_bider_id'],'category_name'=>$category_name,
				        'onsite'=>$onsite,'privacy'=>$private);
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

}

 ?>