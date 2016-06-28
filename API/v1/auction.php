<?php
    require '../../vendor/autoload.php';
    require 'models/auction.php';
    require_once 'passwordHash.php';

    $app = new \Slim\App;
    $auction = new Auction();
    $User = new Auction();

    $app->post('/viewAuction', function ($request, $response) use ($app){
        global $auction;
        $header = json_decode($request->getBody());
        $auction_id = $header->temp->auction_id;
        $result = $auction -> viewAuction($auction_id);
        return $response-> write(json_encode($result));

    });

    $app->post('/submitBid',function($request,$response) use ($app){
        global $auction;

        $header = json_decode($request->getBody());

        //$user_id = $header->user->user_id;
        //$auction_id = $header->user->auction_id;
        //$price = $header->user->price;
        // $result = array('meww' => $auction_id );
        // $result = $registerdUser -> submit_bid($user_id,$auction_id,$price);
        $result = $auction -> submit_bid(1,4,20000);
        return $response->write(json_encode($result));
    });

    $app->post('/submitAuctionRating',function($request,$response) use ($app){
        global $auction;
        $header = json_decode($request->getBody());
        $user_id = $header->auction->user_id;
        $auction_id = $header->auction->auction_id;
        $description = $header->auction->description;
        $stars = $header->auction->stars;
        $result = $auction->submit_rating($user_id,$auction_id,$description,$stars);
        return $response->write(json_encode($result));
    });
 
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
        $start_time = (string)$header->auction->start_time;
        $end_time = (string)$header->auction->end_time;
        // echo $end_time;
        $category_id = $header->auction->category_id;

        // $result = array('message' => $category_id);
        // ($user_id,$description,$title,$starting_price,$privacy,$end_time,$start_time,$on_site=0,$category_id
        $result = $auction->create($user_id,$description,$title,$starting_price,$privacy,$end_time,$start_time,$category_id);

        return $response->write(json_encode($result) );
    });

    $app->post('/deleteAuction',function ($request,$response) use ($app){
        # code...
        global $auction;

        $header = json_decode($request->getBody());

        $auction_id = $header->auction->auction_id;
        // $result = array('message' => $user_id);
        $result = $auction->delete($auction_id);

        return $response->write(json_encode($result) );
    });

    $app->post('/deactivateAuction',function ($request,$response) use ($app){
        # code...
        global $auction;
        $header = json_decode($request->getBody());

        $auction_id = $header->auction->auction_id;
        // $result = array('message' => $user_id);
        $result = $auction->deactivate($auction_id);

        return $response->write(json_encode($result) );
    });



    $app->run();

?>