<?php 

$killOverride = false;
$pageTitle = "SeaAuth - Userlist";
require_once "authlib.php";
require_once "header.php";

$userID = base64_decode($_GET['userID']);
$cmd = $conn->prepare("select username, addr from $userTable where userID = :userID");
$cmd->bindParam(":userID", $userID, PDO::PARAM_INT);
$cmd->execute();
$results = $cmd->fetchAll();

//Check if exists
if(count($results) !== 1) {
	header('Location: userlist.php');
	die;
}

$user = $results[0];

?>
<main id="content-wrapper" class="container">
	<h1>SeaAuth</h1>
	<h3>Register your Device</h3>
	<hr />
	<form class="form" method="POST" action="save-user.php">
		<div class="form-group">
			<label for="username" class="control-label">Display Name:</label>
			<input type="text" class="form-control" id="username" name="username" maxlength="25" value="<?php echo $user['username']; ?>" />
		</div>
		<div class="form-group">
			<label for="addr" class="control-label">Address:</label>
			<input disabled type="text" class="form-control" id="addr" name="addr" value="<?php echo $user['addr']; ?>" />
		</div>
		<input type="hidden" name="userID" value="<?php echo $userID; ?>" />
		<button type="submit" class="btn btn-success col-md-1 col-md-offset-11">Save</button>
	</form>
</main>
<?php require_once "footer.php"; ?>