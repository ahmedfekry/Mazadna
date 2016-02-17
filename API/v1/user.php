<?php 
	// require '.././libs/Slim/Slim.php';
	require '/var/www/html/mazadna/vendor/autoload.php';
    require_once 'dbHelper.php';
	require_once './models/user.php';
	require_once './models/registered_user.php';
    require_once 'passwordHash.php';

	$app = new \Slim\App;
    
    // $included_files = get_included_files();

    // foreach ($included_files as $filename) {
    //     echo "$filename\n";
    // }

    
    $app->post('/sign_up', function ($request, $response) use ($app){
        $json = $request->getBody();
        $data = json_decode($json, true); // parse the JSON into an assoc. array
        $first_name = $data["first_name"];
        $last_name = $data["last_name"];
        $username = $data["username"];
        $email = $data["email"]; 
        $phone_number = $data["phone_number"];
        $password = $data["password"];
        $result = array();
        $var = new RegisteredUser();
        $result = $var->signUp($first_name,$last_name,$username,$email,$phone_number,$password);
        

        return $response->write( json_encode($result) );
    });
    

        // first_name:'',
        // last_name:'',
        // username:'',
        // email:'',
        // phone_number:'',
        // password:'',
// $app->post('/signUp', function ($request,$response) use ($app){
        
    //     $first_name = $data['first_name'];
    //     $last_name = $data('last_name');
    //     $username = $data('username');
    //     $email = $data('email');
    //     $phone_number = $data('phone_number');
    //     $password = $data('password');
        
    //     return $response->write( json_encode($response) );

    // });


	$app->run();

 
?>