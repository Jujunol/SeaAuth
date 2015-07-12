<?php

require_once "authlib.php";
require_once "login_cred.php";

$propertyID = $_POST['index'];
$pid = $_POST['propertyID'];
//$tableName = "Rentals";

//establish connection
$conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Get Columns
$cmd = $conn->prepare("desc $tableName");
$cmd->execute();
$cols = $cmd->fetchAll(PDO::FETCH_COLUMN);
//$cols = array("propertyID", "active", "title");

if(!empty($pid) && $pid == $propertyID) {
	$updateValues = array();
	foreach($cols as $col) {
		array_push($updateValues, $_POST[$col]);
	}
	array_push($updateValues, $propertyID);
	//Build update string
	$updateString = "";
	foreach($cols as $col) {
		if($col != "index" && $col != "keys")
			$updateString .= $col . " = ?, ";
		else 
			$updateString .= "`$col` = ?, ";
	}
	$updateString = substr($updateString, 0, strlen($updateString) - 2);

	$cmd = $conn->prepare("update $tableName set $updateString where `index` = ? limit 1");
	$cmd->execute($updateValues);
	$conn = null;
	header('Location: home.php');
	die('');
}

$updateValues = array();
foreach($cols as $col) {
	if($col != "index")
		array_push($updateValues, $_POST[$col]);
	else
		array_push($updateValues, null);
}
//Build update string
$updateString = "";
foreach($cols as $col) {
	$updateString .= "?, ";
}
$updateString = substr($updateString, 0, strlen($updateString) - 2);

$cmd = $conn->prepare("insert into $tableName values ($updateString)");
$cmd->execute($updateValues);
header('Location: home.php');;

$conn = null;

?>