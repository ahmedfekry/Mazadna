<?php 
	// require_once '../passwordHash.php';
	require_once 'user.php';
	/**
	* 
	*/
	class RegisteredUser extends user
	{
		private $followers; // array of users id 
		private $following; // array of users id
		private $conn;
		public function __construct($id='',$name='',$user_name='',$email='',$password='',$facebook_key='',$followers='',$following='')
		{
			$this->id = $id;
			$this->name = $name;
			$this->email = $email;
			$this->password = $password;
			$this->facebook_key = $facebook_key;
			$this->followers = $followers;
			$this->following = $following;
			$this->conn = new PDO("mysql:host=localhost;dbname=Mazadna", "root", "Ahmed2512011");
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		// first_name:'',
        // last_name:'',
        // username:'',
        // email:'',
        // phone_number:'',
        // password:'',

		public function sign_up($first_name,$last_name,$username,$email,$phone_number,$password)
		{
			require_once '../passwordHash.php';
			$response = array();
			try{
			    $stmt = $this->conn->prepare("SELECT 1 FROM `user` WHERE username=:username or email=:email or phone_number=:phone_number "); 
			    $stmt->bindParam(':username',$username);
			    $stmt->bindParam(':email',$email);
			    $stmt->bindParam(':phone_number',$phone_number);
			    $stmt->execute();

			    $isUserExists = $stmt->fetch(PDO::FETCH_ASSOC);
			    			    
			    if(!$isUserExists){
			        $password = passwordHash::hash($password);
			        
			        $stmt = $this->conn->prepare("INSERT INTO user (first_name, last_name, username,email,phone_number,password) 
				    						VALUES (:first_name, :last_name,:username, :email, :phone_number,:password)");
				    $stmt->bindParam(':first_name', $first_name);
				    $stmt->bindParam(':last_name', $last_name);
				    $stmt->bindParam(':username', $username); 
				    $stmt->bindParam(':email', $email);
				    $stmt->bindParam(':phone_number', $phone_number);
				    $stmt->bindParam(':password', $password);

			        $result = $stmt->execute();
			        
			        if ($result != NULL) {
			        	$response["status"] = "success";
			            $response["message"] = "User account created successfully";
			            $response["uid"] = $this->conn->lastInsertId();
			            if (!isset($_SESSION)) {
			                session_start();
			            }
			            $_SESSION['uid'] = $response["uid"];
			            $_SESSION['first_name'] = $first_name;
			            $_SESSION['last_name'] = $first_name;
			            $_SESSION['username'] = $username;
			            $_SESSION['email'] = $email;
			            return array('status' => 200,'response' => $response );
			        } else {
			            $response["status"] = "error";
			            $response["message"] = "Failed to create customer. Please try again";
			            return array('status' => 201,'response' => $response );
			        }            
			    }else{
			        $response["status"] = "error";
			        $response["message"] = "An user with the provided phone or email or username exists!";
			        return array('status' => 201,'response' => $response );
			    }
		    }catch(PDOException $e) {
    			echo "Error: " . $e->getMessage();
			}			
		}
	}


	// $var = new RegisteredUser();
	// $response = (array) $var->sign_up("Ahmed","fekry","ahmedfekry11","ahmed11@mail.com","01120203911","123145");
	$res =  array('name' => 'fekry');
	// echo
       
 ?>