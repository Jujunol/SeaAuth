<?php

$pageTitle = "SeaAuth - Featured Property Management";
require_once "../authlib.php";
require_once "../header.php";

$propertyID = isset($_GET['propertyID']) ? $_GET['propertyID'] : "";

//establish connection
$conn = setupConnection();

//Get Columns
$cmd = $conn->prepare("desc $featuredTable");
$cmd->execute();
$cols = $cmd->fetchAll(PDO::FETCH_COLUMN);
//$cols = array("propertyID", "active", "title");

$property = null;
if(!empty($propertyID)) {
	//Get fields
	$cmd = $conn->prepare("select * from $featuredTable where `Index` = :propertyID");
	$cmd->bindParam(":propertyID", $propertyID, PDO::PARAM_INT);
	$cmd->execute();
	$results = $cmd->fetchAll();
	if(count($results) == 1) $property = $results[0];
}

//disconnect
$conn = null;

?>
<main id="content-wrapper" class="container">
	<h1 id="page-top">SeaAuth</h1>
	<h3>Featured Property Management</h3>
	<hr />
	<a  style="position: fixed; top: 32px; right: 32px;" href="#page-top">Back to top</a>
	<a href="featured.php" class="btn btn-default">&lt;-- Property List</a>
	<form class="form-horizontal" method="POST" action="save-featured-property.php">
		<button type="submit" class="btn btn-success col-md-offset-11">Save Changes</button>
		<?php

		foreach($cols as $col) {
			echo "<div class='form-group row'>";
			echo "	<label class='control-label col-md-2' for='$col'>$col</label>";
			echo "	<div class='col-md-10'><textarea name='$col' id='$col' rows=6 cols=40>{$property[$col]}</textarea></div>";
			echo "</div>";
		}

		if(!empty($propertyID)) echo "<input type='hidden' name='propertyID' value='$propertyID' />";
 
		?>
	</form>
</main>
<?php require_once "../footer.php"; ?>