<?php
	require '../../vendor/autoload.php';
    require_once 'dbHelper.php';
    //require_once 'models/registered_user.php';
    require_once 'models/auction.php';
    require_once 'passwordHash.php';
    $app = new \Slim\App;
	$home = new Auction(); 
    header("Access-Control-Allow-Origin: *");

	$app->post('/home', function ($request, $response) use ($app){
        global $home;
        $header = json_decode($request->getBody());
        $category_id = $header->temp->category_id;

        $result = $home -> searchByCategory($category_id);
        return $response-> write(json_encode($result));

    });

   
   $app->post('/join', function ($request, $response) use ($app){
        global $home;
        $header = json_decode($request->getBody());
        $auctionID = $header->postObject->auctionID;
        $userID = $header->postObject->userID;
        $result = $home -> joinAuction($userID,$auctionID);
        return $response-> write(json_encode($result));

    });

    $app->run();
?>