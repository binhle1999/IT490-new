#!/usr/bin/php
<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doRegister($username, $password, $fname, $lname, $email, $seca1, $seca2)
{
$client = new rabbitMQClient("testDatabase.ini","testServer");
$request = array();
$request['type'] = "register";
$request['username'] = $username;
$request['password'] = $password;
$request['fname'] = $fname;
$request['email'] = $email;
$response = $client->send_request($request);


echo "Request sent....";

if($response == 1){
	echo "Success";
	return 1;
} else {
	echo "Failed";
	return 0;
}


exit();		
}


function doLogin($username,$password)
{
$client = new rabbitMQClient("testDatabase.ini","testServer");
$request = array();
$request['type'] = "login";
$request['username'] = $username;
$request['password'] = $password;
$response = $client->send_request($request);


echo "Request sent....";

if($response == 1){
	echo "Success";
	return 1;
} else {
	echo "Failed";
	return 0;
	}
}

function requestProcessor($request)
{
  echo "received request";
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
    {
      return doLogin($request['username'],$request['password']);
    }
    case "validate_session":
      return doValidate($request['sessionId']);
    case "register":
      return doRegister($request['username'], $request['password'], $request['fname'], $request['lname'], $request['email'], $request['answer1'], $request['answer2']);
  }
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");


echo "LISTENING";
$server->process_requests('requestProcessor');
echo "DONE";
exit();
?>
