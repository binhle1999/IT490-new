<?php
//session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
include("functions.php");
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
	echo $node .PHP_EOL;
}
if($host == "192.168.194.117")
{
	$node="testRabbitMQ2.ini"; 
	echo $node .PHP_EOL;
}
if($host == "192.168.194.181")
{
	$node="testRabbitMQ3.ini"; 
	echo $node .PHP_EOL;
}
if($host == "off")
{
	$node="No Machine is Online WTF"; 
	echo $node .PHP_EOL;
}
$client = new rabbitMQClient($node,"testServer");

$password = $_POST["password"];
$hashed_pass = password_hash($password, PASSWORD_DEFAULT);
$request = array();
$request['type'] = "register";
$request['username'] = $_POST["username"];
$request['password'] = $hashed_pass;
$request['email'] = $_POST["email"];
$request['fname'] = $_POST["fname"];
$request['lname'] = $_POST["lname"];
//$request['securityq1'] = $_POST['securityq1'];
//$request['securityq2'] = $_POST['securityq2'];
$request['answer1'] = $_POST["answer1"];
$request['answer2'] = $_POST["answer2"];
$response = $client->send_request($request);

if($response == 1){
	header("Location: loginpage.php");
	exit();
} else {
	header("Location: signup.php");
	exit();
}
//header("Location: signup.php");
exit();
}
?>
