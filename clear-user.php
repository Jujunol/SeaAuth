<?php

require_once "authlib.php";

$userID = $_GET['userID'];

$tableName = "cauth_users";

$conn = setupConnection();

if(empty($userID)) {
	header('Location: index.php');
	die('');
}

$user = getUser($conn, $tableName, $userID);

if($user !== null) {
	$cmd = $conn->prepare("update $tableName set addr=null where userID = ?");
	$cmd->execute(array($userID));
}
header('Location: index.php');

$conn = null;

?>