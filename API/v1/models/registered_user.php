<?php 
	require_once 'dbHelper.php';
	require_once 'passwordHash.php';
	
	/**
	* 
	*/
	class RegisteredUser extends user
	{
		private $followers; // array of users id 
		private $following; // array of users id
		public function __construct($id='',$name='',$user_name='',$email='',$password='',$facebook_key='',$followers='',$following='')
		{
			$this->id = $id;
			$this->name = $name;
			$this->email = $email;
			$this->password = $password;
			$this->facebook_key = $facebook_key;
			$this->followers = $followers;
			$this->following = $following;
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
			$db = new dbHelper();
			
			$isUserExists = $db->getOneRecord("select 1 from user where username='$username' or email='$email' or phone_number='$phone_number'");
		    if(!$isUserExists){
		        $password = passwordHash::hash($password);
		        
		        $tabble_name = "user";
		        
		        $column_names = array('first_name', 'last_name', 'username', 'email', 'phone_number', 'password');
		        $user = array('first_name' => $first_name,'last_name' => $last_name,'username' => $username,'email' => $email, 'phone_number' => $phone_number, 'password' => $password);
		        
		        // $result = $db->insertIntoTable($r->customer, $column_names, $tabble_name);
		        $result = $db->insertIntoTable($user,$column_names,$tabble_name);
		        
		        if ($result != NULL) {
		            $response["status"] = "success";
		            $response["message"] = "User account created successfully";
		            $response["uid"] = $result;
		            if (!isset($_SESSION)) {
		                session_start();
		            }
		            $_SESSION['uid'] = $response["uid"];
		            $_SESSION['first_name'] = $first_name;
		            $_SESSION['last_name'] = $first_name;
		            $_SESSION['username'] = $username;
		            $_SESSION['email'] = $email;
		            // echoResponse(200, $response);
		            return array('status' => 200,'response' => $response );;
		        } else {
		            $response["status"] = "error";
		            $response["message"] = "Failed to create customer. Please try again";
		            // echoResponse(201, $response);
		            return array('status' => 201,'response' => $response );;
		        	
		        }            
		    }else{
		        $response["status"] = "error";
		        $response["message"] = "An user with the provided phone or email or username exists!";
		        // echoResponse(201, $response);
		        return array('status' => 201,'response' => $response );;
		    	
		    }
						
		}


	}

 ?>