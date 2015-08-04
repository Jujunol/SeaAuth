<?php 

$pageTitle = "SeaAuth - Featured Properties";
require_once "../authlib.php";
require_once "../header.php";

?>
<main id="content-wrapper" class="container">
	<h1>SeaAuth</h1>
	<h3>Feature Property Management</h3>
	<hr />
	<a href="../index.php" class="btn btn-default">&lt;-- SeaAuth</a>
	<table class="table table-striped table-hover">
		<?php

		//establish connection
		$conn = setupConnection();

		//Get Columns
		/*$cmd = $conn->prepare("desc $tableName");
		$cmd->execute();
		$cols = $cmd->fetchAll(PDO::FETCH_COLUMN);*/
		$cols = array("Index", "Active", "Title");

		//Get fields
		$cmd = $conn->prepare("select `Index`, Active, Title from $featuredTable order by `Index`");
		$cmd->execute();
		$results = $cmd->fetchAll();

		//disconnect
		$conn = null;

		//Print out our table
		echo "<thead><tr>";
		foreach($cols as $col) {
			echo "<th>$col</th>";
		}
		echo "<th>Edit</th></tr></thead><tbody>";
		foreach($results as $row) {
			echo "<tr>";
			foreach($cols as $col) {
				$val = strlen($row[$col]) > 47 ? substr($row[$col], 0, 47) . "..." : $row[$col];
				echo "<td>$val</td>";
			}
			echo "<td><a href='featured-property.php?propertyID={$row['Index']}'>Edit</a></td>";
			//echo "<td><a href='delete-user.php?userID={$row['userID']}' onclick='return confirm(\"Are you sure?\");'>X</a></td></tr>";
		}
		echo "</tbody>";

		?>
	</table>
</main>
<?php require_once "../footer.php"; ?>