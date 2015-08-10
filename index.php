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
		<div class="col-md-3 col-md-offset-6">
			<form method="GET" class="form-horizontal">
				<input type="text" name="search" />
				<button type="submit" class="btn btn-default">Search</button>
			</form>
		</div>
	</div>
	<?php

	$cmd = $conn->prepare("select now() from $logTable");
	$cmd->execute();
	$results = $cmd->fetchAll();

	if(count($results)) {
		echo "<h2>Current Server Time: {$results[0][0]}</h2>";
	}

	?>
	<table class="table table-striped table-hover">
		<?php

		//Get Columns
		$search = (isset($_GET['search']) ? addslashes($_GET['search']) : "");
		$cols = array("logID", "username", "logTime", "logEvent");

		//Get fields
		$col_ss = implode(", ", $cols); //SQL safe Columns
		$where_ss = implode(" like '%$search%' or ", $cols) . " like '%$search%'";
		$sql = "select $col_ss from $logTable
			left join $userTable using(userID)
			where $where_ss
			order by logTime desc
			limit 30";
		echo "<code>$sql</code>";
		$cmd = $conn->prepare($sql);
		// $where = isset($_GET['search']) ? str_replace('"', "'", $_GET['search']) : "1";
		// $cmd = $conn->prepare("select $col_ss from $logTable 
		// 	left join $userTable using(userID)
		// 	where $where
		// 	order by logTime desc
		// 	limit 30");
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