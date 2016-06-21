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

    $app->post('/viewUserProfile',function($request,$response) use ($app){
        global $registerdUser;
        $header = json_decode($request->getBody());

        $userId = $header->id;

        $result = $registerdUser->view_user_profile($id);

        return $response->write( json_encode($result) );
    });

    $app->post('/deactivateAccount',function($request,$response) use ($app){
        global $registerdUser;

        $header = json_decode($request->getBody());
        $id = $header->id;

        $result = $registerdUser->deactivateAccount($id);
        return $response->write( json_encode($result) );
    });

    $app->post('/deleteAccount',function($request,$response) use ($app){
        global $registerdUser;

        $header = json_decode($request->getBody());
        $id = $header->id;

        $result = $registerdUser->deleteAccount($id);
        return $response->write( json_encode($result) );
    });

    $app->run();

?>
