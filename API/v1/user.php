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

     $app->post('/getUser',function ($request,$response) use ($app){
        # code...
        global $registerdUser;

        $header = json_decode($request->getBody());

        $user_id = $header->user->user_id;
        // $result = array('message' => "success", );
        $result = $registerdUser->getUser($user_id);

        return $response->write(json_encode($result) );
    });
    
    $app->post('/updateUser',function ($request,$response) use ($app){
        # code...
        global $registerdUser;

        $header = json_decode($request->getBody());

        $user_id = $header->user->user_id;
        $first_name = $header->user->first_name;
        $last_name = $header->user->last_name;
        $username = $header->user->user_name;
        $email = $header->user->email;
        $phone_number = $header->user->phone_number;
        $new_password = $header->user->new_password;
        $old_password = $header->user->old_password;
        // $result = array('message' => "success", );
        $result = $registerdUser->updateUser($user_id,$first_name,$last_name,$username,$email,$phone_number,$new_password,$old_password);

        return $response->write(json_encode($result) );
    });

    /*
        author: Eslam Ebrahim

        description: 
            thisfunction handles the request & response for replying auction invitation 
    */
    $app->post('replyInvitation',function($request,$response) use ($app){
        global $registerdUser;

        $header = json_decode($request->getBody());
        $inviter_id = $header->user->inviter_id;
        $invitee_username = $header->user->invitee_username;
        $auction_id = $header->user->auction_id;
        $reply = $header->user->reply;

        $result = $registerdUser->reply_invitation($inviter_id,$invitee_username,$auction_id,$reply);

        $return $response->write(json_encode($result));
    });


    $app->run();

?>
