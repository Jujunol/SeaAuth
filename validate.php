<?php

$userID = $_POST['ccode'];

if(empty($userID)) {
	header('Location: login.php');
	die('');
}

$killOverride = true;
require_once "authlib.php";

$user = getUser($conn, $userTable, $userID);

if($user !== null && empty($user['addr'])) {
	$cmd = $conn->prepare("update $userTable set addr = ? where userID = ? limit 1");
	$cmd->execute(array($_SERVER['REMOTE_ADDR'], $userID));
	header('Location: index.php');
}
else header('Location: login.php');

$conn = $altConn = null;

?>