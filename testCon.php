<?php
$ip=["192.168.194.3", "192.168.194.117", "192.168.194.181"];

for ($i=0; $i<count($ip); $i++)
{
	$host = $ip[$i];
	exec("ping -c 2 " . $host, $output, $result);
	//print_r($output);

	if ($result==0)
	{
        	echo PHP_EOL. "[*] ".$host." is Online".PHP_EOL;
        	//$node = "testRabbitMQ.ini";
		break;
	}
	else
	{
        	echo PHP_EOL. "[*] ".$host." is Offline".PHP_EOL;
	}
}
if ($host = "192.168.194.3")
{$node="testRabbit.ini"; echo $node .PHP_EOL;}
elseif($host = "192.168.194.129")
{$node="testRabbit2.ini"; echo $node .PHP_EOL;}
elseif($host = "192.168.194.7")
{$node="testRabbitMQ3.ini"; echo $node .PHP_EOL;}
//return $node;
?>
