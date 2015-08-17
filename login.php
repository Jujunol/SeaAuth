<?php

$killOverride = true;
$pageTitle = "SeaAuth - Unidentified Account";
require_once "authlib.php";

if(isValidID()) {
	$conn = $altConn = null;
	header('Location: index.php');
	die('');
}

//Check if it's a new ip
$addr = $_SERVER['REMOTE_ADDR'];
$cmd = $conn->prepare("select userID, active from $userTable where addr = :addr");
$cmd->bindParam(":addr", $addr, PDO::PARAM_STR, 16);
$cmd->execute();
$results = $cmd->fetchAll();

if(count($results) === 0) {
	//For Debugging 
	if(isset($_SESSION['userID'])) {
		unset($_SESSION);
		session_destroy();
	}
	//End of debugging
	logEvent($conn, $logTable, "Foreign device connected $addr");
	$conn = $altConn = null;
	header("Location: new-user.php");
	die('');
}
else if($results[0]['active'] == '0') {
	header('Location: lockout.php');
	die('');
}
$_SESSION['userID'] = $results[0]['userID'];

require_once "header.php";

?>
<main class="container">
	<div class="page-header">
		<h1>SeaAuth <small>You must login to continue</small></h1>
	</div>
	<form class="form" method="POST" action="validate.php">
		<div class="form-group">
			<label for="ccode" class="control-label">Enter SeaCode:</label>
			<input type="text" class="form-control" name="ccode" id="ccode" required />
		</div>
		<button type="submit" class="btn btn-warning">Request Access</button>
	</form>
</main>
<?php require_once "footer.php"; ?>