<?php
	require '../../vendor/autoload.php';
    require_once 'dbHelper.php';
    require_once 'models/registered_user.php';
    require_once './models/Auction.php';
    require_once 'passwordHash.php';
    $app = new \Slim\App;
	$home = new Auction(); 

	$app->post('/home', function ($request, $response) use ($app){
        global $home;
        $header = json_decode($request->getBody());
        $result = $home -> getdata();
        return $response-> write(json_encode($result));

    });

	$app->run();
?>
