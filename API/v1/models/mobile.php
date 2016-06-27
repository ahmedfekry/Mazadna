<?php
    require '../../vendor/autoload.php';
    // require 'models/registered_user.php';
    // require_once 'passwordHash.php';

    $app = new \Slim\App;
    // $registerdUser = new RegisteredUser();
    // header("Access-Control-Allow-Origin: *");
  	$app->get('/books/:one/:two', function ($one, $two) {
	    echo "The first parameter is " . $one;
	    echo "The second parameter is " . $two;
	});

    $app->run();

?>
