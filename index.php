<?php 
require_once __DIR__.'/../vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
$app = new Silex\Application();
$app->get('/', function() use($app) { 
return readfile("template.html");
});
$app->get('/hello/{name}', function($name) use($app) {
    return 'Hello '.$app->escape($name);
});
$app->post('/submit', function(Request $request) {
    $data =json_decode($request->getContent(), true);
    try {
        $Attendee = new Wedding\Attendee($data['state']);
       $state = $user->SetPiece($column);
    } catch (\Exception $e) {
       return $e;
    }
    return json_encode($state);
});
$app->run();
