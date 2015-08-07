<?php 

$pageTitle = "SeaAuth - Rentals";
require_once "../authlib.php";
require_once "../header.php";

?>
<main id="content-wrapper" class="container">
	<h1>SeaAuth</h1>
	<h3>Rental Management</h3>
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
		$cols = array("index", "active", "title");

		//Get fields
		//Get fields
		$sql = "select `index`, active, title from $rentalTable";
		if(isset($_GET['oa'])) $sql .= " where active = 1";
		if(isset($_GET['sort'])) $sql .= " order by " . addslashes(base64_decode($_GET['sort']));
		else $sql .= " order by `index`";
		$cmd = $conn->prepare($sql);
		$cmd->execute();
		$results = $cmd->fetchAll();

		//disconnect
		$conn = null;

		//Print out our table
		echo "<thead><tr>";
		echoColumns($cols);
		echo "<th>Edit</th></tr></thead><tbody>";
		foreach($results as $row) {
			echo "<tr>";
			foreach($cols as $col) {
				$val = strlen($row[$col]) > 47 ? substr($row[$col], 0, 47) . "..." : $row[$col];
				echo "<td>$val</td>";
			}
			echo "<td><a href='property.php?propertyID={$row['index']}'>Edit</a></td>";
			//echo "<td><a href='delete-user.php?userID={$row['userID']}' onclick='return confirm(\"Are you sure?\");'>X</a></td></tr>";
		}
		echo "</tbody>";

		function echoColumns(&$cols) {
			$current = isset($_GET['sort']) ? $_GET['sort'] : "";
			foreach($cols as $col) {
				$col_ss = "`$col`"; //Make string safe
				$val = base64_encode($col_ss . ($current == base64_encode($col_ss) ? " DESC" : ""));
				echo "<th><a href='rentals.php?sort=$val'>$col</a></th>";
			}
		}

		?>
	</table>
</main>
<?php require_once "../footer.php"; ?>