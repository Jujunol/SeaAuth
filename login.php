<?php

$killOverride = true;
$pageTitle = "SeaAuth - Unidentified Account";
require_once "authlib.php";

if(isValidID()) {
	header('Location: index.php');
	die('');
}

require_once "header.php";

?>
<main class="container">
	<h1>SeaAuth - Account Unidentified</h1>
	<h3>You must login to continue</h3>
	<hr />
	<form class="form" method="POST" action="validate.php">
		<div class="form-group">
			<label for="ccode" class="control-label">Enter SeaCode:</label>
			<input type="text" class="form-control" name="ccode" id="ccode" required />
		</div>
		<button type="submit" class="btn btn-success">Request Access</button>
	</form>
</main>
<?php require_once "footer.php"; ?>