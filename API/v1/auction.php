<?php

	require_once './models/auction.php';


	$Auc = new Auction();


	$app->post('/createAuction' , function($request,$response) use($app){
		$header = json_decode($request->getBody());

		$user_id = $header->auction->userID;
		$duration = $header->auction->duration;
		$price = $header->auction->price;
		$privacy = $header->auction->privacy;

		$result = $Auc->create_auction($user_id,$duration,$price,$privacy);
		return $response->write( json_encode($result) );
	});
?>