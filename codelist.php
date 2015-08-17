<?php 

$pageTitle = "SeaAuth - Code Management";
require_once "authlib.php";
require_once "header.php";

if(!hasPerm("codes.list", $user)) {
	header('Location: index.php');
	die;
}

?>
<main id="content-wrapper" class="container">
	<div class="page-header">
		<h1>SeaAuth <small>Code Management</small></h1>
	</div>
	<div class="btn-group">
		<a href="code.php" class="btn btn-warning">Add Code</a>
		<a href="?di" class="btn btn-warning">Show Inactive</a>
		<a href="permlist.php" class="btn btn-warning">Permission List</a>
	</div>
	<table class="table table-striped table-hover">
		<?php

		//Get Columns
		$cols = array("codename", "username", "perms");

		//Get fields
		$col_ss = implode(", ", $cols) . ", userID";
		$joinType = (isset($_GET['di']) && hasPerm("codes.inactive", $user) ? "left" : "") . " join";
		$cmd = $conn->prepare("select $col_ss from $codeTable 
			$joinType $userTable using(userID)");
		$cmd->execute();
		$results = $cmd->fetchAll();

		//Print out our table
		echo "<thead><tr>";
		foreach($cols as $col) {
			echo "<th>$col</th>";
		}
		echo "<th>Edit</th><th>Delete</th></tr></thead><tbody>";
		foreach($results as $row) {
			$ccode = base64_encode($row['codename']);
			echo "<tr>";
			foreach($cols as $col) {
				$val = strlen($row[$col]) > 47 ? substr($row[$col], 0, 47) . "..." : $row[$col];
				echo "<td>$val</td>";
			}
			echo "<td><a href='code.php?ccode=$ccode'>Edit</a></td>";
			echo "<td><a href='delete-code.php?ccode=$ccode' onclick='return confirm(\"Are you sure?\");'>X</a></td></tr>";
		}
		echo "</tbody>";

		?>
	</table>
</main>
<?php require_once "footer.php"; ?>