#!/usr/bin/php

<?php

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
	$node="testRabbit.ini"; 
	echo $node .PHP_EOL;
}
if($host == "192.168.194.117")
{
	$node="testRabbit2.ini"; 
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
?>
