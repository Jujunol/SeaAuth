<?php

/** May Revert to previous functionality
//Setup Connection and check authorization
require_once "authlib.php";

$userID = $_SESSION['userID'];

//Grab the user and set address to null
logEvent($conn, $logTable, "Logged out");
$cmd = $conn->prepare("update $codeTable set userID = null where userID = :userID");
$cmd->bindParam(":userID", $userID, PDO::PARAM_INT);
$cmd->execute();

unset($_SESSION);
session_destroy();

//Disconnect
$conn = $altConn = null;
header('Location: login.php');
*/

/** Updated Code */
session_start();

unset($_SESSION);
setcookie("uk", "", time() - 10);

session_destroy();
header('Location: login.php');

?>