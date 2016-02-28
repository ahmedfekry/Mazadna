<?php 
	require_once '../dbHelper.php';
	/**
	* 
	*/
		// owner:'',
		// title:'',
		// starting_price:'',
		// privacy: '',
		// end_date:'',
		// description:''
	class Auction 
	{
		private $id;
		private $owner;
		private $title;
		private $starting_price;
		private $privacy;
		private $end_date;
		private $description;
		function __construct($id=0,$owner=0,$title="",$starting_price=0,$privacy="",$end_date="",$description="")
		{
			# code...
			$this->id = $id;
			$this->owner = $owner;
			$this->title = $title;
			$this->starting_price = $starting_price;
			$this->privacy = $privacy;
			$this->end_date = $end_date;
			$this->description = $description;
			$this->conn = new PDO("mysql:host=localhost;dbname=Mazadna", "root", "Ahmed2512011");
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			
		}
		// $rows = $db->insert("customers_php",array('name' => 'Ipsita Sahoo', 'email'=>'ipi@angularcode.com'), array('name', 'email'));

		public function create($owner,$title,$starting_price,$privacy="public",$end_date,$description)
		{	
			echo "string3";
			$response = array();
			$app = new dbHelper();
			$objDateTime = new DateTime('NOW');
			$duration = $objDateTime->diff($end_date);
			try {
				 $result = $app->insert( "auction", 
				 	array('user_id' =>$owner ,'title'=>$title,'starting_price'=>$starting_price,'start_time'=>date("Y-m-d H:i:s"),'duration'=>$duration,'privacy'=>$privacy,'category_id'=>$category_id),
				  	array('user_id','title','starting_price','start_time','duration','privacy'));
				if ($result['status'] == 'success') {
					$response['status'] = 'success';
					$response['message'] = 'Auction Created successfully';
					$response['aid'] = $result['data'];
				} else {
					$response['status'] = 'faild';
				}
				

			} catch(PDOException $e) {
    			return "Error: " . $e->getMessage();
			}	
			
		}

	}
	echo "string";
	$var = new Auction();
	$response = $var->create(6,"first",20,"public",date("Y-m-d H:i:s"),"Simple Aucation");
	if ($response['status'] == 'success') {
		echo "string1";
	} else {
		echo "string2";
	}
	

 ?>