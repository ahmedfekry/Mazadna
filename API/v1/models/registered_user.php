<?php 

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
		
		public function FunctionName($value='')
		{
			return "my name is fekry";
		}


	}

 ?>