<?php

require_once "authlib.php";

$userID = $_POST['userID'];
$newID = $_POST['ccode'];

$tableName = "cauth_users";

$conn = setupConnection();

if(!empty($userID)) {
	$cmd = $conn->prepare("update $tableName set userID = ? where userID = ? limit 1");
	$cmd->execute(array($newID, $userID));
	$conn = null;
	header('Location: index.php');
	die('');
}

$user = getUser($conn, $tableName, $userID);

if($user === null) {
	$cmd = $conn->prepare("insert into $tableName (userID) values (?)");
	$cmd->execute(array($newID));
	header('Location: index.php');
}
else header('Location: user.php');

$conn = null;

?>