<?php

require('../vendor/autoload.php');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// By default allow CORS from all domains
// Change/remove this if CORS is not wanted
$app->register(new JDesrosiers\Silex\Provider\CorsServiceProvider(), array(
    "cors.allowOrigin" => "*",
));

// Pusher
$pusher_app_id = getenv('PUSHER_APP_ID');
$pusher_app_key = getenv('PUSHER_APP_KEY');
$pusher_app_secret = getenv('PUSHER_APP_SECRET');

$pusher = new Pusher($pusher_app_key, $pusher_app_secret, $pusher_app_id);

// Pusher Logging
class PusherMonoLogger {
  function __construct($monolog) {
    $this->monolog = $monolog;
  }
  
  public function log( $msg ) {
    $this->monolog->addDebug(print_r($msg, true));
  }
}

$pusherMonoLogger = new PusherMonoLogger( $app['monolog'] );
$pusher->set_logger( $pusherMonoLogger );
$pusherMonoLogger->log($pusher);

// Routes

// Default route to prove things are working
$app->get('/', function() {
  return new Response('Pusher PHP Auth Test', 200);
});

// Trigger an event
$app->post('/trigger', function(Request $request) use($pusher) {
  // channel, event name and data payload should all be
  // changed to suit your application needs.
  // If taking data from the posted request be sure to validate and sanitize
  $channelName = 'test_channel';
  $eventName = 'test_event';
  $eventData = array('hello' => 'world');
  $excludeSocketId = $request->get('socket_id');
  
  $pusher->trigger($channelName, $eventName, $eventData, $excludeSocketId);
  
  return new Response('{"trigger_success": "true"}', 200);
});

// Authenticate Private Channel Subscriptions
$app->post('/private-auth', function (Request $request) use($pusher) {
  // Authenticate all private channels by default.
  // Add user authentication if this is in production
  $channel_name = $request->get('channel_name');
  $socket_id = $request->get('socket_id');

  $auth = $pusher->socket_auth($channel_name, $socket_id);
  return new Response($auth, 200);
});

// Remove this if CORS is not wanted
$app->after($app['cors']);

$app->run();
