<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
$request = array();
$request['type'] = "login";
$request['username'] = $_POST["username"];
$request['password'] = $_POST["password"];;
$response = $client->send_request($request);

if($response == 1){
	//response received, user authorized
	$_SESSION["username"] = $_POST["username"];
        header("Location: home.php");
	
	
} else{
	//user not found
        header("Location: loginpage.php");
	$msg = "Unauthorized.\nTry Again";
        echo "<script type='text/javascript'>alert('Unauthorized.\nTry Again');</script>";

}

exit();		
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title> 

    <!--Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"/>
    <link href="../css/main.css" type="text/css" rel="stylesheet"/>
    <link rel="shortcut icon" href="../img/seedling-solid.svg"/>
    <!--Send user input to login.php to validate the user login and sessionID-->
</head> 
 
<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-md navbar-light sticky-top shadow p-3 mb-5 bg-white rounde">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="signup.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--end of nav-->

    <div class="container p-1"></div>
    <div class="container col-md-6">
    <h1>Sign In</h1>
    <hr>
    <form action="#" onsubmit="return checkForm()" method="POST" >
        <div class="mb-3">
            <input type="username" class="form-control" id="username" name="username" placeholder="Enter Username">
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
        </div>
        
        <button type="submit" class="btn btn-primary">Sign In</button>
        <a class="nav-link" href="">Forgot Password?</a>
    </form>
    </div>
    <div class="container p-1"></div>

</body>

<script>
	function checkForm()
	{
		var name = document.getElementById("username").value;
		var password = document.getElementById("password").value;
		
		if (username.length == 0)
		{
			alert("Username cannot be blank");
			return false;
		}
		else
		{
			if (password.length > 0)
			{return true;}
			else
			{
				alert("Please enter a password");
				return false;			
			}
		}
	}
</script>

<!--Footer-->
<footer class="text-center text-white sticky-bottom container-fluid footer" style="background-color: #7d9988;">
    <!-- Grid container -->
    <div class="container p-3">
    <!--common links and other infromation accessible from all pages-->
    <p> © Copyright 2022: IT490 Project</p>
  </div>
</footer>

</html>
