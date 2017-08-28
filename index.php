<?php 
require_once __DIR__.'/vendor/autoload.php';

use Silex\Provider\FormServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
$app = new Silex\Application();

$app->get('/', function() use($app) { 
   return readfile("template.html");
});

$app->get('/hello/{name}', function($name) use($app) {
    
    return 'Hello '.$app->escape($name);
});
$app->post('/submit', function(Request $request, Silex\Application $app) {
    require_once __DIR__.'/config.php';
    try {
//        $verified = verifyGoogleRecaptcha($data['g-recaptcha-response'], $config)
//	if ($verfied == true) {
	    $attendee = new Wedding\Attendee($app->escape($request->get('Name')), $config['database']);
	    $attendee->isAttending($app->escape($request->get('RSVP')));
            $attendee->PartyCount($app->escape($request->get('Size')));
            $attendee->commit();

            if ($attendee->isAttending()){
    		return "We're so excited your coming";
	    } else {
    		return "We appriciate your response. So sorry you can't make it.";
	    }

//	} else {
//            return "You didn't click the I'm not a robot correctly. Try again." 
//	}
    } catch (\Exception $e) {
	error_log($e, 3, $config["logs"]);
       return "There was an internal error. Please try again in a bit";
    }
});

$app->run();

