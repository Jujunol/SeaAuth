<?php

//Setup Connection and check authorization
require_once "authlib.php";

//Check if a UserID is specified
$code = base64_decode($_GET['ccode']);

//Grab the user and set address to null
$cmd = $conn->prepare("update $codeTable set userID = null where codename = :code");
$cmd->bindParam(":code", $code, PDO::PARAM_INT);
$cmd->execute();

//Disconnect
$conn = $altConn = null;
header('Location: codelist.php');

?>