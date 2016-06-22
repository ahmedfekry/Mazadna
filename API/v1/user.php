<?php
    require '../../vendor/autoload.php';
    require 'models/registered_user.php';
    require_once 'passwordHash.php';

    $app = new \Slim\App;
    $registerdUser = new RegisteredUser();

    $app->post('/signUp', function ($request, $response) use ($app){

        global $registerdUser;

        $r = json_decode($request->getBody());

        $first_name =  $r->user->first_name;
        $last_name =  $r->user->last_name;
        $username =  $r->user->username;
        $email =  $r->user->email;
        $phone_number =  $r->user->phone_number;
        $password =  $r->user->password;

        $result = $registerdUser->sign_up($first_name,$last_name,$username,$email,$phone_number,$password);

        return $response->write( json_encode($result) );
    });

    $app->post('/signIn',function ($request,$response) use ($app){
        # code...
        global $registerdUser;

        $header = json_decode($request->getBody());

        $username = $header->user->username;
        $password = $header->user->password;
        // $result = array('message' => "success", );
        $result = $registerdUser->sign_in($username,$password);

        return $response->write(json_encode($result) );
    });

    $app->get('/session', function($request,$response) use ($app){
        // $db = new RegisteredUser();
        global $registerdUser;

        $session = $registerdUser->getSession();
        $result["uid"] = $session['uid'];
        $result["email"] = $session['email'];
        $result["name"] = $session['name'];
        // echoResponse(200, $session);
        return $response->write(json_encode($result));
    });


    $app->get('/logout', function($request,$response) use ($app){
        // $db = new DbHandler();
        global $registerdUser;
        $session = $registerdUser->destroySession();
        $result["status"] = "info";
        $result["message"] = "Logged out successfully";
        return $response->write(json_encode($result));
    });

    $app->run();

?>
