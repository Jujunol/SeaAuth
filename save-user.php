<?php

$killOverride = true;
require_once "authlib.php";

$userID = $_POST['userID'];
$username = $_POST['username'];

if(!empty($userID) && !hasPerm("users.edit")) {
	$conn = $altConn = null;
	header('Location: user.php');
	die;
}

//Check if the username already exists
$cmd = $conn->prepare("select userID from $userTable where username = :username");
$cmd->bindParam(":username", $username, PDO::PARAM_STR, 25);
$cmd->execute();
$results = $cmd->fetchAll();

if(count($results) === 0) {
	//Add the value to our table
	$sql = empty($userID) ? "insert into $userTable (username, addr) 
		values (:username, :addr)" : "update $userTable 
		set username = :username where userID = :userID";
	$cmd = $conn->prepare($sql);
	$cmd->bindParam(":username", $username, PDO::PARAM_STR, 25);
	if(empty($userID)) $cmd->bindParam(":addr", $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR, 16);
	else $cmd->bindParam(":userID", $userID, PDO::PARAM_INT);
	$cmd->execute();

	//Get userID for the Log
	if(empty($userID)) {
		$cmd = $conn->prepare("select userID from $userTable where username = :username");
		$cmd->bindParam(":username", $username, PDO::PARAM_STR, 25);
		$cmd->execute();
		$results = $cmd->fetchAll();
		$_SESSION['userID'] = $results[0]['userID'];
		logEvent($conn, $logTable, "$username registered their device");
	}
	else logEvent($conn, $logTable, "Changed UserID $userID name to $username");
}

//Disconnect
$conn = $altConn = null;
header('Location: new-user.php');

?>