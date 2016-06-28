<?php
    require '../../vendor/autoload.php';
    require 'models/admin.php';
    require_once 'passwordHash.php';

    $app = new \Slim\App;
    $admin = new Admin();

    $app->post('/signInAdmin',function ($request,$response) use ($app){
        # code...
        global $admin;
        $header = json_decode($request->getBody());
        $username = $header->user->username;
        $password = $header->user->password;
        // $result = array('message' => "success", );
        $result = $admin->sign_in($username,$password);
        return $response->write(json_encode($result) );
    });

     $app->post('/users',function($request,$response) use ($app){
        global $admin;

        $result = $admin->get_users_num();
        return $response->write( json_encode($result) );
    });

    $app->post('/auctions',function($request,$response) use ($app){
        global $admin;

        $result = $admin->get_auctions_num();

        return $response->write(json_encode($result));
    });

    $app->post('/activeAuctions',function($request,$response) use ($app){
        global $admin;

        $result = $admin->get_active_auctions();

        return $response->write(json_encode($result));
    });

    $app->post('/auctionPricesSum',function($request,$response) use ($app){
        global $admin;

        $result = $admin->auction_prices_sum();

        return $response->write(json_encode($result));
    });
    $app->run();

?>
