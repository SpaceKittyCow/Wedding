<?php 
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';
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
    $data = json_decode($request->getContent(), true);
    try {
        $verified = verifyGoogleRecaptcha($data[''], $config)
	if ($verfied == true) {
	    $attendee = new Wedding\Attendee($data['name'], $config['database']);
	    $attendee->isComing($data[''])
            if ($attendee->isComing()){
        	$attendee->PartyCount($data['']);
    		return "We're so excited your coming";
	    } else {
    		return "We appriciate your response. So sorry you can't make it.";
	    }

	} else {
            return "You didn't click the I'm not a robot correctly. Try again." 
	}
    } catch (\Exception $e) {
	error_log($e, 3, $config["logs"]);
       return "There was an internal error. Please try again in a bit";
    }
});

$app->run();
