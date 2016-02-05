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
		function __construct($id=0,$name="",$categoryId=0,$ownerId=0)
		{
			# code...
			$this->$id = $id;
			$this->$name = $name;
			$this->$categoryId = $categoryId;
			$this->$ownerId = $ownerId;
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
		
		public function setCategoryId($categoryId)
		{
			$this->$categoryId = $categoryId;
		}

		public function getCategoryId()
		{
			return $categoryId;
		}

		public function setOwnerId($ownerId)
		{
			$this->$ownerId = $ownerId;
		}

		public function getOwnerId()
		{
			return $ownerId;
		}

	}


 ?>