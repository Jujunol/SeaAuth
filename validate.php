<?php

$code = $_POST['ccode'];

$killOverride = true;
require_once "authlib.php";

$cmd = $conn->prepare("select userID from $codeTable where codename = :code");
$cmd->bindParam(":code", $code, PDO::PARAM_STR, 10);
$cmd->execute();
$results = $cmd->fetchAll();

// print_r($results);
// echo "<br>" . count($results) . "<br>";
// echo empty($results[0]['userID']) ;

if(count($results) === 1 && empty($results[0]['userID'])) {
	// echo "<br>Check passed<br>";
	$_SESSION['userID'] = $results[0]['userID'];
	logEvent($conn, $logTable, "Has logged with SeaCode $code");
	$cmd = $conn->prepare("update $codeTable set userID = 
		(select userID from $userTable where addr = :addr)
		where codename = :code limit 1");
	$cmd->bindParam(":addr", $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR, 16);
	$cmd->bindParam(":code", $code, PDO::PARAM_STR, 10);
	$cmd->execute();
	header('Location: index.php');
}
else header('Location: login.php');

$conn = $altConn = null;

?>