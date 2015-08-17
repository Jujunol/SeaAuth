<?php 

$pageTitle = "SeaAuth - Registered Users";
require_once "authlib.php";
require_once "header.php";

if(!hasPerm('users.list', $user)) {
	header('Location: index.php');
	die;
}

?>
<main id="content-wrapper" class="container">
	<div class="page-header">
		<h1>SeaAuth <small>User Management</small></h1>
	</div>
	<a class="btn btn-warning" href="?di">Show Inactive</a>
	<table class="table table-striped table-hover">
		<?php

		//Get Columns
		$cols = getColumns($conn, $userTable);

		//Get fields
		$col_ss = implode(", ", $cols);
		$where = isset($_GET['di']) && hasPerm("users.inactive", $user) ? "": "where active = '1'";
		$cmd = $conn->prepare("select $col_ss from $userTable $where order by userID");
		$cmd->execute();
		$results = $cmd->fetchAll();

		//Print out our table
		echo "<thead><tr>";
		foreach($cols as $col) {
			echo "<th>$col</th>";
		}
		echo "<th>Edit</th><th>Deactivate</tr></thead><tbody>";
		foreach($results as $row) {
			echo "<tr>";
			foreach($cols as $col) {
				if($col == "addr" && !hasPerm("users.addr", $user)) $val = "***.***.***.***";
				else $val = strlen($row[$col]) > 47 ? substr($row[$col], 0, 47) . "..." : $row[$col];
				echo "<td>$val</td>";
			}
			$params = "?userID=" . base64_encode($row['userID']);
			$params .= $row['active'] == 0 ? "&undo" : "";
			echo "<td><a href='user.php$params'>Edit</a></td>";
			echo "<td><a href='revoke-user.php$params' onclick='return confirm(\"Are you sure?\");'>X</a></td>";
		}
		echo "</tbody>";

		?>
	</table>
</main>
<?php require_once "footer.php"; ?>