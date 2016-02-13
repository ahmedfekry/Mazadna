<?php 
	require '.././libs/Slim/Slim.php';
	require_once 'dbHelper.php';
	require_once './models/user.php';
	require_once './models/registered_user.php';

	\Slim\Slim::registerAutoloader();
	$app = new \Slim\Slim();
	$app = \Slim\Slim::getInstance();
	


	$app->get('/hello', function () {
	    $var = new RegisteredUser();
	    $value = $var->FunctionName();
	    echo "Hello, ".$value;

	});

	$app->run();

	function echoResponse($status_code, $response) {
	    global $app;
	    $app->status($status_code);
	    $app->contentType('application/json');
	    echo json_encode($response,JSON_NUMERIC_CHECK);
	}
 
?>