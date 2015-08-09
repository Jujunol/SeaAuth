<?php 

$pageTitle = "SeaAuth - Active Users";
require_once "authlib.php";
require_once "header.php";

?>
<main id="content-wrapper" class="container">
	<h1>SeaAuth</h1>
	<h3>Recent Actions</h3>
	<hr />
	<a href="sands/rentals.php" class="btn btn-default">Rental Portal</a>
	<a href="sands/featured.php" class="btn btn-default">Featured Portal</a>
	<table class="table table-striped table-hover">
		<?php

		//Get Columns
		$cols = array("logID", "username", "logTime", "logEvent");

		//Get fields
		$col_ss = implode(", ", $cols);
		$cmd = $conn->prepare("select $col_ss from $logTable 
			left join $userTable using(userID)
			order by logTime");
		$cmd->execute();
		$results = $cmd->fetchAll();

		//Print out our table
		echo "<thead><tr>";
		foreach($cols as $col) {
			echo "<th>$col</th>";
		}
		echo "</tr></thead><tbody>";
		foreach($results as $row) {
			echo "<tr>";
			foreach($cols as $col) {
				$val = strlen($row[$col]) > 47 ? substr($row[$col], 0, 47) . "..." : $row[$col];
				echo "<td>$val</td>";
			}
		}
		echo "</tbody>";

		?>
	</table>
</main>
<?php require_once "footer.php"; ?>