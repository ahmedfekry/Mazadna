<?php
	require '../../vendor/autoload.php';
    require_once 'dbHelper.php';
    // require_once './models/registered_user.php';
    require_once 'models/auction.php';
    require_once 'passwordHash.php';
    $app = new \Slim\App;
	$home = new Auction(); 

	$app->post('/viewAuction', function ($request, $response) use ($app){
        global $home;
        $header = json_decode($request->getBody());

        $result = $home -> viewAuction(2);
        return $response-> write(json_encode($result));

    });

	$app->run();
?>
