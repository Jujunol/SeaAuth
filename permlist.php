<?php

$killOverride = true;
$pageTitle = "SeaAuth - Permissions List";
require_once "authlib.php";
require_once "header.php";

$perms = array(

	array("Portal Permissions" ,
		"portal.*" => "Provides all access to portals",
		"portal.access" => "Allows the user to access the portals",
		"portal.edit" => "Allows the user to edit portal information",
	),

	array("Permissions for SeaCodes", 
		"codes.*" => "Provides all access to codes",
		"codes.list" => "Allows the user to view code information",
		"codes.inactive" => "Allows the user to view inactive codes",
		"codes.add" => "Allows the user to add new codes",
		"codes.edit" => "Allows the user to modify SeaCodes",
		"codes.clear" => "Allows the user to clear any users code",
		"codes.delete" => "Allows the user to delete SeaCodes",
	),

	array("SeaUser Permissions",
		"users.*" => "Provides all access to users",
		"users.list" => "Allows the user to view user information",
		"users.inactive" => "Allow the user to view deactivated users",
		"users.addr" => "Allow the user to view the IP address",
		"users.edit" => "Allows the user to edit other users",
		"users.revoke" => "Allows the user to revoke access to other users",
	),

	array("Misc", 
		"log.view" => "Allows the user to view the activity log",
	),
	
);

?>
<main class="container">
	<div class="page-header">
		<h1>SeaAuth <small>Code Management</small></h1>
	</div>
	<div class='alert alert-warning alert-dismissible' role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Warning!</strong> 
		Giving a user codes.add or codes.edit will allow the user to edit their own perms!
	</div>
	<div class='alert alert-warning alert-dismissible' role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Warning!</strong> 
		With the codes.inactive will allow the user to see all available SeaCodes and potentially log in with them!
	</div>
	<?php

	foreach($perms as $permSet) {
		echo "<div class='panel panel-success'><div class='panel-heading'>";
		echo "$permSet[0]</div><div class='panel-body'><div class='row'>";
		foreach($permSet as $perm => $desc) {
			if($perm === 0) continue;
			echo "<div class='col-lg-3 col-md-4'>";
			echo "<div class='thumbnail'><div class='caption'>";
			echo "<h3>$perm</h3><p>$desc</p></div></div></div>";
		}
		echo "</div></div></div>";
	}

	?>
</main>
<?php require_once "footer.php"; ?>