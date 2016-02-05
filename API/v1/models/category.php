<?php 
	
	/**
	* 
	*/
	class Category 
	{
		private $id;
		private $name;

		function __construct($id=0,$name="")
		{
			# code...
			$this->$id = $id;
			$this->$name = $name;
		}

		public function setId($id)
		{
			$this->$id = $id;
		}
		public function setName($name)
		{
			$this->$name = $name;
		}

		public function getId()
		{
			return $id;
		}
		public function getName()
		{
			return $name;
		}
	}


 ?>