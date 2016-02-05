<?php 
	
	/**
	* 
	*/
	class Admin extends User
	{
		private mobile_number;
		function __construct($id,$name,$user_name,$email,$password,$facebook_key,$followers,$following)
		{
			$this->id = $id;
			$this->name = $name;
			$this->email = $email;
			$this->password = $password;
			$this->facebook_key = $facebook_key;
			$this->followers = $followers;
			$this->following = $following;
		}
	}


 ?>