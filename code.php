<?php

$pageTitle = "SeaAuth - User Management";
require_once "authlib.php";
require_once "header.php";

$ccode = isset($_GET['ccode']) ? $_GET['ccode']  : "";
$code = base64_decode($ccode);
$username = $userID = "";
if(!empty($code)) {
	$cmd = $conn->prepare("select userID, username from $userTable where userID = 
		(select userID from $codeTable where codename = :code)");
	$cmd->bindParam(":code", $code, PDO::PARAM_INT);
	$cmd->execute();
	$results = $cmd->fetchAll();

	if(count($results) === 1) {
		$username = $results[0]['username'];
		$userID = $results[0]['userID'];
	}
}	

?>
<main id="content-wrapper" class="container">
	<h1>SeaAuth</h1>
	<h3>Code Management</h3>
	<hr />
	<form class="form" method="POST" action="save-code.php">
		<div class="form-group">
			<label for="ccode" class="control-label">New SeaCode:</label>
			<input type="text" class="form-control" name="ccode" id="ccode" maxlength="10" required value="<?php echo $code; ?>" />
		</div>
		<?php

		if(!empty($code)) { ?>
		<div class="form-group">
			<label for="username" class="control-label">Registered User:</label>
			<input type="text" class="form-control" id="username" disabled required value="<?php echo $username; ?>" />
			<a href="clear-code.php?ccode=<?php echo $_GET['ccode']; ?>" onclick="return confirm('You sure ?');">Clear User</a>
		</div>
		<?php  
			echo "<input type='hidden' name='oldCode' value='$code' />";
		}
		?>
		<button type="submit" class="btn btn-success col-md-offset-11">Submit</button>
	</form>
</main>
<?php require_once "footer.php"; ?>