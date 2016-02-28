<?php
	require 'API/v1/passwordHash.php';

	// $password = "AhmedFekry";

	// $res = passwordHash::hash($password);
	// echo "$res";
	// echo "\n";
	// $res = $res."fekry";
	// echo "$res";
	// echo "\n";
	// if (passwordHash::check_password($res,$password)){
	// 	echo "string";	
	// 	echo "\n";
	// }
	$datetime2 = new DateTime('2017-10-13');

	echo date("Y-m-d H:i:s",$datetime2); // ISO8601 formated datetime
 ?>
 