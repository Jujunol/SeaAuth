<?php 

$killOverride = false;
$pageTitle = "SeaAuth - Registering your Device";
require_once "authlib.php";
require_once "header.php";

//If the device is already registered
$addr = $_SERVER['REMOTE_ADDR'];
$cmd = $conn->prepare("select userID from $userTable where addr = :addr");
$cmd->bindParam(":addr", $addr, PDO::PARAM_STR, 16);
$cmd->execute();
$results = $cmd->fetchAll();

if(count($results) === 1) {
	header('Location: login.php');
	die('');
}

?>
<main id="content-wrapper" class="container">
	<div class="page-header">
		<h1>SeaAuth <small>Registering your Device</small></h1>
	</div>
	<form class="form" method="POST" action="save-user.php">
		<div class="form-group">
			<label for="username" class="control-label">Enter a recogizable name for this device:</label>
			<input type="text" class="form-control" id="username" name="username" maxlength="25" />
		</div>
		<button type="submit" class="btn btn-warning col-md-1 col-md-offset-11">Save</button>
	</form>
</main>
<?php require_once "footer.php"; ?>