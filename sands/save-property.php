<?php

require_once "../authlib.php";

$propertyID = $_POST['index'];
$pid = $_POST['propertyID'];

//establish connection
$conn = setupConnection();

//Get Columns
$cmd = $conn->prepare("desc $rentalTable");
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
		if($col != "index" && $col != "keys")
			$updateString .= $col . " = ?, ";
		else 
			$updateString .= "`$col` = ?, ";
	}
	$updateString = substr($updateString, 0, strlen($updateString) - 2);

	$cmd = $conn->prepare("update $rentalTable set $updateString where `index` = ? limit 1");
	$cmd->execute($updateValues);

	//Disconnect
	$conn = null;
	header('Location: rentals.php');
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
for($i = 0; $i < count($cols); $i++) {
	$updateString .= "?, ";
}
$updateString = substr($updateString, 0, strlen($updateString) - 2);

$cmd = $conn->prepare("insert into $rentalTable values ($updateString)");
$cmd->execute($updateValues);

//Disconnect
$conn = null;
header('Location: rentals.php');

?>