<?php 
require_once __DIR__.'/vendor/autoload.php';

use Silex\Provider\FormServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
$app = new Silex\Application();
$loader = new Twig_Loader_Filesystem('./');
$twig = new Twig_Environment($loader, array());

$app->get('/hello/{name}', function($name) use($app) {
    return 'Hello '.$app->escape($name);
});

$app->get('/', function() use($app, $twig) { 
   return $twig->render('template.html', array()); 
});

$app->post('/submit', function(Request $request, Silex\Application $app) {
    require_once __DIR__.'/config.php'; // I hate this here
    try {
//      $verified = verifyGoogleRecaptcha($data['g-recaptcha-response'], $config)
//	if ($verfied == true) {
	    $attendee = new Wedding\Attendee($app->escape($request->get('Name')), $config['database']);
	    $attendee->isAttending($app->escape($request->get('RSVP')));
            $attendee->PartyCount($app->escape($request->get('Size')));
            $attendee->commit();

            if ($attendee->isAttending()){
    		return "We're glad you're coming.";
	    } else {
    		return "We'll miss you.";
	    }

//	} else {
//            return "You didn't click the I'm not a robot correctly. Try again." 
//	}
    } catch (\Exception $e) {
	error_log($e, 3, $config["logs"]);
       return "There was an Error, please try again in a bit or email help@fuzzy-ideas.com.";
    }
});

$app->run();

