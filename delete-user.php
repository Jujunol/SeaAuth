<?php

require_once "authlib.php";

$userID = $_GET['userID'];

if(!empty($userID)) {
	$conn = setupConnection();
	$tableName = "cauth_users";
	$cmd = $conn->prepare("delete from $tableName where userID = :userID");
	$cmd->bindParam(":userID", $userID, PDO::PARAM_STR, 10);
	$cmd->execute();
}
header('Location: index.php');

?>