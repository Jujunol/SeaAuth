<?php

require_once "authlib.php";

$code = $_POST['ccode'];
$oldCode = $_POST['oldCode'];
$perms = $_POST['perms'];

$user = null;

if(!empty($oldCode) && hasPerm("codes.edit", $user)) {
	logEvent($conn, $logTable, "Changed SeaCode $oldCode to $code");
	$cmd = $conn->prepare("update $codeTable set codename = :code, perms = :perms 
		where codename = :oldCode");
	$cmd->bindParam(":code", $code, PDO::PARAM_STR, 10);
	$cmd->bindParam(":oldCode", $oldCode, PDO::PARAM_STR, 10);
	$cmd->bindParam(":perms", $perms, PDO::PARAM_STR, 100);
	$cmd->execute();

	$conn = $altConn = null;
	header('Location: codelist.php');
	die('');
}

$cmd = $conn->prepare("select userID from $codeTable where codename = :code");
$cmd->bindParam(":code", $code, PDO::PARAM_STR, 10);
$cmd->execute();
$results = $cmd->fetchAll();

if(count($results) === 0 && hasPerm("codes.add", $user)) {
	logEvent($conn, $logTable, "Added new SeaCode $code");
	$cmd = $conn->prepare("insert into $codeTable (codename, perms) 
		values (:code, :perms)");
	$cmd->bindParam(":code", $code, PDO::PARAM_STR, 10);
	$cmd->bindParam(":perms", $perms, PDO::PARAM_STR, 100);
	$cmd->execute();
	header('Location: codelist.php');
}
else header('Location: code.php');

$conn = $altConn = null;

?>