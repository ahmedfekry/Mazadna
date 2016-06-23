<?php
    require '../../vendor/autoload.php';
    require 'models/auction.php';
    require_once 'passwordHash.php';

    $app = new \Slim\App;
    $auction = new Auction();

    // $user_id,$description,$title,$starting_price,$privacy,$end_time,$on_site,$category_id
    $app->post('/createAuction',function ($request,$response) use ($app){
        # code...
        global $auction;

        $header = json_decode($request->getBody());

        $user_id = $header->auction->user_id;
        $description = $header->auction->description;
        $title = $header->auction->title;
        $starting_price = $header->auction->starting_price;
        $privacy = $header->auction->privacy;
        $end_time = $header->auction->end_time;
        // echo $end_time;
        $on_site = $header->auction->on_site;
        $category_id = $header->auction->category_id;

        // $result = array('message' => $user_id);
        $result = $auction->create($user_id,$description,$title,$starting_price,$privacy,$end_time,$on_site,$category_id);

        return $response->write(json_encode($result) );
    });

    $app->run();

?>