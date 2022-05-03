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

$ip=["192.168.194.3", "192.168.194.117", "192.168.194.181"];
for ($i=0; $i<count($ip); $i++)
{
	$host = $ip[$i];
	exec("ping -c 2 " . $host, $output, $result);

	if ($result==0)
	{
        	echo PHP_EOL. "[*] ".$host." is Online".PHP_EOL;
		break;
	}
	else
	{
        	echo PHP_EOL. "[*] ".$host." is Offline".PHP_EOL;
        	$host = "off";
	}
}
if ($host == "192.168.194.3")
{
	$node="testRabbitMQ.ini";
	$node2="testDatabase.ini"; 
	echo $node .PHP_EOL;
}
if($host == "192.168.194.117")
{
	$node="testRabbitMQ2.ini";
	$node2="testDatabase2.ini"; 
	echo $node .PHP_EOL;
}
if($host == "192.168.194.181")
{
	$node="testRabbitMQ3.ini";
	$node2="testDatabase3.ini"; 
	echo $node .PHP_EOL;
}
if($host == "off")
{
	$node="No Machine is Online WTF"; 
	echo $node .PHP_EOL;
}

$client = new rabbitMQClient($node2,"testServer");
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

$ip=["192.168.194.3", "192.168.194.117", "192.168.194.181"];
for ($i=0; $i<count($ip); $i++)
{
	$host = $ip[$i];
	exec("ping -c 2 " . $host, $output, $result);

	if ($result==0)
	{
        	echo PHP_EOL. "[*] ".$host." is Online".PHP_EOL;
		break;
	}
	else
	{
        	echo PHP_EOL. "[*] ".$host." is Offline".PHP_EOL;
        	$host = "off";
	}
}
if ($host == "192.168.194.3")
{
	$node="testRabbitMQ.ini";
	$node2="testDatabase.ini"; 
	echo $node .PHP_EOL;
}
if($host == "192.168.194.117")
{
	$node="testRabbitMQ2.ini";
	$node2="testDatabase2.ini"; 
	echo $node .PHP_EOL;
}
if($host == "192.168.194.181")
{
	$node="testRabbitMQ3.ini";
	$node2="testDatabase3.ini"; 
	echo $node .PHP_EOL;
}
if($host == "off")
{
	$node="No Machine is Online WTF"; 
	echo $node .PHP_EOL;
}

$client = new rabbitMQClient($node2,"testServer");
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
    case "register":
      return doRegister($request['username'], $request['password'], $request['fname'], $request['lname'], $request['email'], $request['answer1'], $request['answer2']);
  }
}

$ip=["192.168.194.3", "192.168.194.117", "192.168.194.181"];
for ($i=0; $i<count($ip); $i++)
{
	$host = $ip[$i];
	exec("ping -c 2 " . $host, $output, $result);

	if ($result==0)
	{
        	echo PHP_EOL. "[*] ".$host." is Online".PHP_EOL;
		break;
	}
	else
	{
        	echo PHP_EOL. "[*] ".$host." is Offline".PHP_EOL;
        	$host = "off";
	}
}
if ($host == "192.168.194.3")
{
	$node="testRabbitMQ.ini";
	$node2="testDatabase.ini"; 
	echo $node .PHP_EOL;
}
if($host == "192.168.194.117")
{
	$node="testRabbitMQ2.ini";
	$node2="testDatabase2.ini"; 
	echo $node .PHP_EOL;
}
if($host == "192.168.194.181")
{
	$node="testRabbitMQ3.ini";
	$node2="testDatabase3.ini"; 
	echo $node .PHP_EOL;
}
if($host == "off")
{
	$node="No Machine is Online WTF"; 
	echo $node .PHP_EOL;
}

$server = new rabbitMQServer($node,"testServer");


echo "LISTENING";
$server->process_requests('requestProcessor');
echo "DONE";
exit();
?>
