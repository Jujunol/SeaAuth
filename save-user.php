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
	//Add the value to our table
	$cmd = $conn->prepare("insert into $userTable (username, addr) 
		values (:username, :addr)");
	$cmd->bindParam(":username", $username, PDO::PARAM_STR, 25);
	$cmd->bindParam(":addr", $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR, 16);
	$cmd->execute();

	//Get userID for the Log
	$cmd = $conn->prepare("select userID from $userTable where username = :username");
	$cmd->bindParam(":username", $username, PDO::PARAM_STR, 25);
	$cmd->execute();
	$results = $cmd->fetchAll();
	$_SESSION['userID'] = $results[0]['userID'];
	logEvent($conn, $logTable, "$username registered their device");
}

//Disconnect
$conn = $altConn = null;
header('Location: new-user.php');

?>