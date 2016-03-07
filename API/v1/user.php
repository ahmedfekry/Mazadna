<?php 
    // // require '.././libs/Slim/Slim.php';
    // require '/var/www/html/mazadna/vendor/autoload.php';
 //    require_once 'dbHelper.php';
    // require_once './models/registered_user.php';
 //    require_once 'passwordHash.php';

//     $app = new \Slim\App;
//     $registerdUser = new RegisteredUser();
    
    // $included_files = get_included_files();

    // foreach ($included_files as $filename) {
    //     echo "$filename\n";
    // }

        // first_name:'',
        // last_name:'',
        // username:'',
        // email:'',
        // phone_number:'',
        // password:'',
    
    $app->post('/signUp', function ($request, $response) use ($app){
        
        global $registerdUser;
        
        $r = json_decode($request->getBody());
        
        // get the data from the parsed object
        $first_name =  $r->user->first_name;
        $last_name =  $r->user->last_name;
        $username =  $r->user->username;
        $email =  $r->user->email; 
        $phone_number =  $r->user->phone_number;
        $password =  $r->user->password;

        // $result = array('first_name' => $first_name,'last_name' => $last_name,'username' => $username,'email'=>$email,'phone_number'=>$phone_number,'password'=>$password );
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
    
    // $app->run();

 
?>