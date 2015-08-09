<?php

require_once "../authlib.php";

$propertyID = $_POST['Index'];
$pid = $_POST['propertyID'];

//Get Columns
$cmd = $altConn->prepare("desc $featuredTable");
$cmd->execute();
$cols = $cmd->fetchAll(PDO::FETCH_COLUMN);
//$cols = array("propertyID", "active", "title");

if(!empty($pid) && $pid == $propertyID) {
	//Prepare Updated values
	$updateValues = array();
	foreach($cols as $col) {
		array_push($updateValues, $_POST[$col]);
	}
	array_push($updateValues, $propertyID);
	
	//Build update string
	$updateString = "";
	foreach($cols as $col) {
		if($col != "Index")
			$updateString .= $col . " = ?, ";
		else 
			$updateString .= "`$col` = ?, ";
	}
	$updateString = substr($updateString, 0, strlen($updateString) - 2);

	logEvent($conn, $logTable, "Changed Featured Property " . $_POST['Index']);
	$cmd = $altConn->prepare("update $featuredTable set $updateString where `Index` = ? limit 1");
	$cmd->execute($updateValues);

	//Disconnect
	$conn = $altConn = null;
	header('Location: featured.php');
	die('');
}

$updateValues = array();
foreach($cols as $col) {
	if($col != "Index")
		array_push($updateValues, $_POST[$col]);
	else
		array_push($updateValues, null);
}
//Build update string
$updateString = "";
for($i = 0; $i < count($cols); $i++) {
	$updateString .= "?, ";
}
$updateString = substr($updateString, 0, strlen($updateString) - 2);

logEvent($conn, $logTable, "Created New Featured Property");
$cmd = $altConn->prepare("insert into $featuredTable values ($updateString)");
$cmd->execute($updateValues);

//Disconnect
$conn = $altConn = null;
header('Location: featured.php');

?>