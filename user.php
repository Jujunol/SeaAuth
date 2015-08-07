<?php

$pageTitle = "SeaAuth - User Management";
require_once "authlib.php";
require_once "header.php";

$userID = isset($_GET['userID']) ? $_GET['userID'] : "";
$addr = "";
if(!empty($userID)) {
	$tableName = "cauth_users";
	$conn = setupConnection();

	$user = getUser($conn, $tableName, $userID);

	if($user !== null) {
		$addr = $user['addr'];
	}

	$conn = null;
}

?>
<main id="content-wrapper" class="container">
	<h1>SeaAuth</h1>
	<h3>User Management</h3>
	<hr />
	<a href="index.php" class="btn btn-default">&lt;-- Userlist</a>
	<form class="form" method="POST" action="save-user.php">
		<div class="form-group">
			<label for="ccode" class="control-label">New SeaCode:</label>
			<input type="text" class="form-control" name="ccode" id="ccode" maxlength="10" required value="<?php echo $userID; ?>" />
		</div>
		<?php

		if(!empty($userID)) { ?>
		<div class="form-group">
			<label for="addr" class="control-label">Registered IP:</label>
			<input type="text" class="form-control" id="addr" disabled required value="<?php echo $addr; ?>" />
			<a href="clear-user.php?userID=<?php echo $userID; ?>" onclick="return confirm('You sure ?');">Clear IP</a>
		</div>
		<?php } 
			echo "<input type='hidden' name='userID' value='$userID' />";
		?>
		<button type="submit" class="btn btn-success col-md-offset-11">Submit</button>
	</form>
</main>
<?php require_once "footer.php"; ?>