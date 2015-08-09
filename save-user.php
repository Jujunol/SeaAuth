<?php

$killOverride = true;
require_once "authlib.php";

$username = $_POST['username'];

//Check if the username already exists
$cmd = $conn->prepare("select userID from $userTable where username = :username");
$cmd->bindParam(":username", $username, PDO::PARAM_STR, 25);
$cmd->execute();
$results = $cmd->fetchAll();

if(count($results) === 0) {
	logEvent($conn, $logTable, "$username registered their device");
	$cmd = $conn->prepare("insert into $userTable (username, addr) 
		values (:username, :addr)");
	$cmd->bindParam(":username", $username, PDO::PARAM_STR, 25);
	$cmd->bindParam(":addr", $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR, 16);
	$cmd->execute();
}

//Disconnect
$conn = $altConn = null;
header('Location: new-user.php');

?>