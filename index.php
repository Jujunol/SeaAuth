<?php 

$pageTitle = "SeaAuth - Active Users";
require_once "authlib.php";
require_once "header.php";

?>
<main id="content-wrapper" class="container">
	<div class="page-header">
		<h1>SeaAuth <small>Recent Actions</small></h1>
	</div>
	<div class="row">
		<div class="col-md-6 btn-group">
			<a href="sands/rentals.php" class="btn btn-warning">Rental Portal</a>
			<a href="sands/featured.php" class="btn btn-warning">Featured Portal</a>
		</div>
		<div class="col-md-3 col-md-offset-3">
			<form method="GET" class="form">
				<div class="input-group">
					<input type="text" name="search" class="form-control" placeholder="Search For..." 
						value="<?php echo isset($_GET['search']) ? $_GET['search'] : ""; ?>" />
					<span class="input-group-btn">
						<button type="submit" class="btn btn-warning">Go</button>
					</span>
				</div>
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

		if(hasPerm("log.view")) {
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
		}

		?>
	</table>
</main>
<?php require_once "footer.php"; ?>