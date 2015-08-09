<?php 

$pageTitle = "SeaAuth - Active Users";
require_once "authlib.php";
require_once "header.php";

?>
<main id="content-wrapper" class="container">
	<h1>SeaAuth</h1>
	<h3>Recent Actions</h3>
	<hr />
	<div class="row">
		<div class="col-md-3">
			<a href="sands/rentals.php" class="btn btn-default">Rental Portal</a>
			<a href="sands/featured.php" class="btn btn-default">Featured Portal</a>
		</div>
		<div class="col-md-3 col-md-offset-9">
			<form method="GET">
				<input type="text" name="search" />
				<button type="submit" class="btn btn-default">Search</button>
			</form>
		</div>
	</div>
	<table class="table table-striped table-hover">
		<?php

		//Get Columns
		$cols = array("logID", "username", "logTime", "logEvent");

		//Get fields
		$col_ss = implode(", ", $cols);
		$where = isset($_GET['search']) ? str_replace('"', "'", $_GET['search']) : "1";
		$cmd = $conn->prepare("select $col_ss from $logTable 
			left join $userTable using(userID)
			where $where
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