<?php

$pageTitle = "SeaAuth - User Management";
require_once "authlib.php";
require_once "header.php";

$ccode = isset($_GET['ccode']) ? $_GET['ccode']  : "";
$code = base64_decode($ccode);
$username = $userID = $perms = "";
if(!empty($code)) {
	$cmd = $conn->prepare("select userID, username, perms from $codeTable
		left join $userTable using(userID) 
		where codename = :code");
	$cmd->bindParam(":code", $code, PDO::PARAM_INT);
	$cmd->execute();
	$results = $cmd->fetchAll();

	//Set vars if editing
	if(count($results) === 1) {
		$username = $results[0]['username'];
		$userID = $results[0]['userID'];
		$perms = $results[0]['perms'];
	}
}	

?>
<main id="content-wrapper" class="container">
	<div class="page-header">
		<h1>SeaAuth <small>Code Management</small></h1>
	</div>
	<form class="form" method="POST" action="save-code.php">
		<div class="form-group">
			<label for="ccode" class="control-label">New SeaCode:</label>
			<input type="text" class="form-control" name="ccode" id="ccode" maxlength="10" required value="<?php echo $code; ?>" />
		</div>
		<?php

		if(!empty($code)) { ?>
		<div class="form-group">
			<label for="username" class="control-label">Registered User:</label>
			<input type="text" class="form-control" id="username" disabled value="<?php echo $username; ?>" />
			<a href="clear-code.php?ccode=<?php echo $_GET['ccode']; ?>" onclick="return confirm('You sure ?');">Clear User</a>
		</div>
		<?php  
			echo "<input type='hidden' name='oldCode' value='$code' />";
		}
		?>
		<div class="form-group">
			<label for="perms" class="control-label">Permissions:</label>
			<span><small><em>Seperate with comma. eg. users.list, users.edit, #codes.*</em></small></span>
			<input type="text" class="form-control" id="perms" name="perms" required value="<?php echo $perms; ?>" />
		</div>
		<button type="submit" class="btn btn-warning col-md-1 col-md-offset-11">Submit</button>
	</form>
</main>
<?php require_once "footer.php"; ?>