<?php
	
	require_once "./models/item.php";
	require_once './API/v1/dbHelper.php';

	// $var = get_included_files();
	// foreach ($var as  $value) {
	// 	echo "$value";
	// }
	
	$db = new dbHelper();
	$rows = $db->select("users",array());
	
	// echo "<br>";
	// echo "<br>";
	// echo "<br>";
	
// $rows = $db->select("customers_php",array());
// $rows = $db->select("customers_php",array('id'=>171));
// $rows = $db->insert("customers_php",array('name' => 'Ipsita Sahoo', 'email'=>'ipi@angularcode.com'), array('name', 'email'));
// $rows = $db->update("customers_php",array('name' => 'Ipsita Sahoo', 'email'=>'email'),array('id'=>'170'), array('name', 'email'));
// $rows = $db->delete("customers_php", array('name' => 'Ipsita Sahoo', 'id'=>'227'));

 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
 	<h1>HI</h1>
 </body>
 </html>

