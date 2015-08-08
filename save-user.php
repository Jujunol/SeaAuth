<?php

require_once "authlib.php";

$userID = $_POST['userID'];
$newID = $_POST['ccode'];

if(!empty($userID)) {
	$cmd = $conn->prepare("update $userTable set userID = ? where userID = ? limit 1");
	$cmd->execute(array($newID, $userID));

	$conn = $altConn = null;
	header('Location: index.php');
	die('');
}

$user = getUser($conn, $userTable, $userID);
if($user === null) {
	$cmd = $conn->prepare("insert into $userTable (userID) values (?)");
	$cmd->execute(array($newID));
	header('Location: index.php');
}
else header('Location: user.php');

$conn = $altConn = null;

?>