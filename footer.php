<?php

//Check if connection is still active and kill it
$conn = $altConn = null;

//Stuff for footer
$textList = array(
	"If you want to logout, you can clear your ip in the edit panel and enter the code later.",
	"You can make a copy of a rental by changing/removing the 'index' value.",
	"SeaAuth determines a user by IP.",
	"A SeaCode cannot be used for multiple locations.",
	"Having problems gaining access? Try using a blank SeaCode or contact your Server Admin",
	"You need to create a blank SeaCode if you plan on making changes in a new location.",
	"If you're going to have a blank SeaCode, you should make it hard to guess",
	"Anyone with access can make changes to other users",
	"When making changes to a Rental, there is no time limit, take your time :)",
	"No location can ever have two SeaCodes"
	);
$randText = $textList[rand(0, count($textList) - 1)];

?>
<footer class="alert alert-success" style="margin-top: 8px;">
	<?php echo $randText ?>
	<br />
	SeaAuth - Copyright &copy; All rights reserved.
</footer>
</body>
</html>