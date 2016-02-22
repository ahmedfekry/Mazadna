<?php 
	/**
	* 
	*/
	class Item
	{
		private $id;
		private $name;
		private $picture;
		private $auctionId;

		function __construct($id=0,$name="",$picture="",$auctionId=0)
		{
			echo "Constructor";
			$this->id = $id;
			$this->name = $name;
			$this->picture = $picture;
			$this->auctionId = $auctionId;
		}
		
	}

 ?>