<?php 

$pageTitle = "SeaAuth - Userlist";
require_once "authlib.php";
require_once "header.php";

?>
<main id="content-wrapper" class="container">
	<h1>SeaAuth</h1>
	<h3>User Management</h3>
	<hr />
	<a href="user.php" class="btn btn-default">Add User</a>
	<a href="sands/rentals.php" class="btn btn-default">Enter Rentals DB</a>
	<a href="sands/featured.php" class="btn btn-default">Enter Featured DB</a>
	<table class="table table-striped table-hover">
		<?php

		//establish connection
		$conn = setupConnection();

		//Get Columns
		$cols = getColumns($conn, $userTable);

		//Get fields
		$results = getUserList($conn, $userTable);

		//disconnect
		$conn = null;

		//Print out our table
		echo "<thead><tr>";
		foreach($cols as $col) {
			echo "<th>$col</th>";
		}
		echo "<th>Edit</th><th>Delete</th></tr></thead><tbody>";
		foreach($results as $row) {
			echo "<tr>";
			foreach($cols as $col) {
				$val = strlen($row[$col]) > 47 ? substr($row[$col], 0, 47) . "..." : $row[$col];
				echo "<td>$val</td>";
			}
			echo "<td><a href='user.php?userID={$row['userID']}'>Edit</a></td>";
			echo "<td><a href='delete-user.php?userID={$row['userID']}' onclick='return confirm(\"Are you sure?\");'>X</a></td></tr>";
		}
		echo "</tbody>";

		?>
	</table>
</main>
<?php require_once "footer.php"; ?>