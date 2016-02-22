<?php
require '.././libs/Slim/Slim.php';
require_once 'dbHelper.php';
require_once './models/user.php';
require_once './models/registered_user.php';
require_once 'passwordHash.php'

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

$app->get('/hello/:name', function ($name) {
    echo "Hello, " . $name;
    $var = new ReRegisteredUser();
});


// $app->post('/products', function() use ($app) { 
//     $data = json_decode($app->request->getBody());
//     $mandatory = array('name');
//     global $db;
//     $rows = $db->insert("products", $data, $mandatory);
//     if($rows["status"]=="success")
//         $rows["message"] = "Product added successfully.";
//     echoResponse(200, $rows);
// });

// $app->put('/products/:id', function($id) use ($app) { 
//     $data = json_decode($app->request->getBody());
//     $condition = array('id'=>$id);
//     $mandatory = array();
//     global $db;
//     $rows = $db->update("products", $data, $condition, $mandatory);
//     if($rows["status"]=="success")
//         $rows["message"] = "Product information updated successfully.";
//     echoResponse(200, $rows);
// });

// $app->delete('/products/:id', function($id) { 
//     global $db;
//     $rows = $db->delete("products", array('id'=>$id));
//     if($rows["status"]=="success")
//         $rows["message"] = "Product removed successfully.";
//     echoResponse(200, $rows);
// });

function echoResponse($status_code, $response) {
    global $app;
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response,JSON_NUMERIC_CHECK);
}

$app->run();

echo "string";

?>
