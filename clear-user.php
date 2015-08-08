<?php

//Setup Connection and check authorization
require_once "authlib.php";

//Check if a UserID is specified
$userID = $_GET['userID'];
if(empty($userID)) {
	header('Location: index.php');
	die('');
}

//Grab the user and set address to null
$user = getUser($conn, $userTable, $userID);
if($user !== null) {
	$cmd = $conn->prepare("update $userTable set addr=null where userID = ?");
	$cmd->execute(array($userID));
}

//Disconnect
$conn = null;
$altConn = null;
header('Location: index.php');

?>