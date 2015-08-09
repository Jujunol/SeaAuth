<?php

require_once "authlib.php";

$code = $_POST['ccode'];
$oldCode = $_POST['oldCode'];

if(!empty($oldCode)) {
	$cmd = $conn->prepare("update $codeTable set codename = :code where codename = :oldCode");
	$cmd->bindParam(":code", $code, PDO::PARAM_STR, 10);
	$cmd->bindParam(":oldCode", $oldCode, PDO::PARAM_STR, 10);
	$cmd->execute();

	$conn = $altConn = null;
	header('Location: codelist.php');
	die('');
}

$cmd = $conn->prepare("select userID from $codeTable where codename = :code");
$cmd->bindParam(":code", $code, PDO::PARAM_STR, 10);
$cmd->execute();
$results = $cmd->fetchAll();

if(count($results) === 0) {
	$cmd = $conn->prepare("insert into $codeTable (codename) values (:code)");
	$cmd->bindParam(":code", $code, PDO::PARAM_STR, 10);
	$cmd->execute();
	header('Location: codelist.php');
}
else header('Location: user.php');

$conn = $altConn = null;

?>