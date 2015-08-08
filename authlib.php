<?php

session_start();

//Set Table names here
$userTable = "cauth_users";
$rentalTable = "Rentals";
$featuredTable = "Featured";

$conn; $altConn;
setupConnections($conn, $altConn);

if(!isset($killOverride) && !isValidID()) {
	header('Location: login.php');
	die('');
}

function isValidID() {
	global $conn, $userTable;
	$addr = $_SERVER['REMOTE_ADDR'] ? : "Unknown";
	$cmd = $conn->prepare("select * from $userTable where addr = '$addr'");
	$cmd->execute();
	$results = $cmd->fetchAll();

	if(count($results) == 1) {
		$_SESSION['userID'] = $results[0]['userID'];
		//header('Location: userlist.php');
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

//Returns the user by ID
function getUser(&$conn, &$tableName, &$userID) {
	$cmd = $conn->prepare("select * from $tableName where userID = ?");
	$cmd->execute(array($userID));
	$users = $cmd->fetchAll();
	if(count($users) != 1) return null;
	return $users[0];
}

//Returns the list of users
function getUserList(&$conn, &$tableName) {
	$cmd = $conn->prepare("select * from $tableName");
	$cmd->execute();
	return $cmd->fetchAll();
}

//Returns the current User information
function getCurrentUser(&$conn, &$tableName) {
	return getUser($conn, $tableName, $_SESSION['userID']);
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