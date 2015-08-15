<?php 

$pageTitle = "SeaAuth - Registered Users";
require_once "authlib.php";
require_once "header.php";

?>
<main id="content-wrapper" class="container">
	<h1>SeaAuth</h1>
	<h3>Registered Users</h3>
	<hr />
	<a class="btn btn-default" href="?di">Show Inactive</a>
	<table class="table table-striped table-hover">
		<?php

		//Get Columns
		$cols = getColumns($conn, $userTable);

		//Get fields
		$col_ss = implode(", ", $cols);
		$where = isset($_GET['di']) ? "": "where active = '1'";
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
				$val = strlen($row[$col]) > 47 ? substr($row[$col], 0, 47) . "..." : $row[$col];
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