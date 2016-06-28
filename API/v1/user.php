<?php
    require '../../vendor/autoload.php';
    require 'models/registered_user.php';
    require_once 'passwordHash.php';

    $settings =  [
        'settings' => [
            'displayErrorDetails' => true,
        ],
    ];

    $app = new \Slim\App($settings);
    $registerdUser = new RegisteredUser();
    header("Access-Control-Allow-Origin: *");
    

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


    $app->post('/signIn2',function ($request,$response) use ($app){
        # code...
        global $registerdUser;
        $allGetVars = $request->getQueryParams();
        $username = $allGetVars['username'];
        $password = $allGetVars['password'];
        
        $result = $registerdUser->sign_in($username,$password);
        
        return $response->write(json_encode($result) );

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

      
   $app->post('/viewUserProfile', function ($request, $response) use ($app){
         global $registerdUser;
        $header = json_decode($request->getBody());
        $id1 = $header->user->id;
        $result = $registerdUser ->view_user_profile($id1);
        return $response-> write(json_encode($result));

    });
    
    $app->post('/checkIfFollowers', function ($request, $response) use ($app){
         global $registerdUser;
        $header = json_decode($request->getBody());
        $id1 = $header->user->id1;
        $id2 = $header->user->id2;
        $result = $registerdUser ->checkIfFollow($id1,$id2);
        return $response-> write(json_encode($result));

    });

    $app->post('/followUser',function($request,$response) use ($app){
        global $registerdUser;

        $header = json_decode($request->getBody());
        $followerId = $header->user->followerId;
        $followedId = $header->user->followedId;

        $result = $registerdUser->follow_user($followerId,$followedId);

        return $response->write( json_encode($result) );
    });
    
    $app->run();

?>
