<?php
include("functions.php");

$name =$POST['username'];
$pass =$POST['password'];
$errFlag = False;
$nameErr = False;
$passErr = False;

if(empty($name)){
	$errFlag = True;
	$nameErr = True;
}
if(empty($pass)){
	$errFlag = True;
	$passErr = True;
}

if($errFlag){
	$obj->nameErr = $nameErr;
	$obj->passErr = $passErr;
}else{
	$response = sendRabbit(array('type' => 'login', 'data' => array('username' => $name, 'password' => sha1($pass))));
	$obj->response = $response;
	if($response == 0){
		session_start();
		$_SESSION['user'] = $name;
	}
}

echo json_encode($obj);
?>
