<?php

session_start();

//Set Table names here
$userTable = "cauth_users";
$codeTable = "cauth_codes";
$logTable = "cauth_log";
$rentalTable = "Rentals";
$featuredTable = "Featured";

$conn; $altConn;
setupConnections($conn, $altConn);

if(!isset($killOverride) && !isValidID()) {
	header('Location: login.php');
	die('');
}

function isValidID() {
	global $conn, $userTable, $codeTable;
	$addr = $_SERVER['REMOTE_ADDR'] ? : "Unknown";
	$cmd = $conn->prepare("select userID from $codeTable 
		inner join $userTable using(userID) 
		where addr = '$addr'");
	$cmd->execute();
	$results = $cmd->fetchAll();

	if(count($results) === 1) {
		$_SESSION['userID'] = $results[0]['userID'];
		return true;
	}
	return false;
}

//Setups the connection to the server
function setupConnections(&$conn, &$altConn) {
	require_once "mysql_login.php";
	$conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //debug

	if(isset($altHost)) {
		$altConn = new PDO("mysql:host=$altHost;dbname=$altName", $altUsername, $altPassword);
		$altConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //debug
	}
	else $altConn = $conn;
}

//Returns the column names
function getColumns(&$conn, &$tableName) {
	$cmd = $conn->prepare("desc $tableName");
	$cmd->execute();
	return $cmd->fetchAll(PDO::FETCH_COLUMN);
}

function logEvent(&$conn, &$tableName, $evt) {
	$userID = (isset($_SESSION['userID']) ? $_SESSION['userID'] : "null");
	$cmd = $conn->prepare("insert into $tableName (logEvent, userID)
		values (:evt, $userID)");
	$cmd->bindParam(":evt", $evt, PDO::PARAM_STR, 250);
	//$cmd->bindParam(":userID", $userID, PDO::PARAM_INT);
	$cmd->execute();
}

//Checks whether they have permission
function hasPerm(&$user, $perm) {
	$perms = explode(',', $user['perms']);
	$allowed = false;
	foreach($perms as $p) {
		$p = trim($p); //some cleanup
		$permPrefix = substr($perm, 0, strpos($perm, '.'));

		if($p == "*") $allowed = true; //If they have all perms, but may be revoked so keep checking
		if($permPrefix . ".*" == $p) $allowed = true; //Have all of that type of perm, but might be regeted later
		if($p == $perm) return true; //Definate match, stop checking
		if("#" . $perm == $p) return false; //Definate revoked
		if("#" . $permPrefix . ".*" == $p) return false;
	}
	return $allowed;
}

?>