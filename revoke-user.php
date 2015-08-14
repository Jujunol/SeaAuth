<?php

require_once "authlib.php";

if(!isset($_GET['userID'])) {
	header('Location: userlist.php');
	die('');
}

$userID = base64_decode($_GET['userID']);
$active = isset($_GET['undo']) ? "1" : "0";

$cmd = $conn->prepare("update $userTable set active = :active where userID = :userID");
$cmd->bindParam(":active", $active, PDO::PARAM_STR, 1);
$cmd->bindParam(":userID", $userID, PDO::PARAM_INT);
$cmd->execute();

$revoked = isset($_GET['undo']) ? "Unrevoked" : "Revoked";
logEvent($conn, $logTable, "$revoked userID $userID");

//Disconnect
$conn = $altConn = null;
header('Location: userlist.php');

?>