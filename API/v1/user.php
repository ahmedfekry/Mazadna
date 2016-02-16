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

    
    // $app->get('/hello/{name}', function ($request, $response, $args) {
    //     return $response->write("Hello " . $args['name']);
    // });
	

        // first_name:'',
        // last_name:'',
        // username:'',
        // email:'',
        // phone_number:'',
        // password:'',

$app->post('/signUp', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());

    require_once 'passwordHash.php';
    $db = new DbHandler();
    
    $first_name = $r->customer->first_name;
    $last_name = $r->customer->last_name;
    $username = $r->customer->name;
    $email = $r->customer->email;
    $phone_number = $r->customer->phone_number;
    $password = $r->customer->password;

    $var = new RegisteredUser();
    $response = (array) $var->signUp($first_name,$last_name,$username,$email,$phone_number,$password);
    echoResponse($response['status'],$response['response']);
    // echoResponse(200,"ahmed");
});


	$app->run();

	function echoResponse($status_code, $response) {
	    global $app;
	    $app->status($status_code);
	    $app->contentType('application/json');
	    echo json_encode($response,JSON_NUMERIC_CHECK);
	}
 
?>