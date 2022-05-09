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

function registerUser($fname, $username, $email, $password)
{
    $hostname = 'localhost';
    $dbuser = 'root';
    $dbpass = 'database';
    $dbname = 'test';
    $dbport = "3306";
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname, $dbport);
	
    if (!$conn)
	{
		echo "Error connecting to database: ".$conn->connect_errno.PHP_EOL;
		exit(1);
	}
	echo "Connection Established".PHP_EOL;
	$fullname = trim($fname) . ' ' . trim($lname);
	$username = strtolower(trim($username));
	$email = trim($email); 
	$answer1 = strtolower(trim($answer1)); 
	$answer2 = strtolower(trim($answer2));
	
    $query = "INSERT INTO `test`.`user` (`userid`, `email`, `password`, `name`) VALUES ('$username', '$email', '$password', '$fullname')";
    
    if (mysqli_query($conn, $query)) {
  	echo "New record created successfully";
  	return 1;
}   else {
  	echo "Error: " . $query . "<br>" . mysqli_error($conn);
  	return 0;
}
mysqli_close($conn);
}

function loginUser($username, $password)
{
    $hostname = 'localhost';
    $dbuser = 'root';
    $dbpass = 'database';
    $dbname = 'test';
    $dbport = "3306";
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname, $dbport);
	
    if (!$conn)
	{
		echo "Error connecting to database: ".$conn->connect_errno.PHP_EOL;
		exit(1);
	}
	echo "Connection Established".PHP_EOL;
	
	$username = strtolower(trim($username));
	
	// lookup username and password in database
	$sql = "SELECT * FROM user WHERE userid='$username'";
	// check username and password
	
	$result = mysqli_query($conn, $sql);
	if($result == false)
	{
		echo "Not authorized";
		$result=0;
	}
	if (mysqli_num_rows($result)==0)
	{
		echo "NO GOOD";
	}
	else
	{
		while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			if ($username=$row['userid'] && password_verify($password, $row['password']))
			{
				echo "Authorized";
				return 1;
			}
			else
			{
				echo "No Good";
				return 2;
			}
		}
	}
}

function processor($request)
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
      return loginUser($request['username'],$request['password']);
    case "register":
      return registerUser($request['fname'], $request['username'], $request['email'], $request['password']);
  }
}

$ip=["192.168.194.3", "192.168.194.117", "192.168.194.181"];
$num=0;
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
	$node="testDatabase.ini"; 
	echo $node .PHP_EOL;
}
if($host == "192.168.194.117")
{
	$node="testDatabase2.ini"; 
	echo $node .PHP_EOL;
}
if($host == "192.168.194.181")
{
	$node="testDatabase3.ini"; 
	echo $node .PHP_EOL;
}
if($host == "off")
{
	$node="No Machine is Online WTF"; 
	echo $node .PHP_EOL;
}

$server = new rabbitMQServer($node,"testServer");
echo "LISTENING";
$server->process_requests('processor');
echo "DONE";
exit();
?>
