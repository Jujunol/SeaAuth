<?php

$code = $_POST['ccode'];

$killOverride = true;
require_once "authlib.php";

$cmd = $conn->prepare("select userID from $codeTable where codename = :code");
$cmd->bindParam(":code", $code, PDO::PARAM_STR, 10);
$cmd->execute();
$results = $cmd->fetchAll();

if(count($results) === 1) {
	require_once "crypto.php";
	//Check if the userID is already assigned
	$cmd = $conn->prepare("select codename from $codeTable where userID = :userID");
	$cmd->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
	$cmd->execute();
	$assignedCodes = $cmd->fetchAll();

	if($results[0]['userID'] == $_SESSION['userID']) {
		$key = getUserKey($conn);
		setcookie("uk", $key, time() + 1000 * 60 * 60 * 24 * 365); //ms * s * m * h * days
	}
	else if(empty($results[0]['userID']) && count($assignedCodes) === 0) {
		$cmd = $conn->prepare("update $codeTable set userID = 
			(select userID from $userTable where addr = :addr)
			where codename = :code limit 1");
		$cmd->bindParam(":addr", $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR, 16);
		$cmd->bindParam(":code", $code, PDO::PARAM_STR, 10);
		$cmd->execute();

		//Set userkey
		$key = getUserKey($conn);
		setcookie("uk", $key, time() + 1000 * 60 * 60 * 24 * 365); //ms * s * m * h * days

		logEvent($conn, $logTable, "Has logged with SeaCode $code");
	}
}

$conn = $altConn = null;
header('Location: login.php');

?>