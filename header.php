<!DOCTYPE html>
<html lang="en-ca">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php echo $pageTitle; ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!--
	<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.css" />
	-->
	<script src="/js/jQuery.js"></script>
	<!-- <script src="/bootstrap/js/bootstrap.min.js"></script> -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
	<?php if(isset($_SESSION['userID']) && dirname($_SERVER['REQUEST_URI']) == "/cauth") { ?>
	<header>
		<nav class="navbar navbar-default">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNav">
					<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
				</button>
				<a href="index.php" class="navbar-brand">SeaAuth - Server Protection</a>
			</div>

			<div class="collapse navbar-collapse" id="mainNav">
	    		<ul class="nav navbar-nav">
	    			<li><a href="index.php">Home</a></li>
	    			<li><a href="codelist.php">Codes</a></li>
	    			<li><a href="userlist.php">Users</a></li>
	    		</ul>
	    	</div>
		</nav>
	</header>
	<?php } ?>