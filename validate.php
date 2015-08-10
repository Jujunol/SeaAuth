<?php

$code = $_POST['ccode'];

$killOverride = true;
require_once "authlib.php";

$cmd = $conn->prepare("select userID from $codeTable where codename = :code");
$cmd->bindParam(":code", $code, PDO::PARAM_STR, 10);
$cmd->execute();
$results = $cmd->fetchAll();

if(count($results) === 1 && empty($results[0]['userID'])) {
	$cmd = $conn->prepare("update $codeTable set userID = 
		(select userID from $userTable where addr = :addr)
		where codename = :code limit 1");
	$cmd->bindParam(":addr", $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR, 16);
	$cmd->bindParam(":code", $code, PDO::PARAM_STR, 10);
	$cmd->execute();

	logEvent($conn, $logTable, "Has logged with SeaCode $code");
}

$conn = $altConn = null;
header('Location: login.php');

?>