<?php 
    
     class Auction{
       
        private $conn;
       
        public function __construct(){
        $this->conn = new PDO("mysql:host=localhost;dbname=Mazadna", "root", "91013");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function getdata()
        {
            $response1 = array(); 
            
        try
        {
            $stmt = "SELECT * FROM auction";
            $result=$this->conn->query($stmt);
            $i=0;

         if($stmt){
         while($row = $result->fetch(PDO::FETCH_ASSOC)) 
         {   
         $onsite ="online";
         $private="public";

         if($row['on_site'] == 1)
                             $onsite="onsite";
         if($row['privacy'] == 1)
                             $private="private";
        $id = $row['id'];
        $user_id = $row['user_id'];

        $stmt ="select username from user where id ='". str_replace('\\','\\\\',$user_id) . "'";
        $result1=$this->conn->query($stmt);
        $temp = $result1->fetch(PDO::FETCH_ASSOC);
        $name =$temp['username'];

        $stmt ="select name from item where auction_id ='". str_replace('\\','\\\\',$id) . "'";
        $result2=$this->conn->query($stmt);
        $temp2 = $result2->fetch(PDO::FETCH_ASSOC);
        $item_name =$temp2['name'];

        $auction = array('id'=>$id,
        'username'=>$name,
        'item' => $item_name,
        'start_time' => $row['start_time'],
        'duration' => $row['duration'],
        'status' => "success",
        'massege'=>"this is auction",
        'highest_bid_id'=>$row['highest_bid_id'],
        'highest_bider_id'=>$row['highest_bider_id'],
        'category_id'=>$row['category_id'],
        'onsite'=>$onsite,
        'privacy'=>$private);
         
         $response1[$i] = $auction;
         $i++; 
        }
        return $response1;
        }

        else
        {
            $Auction->setstatus = "error";
            $Auction->setmassege = "empty!";
            $response1[$i] = $Auction;
            return $response1;
        }
    }  
    catch(PDOException $e) 
    {
                return "Error: " . $e->getMessage();
            }
                   
    
     }
 }
?>