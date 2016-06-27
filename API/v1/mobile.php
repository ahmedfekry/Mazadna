<?php
    require '../../vendor/autoload.php';
    $app = new \Slim\App;
$app->get('/api/list/', function () use ($app) {
    $req = $app->request();
    $position = $req->get('position');
    $distance = $req->get('distance');
});
    $app->run();

?>
