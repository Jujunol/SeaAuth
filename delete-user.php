<?php

require_once "authlib.php";

$userID = $_GET['userID'];

if(!empty($userID)) {
	$conn = setupConnection();
	$cmd = $conn->prepare("delete from $userTable where userID = :userID");
	$cmd->bindParam(":userID", $userID, PDO::PARAM_STR, 10);
	$cmd->execute();
}
header('Location: index.php');

?>