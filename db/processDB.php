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
    $dbpass = 'admin';
    $dbname = 'Project';
    $dbport = "3306";
    $conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname, $dbport);
	
    if (!$conn)
	{
		echo "Error connecting to database: ".$conn->connect_errno.PHP_EOL;
		exit(1);
	}
	echo "Connection Established".PHP_EOL;
	
    $query = "INSERT INTO `Project`.`user` (`name`, `username`, `email`, `password`, `Security Question 1`, `Security Answer 1`,  `Security Question 2`, Security Answer 2`) VALUES ('$fullname', '$username', '$email', '$password', '$securityq1', '$answer1', '$securityq2', $answer2)";
    
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
    $dbname = 'Project';
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
	$sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
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
			if ($username=$row['username'] && $password=['password'])
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
$server = new rabbitMQServer("testDatabase.ini","testServer");
echo "LISTENING";
$server->process_requests('processor');
echo "DONE";
exit();
?>
