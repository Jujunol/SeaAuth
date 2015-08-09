<?php

require_once "authlib.php";

$code = base64_decode($_GET['ccode']);
if(!empty($code)) {
	$cmd = $conn->prepare("delete from $codeTable where codename = :code");
	$cmd->bindParam(":code", $code, PDO::PARAM_STR, 10);
	$cmd->execute();
}

//Disconnect
$conn = $altConn = null;
header('Location: codelist.php');

?>