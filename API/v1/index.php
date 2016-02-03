<?php
require '.././libs/Slim/Slim.php';
require_once 'dbHelper.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app = \Slim\Slim::getInstance();
$db = new dbHelper();

/**
 * Database Helper Function templates
 */
/*
select(table name, where clause as associative array)
insert(table name, data as associative array, mandatory column names as array)
update(table name, column names as associative array, where clause as associative array, required columns as array)
delete(table name, where clause as array)
*/

// $rows = $db->select("customers_php",array());
// $rows = $db->select("customers_php",array('id'=>171));
// $rows = $db->insert("customers_php",array('name' => 'Ipsita Sahoo', 'email'=>'ipi@angularcode.com'), array('name', 'email'));
// $rows = $db->update("customers_php",array('name' => 'Ipsita Sahoo', 'email'=>'email'),array('id'=>'170'), array('name', 'email'));
// $rows = $db->delete("customers_php", array('name' => 'Ipsita Sahoo', 'id'=>'227'));
// localhost.com/api/v1/index.php/users 

// Products
$app->get('/users', function() { 
    global $db;
    $rows = $db->select("users","user_id,username",array());
    echoResponse(200, $rows);
});


$app->get('/hello/:first/:last',function($first,$last){
	echo "Hello $first $last";
});

$app->run();

function echoResponse($status_code, $response) {
    global $app;
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response,JSON_NUMERIC_CHECK);
}

	// echo "string";
	$var = get_included_files();
	foreach ($var as  $value) {
		echo "$value";
	}
?>