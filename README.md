# SeaAuth
A Simple Protection Program intended to protect your pages.

Here I'm demonstrating the use of SeaAuth to protect the "sands" folder, 
meaning no php files in the Sands can be accessed without SeaAuth autorizing them

To use, you'll have to create a "mysql_login.php" inside the SeaAuth folder
then go ahead and add your information.. here is a example

------ *Inside 'mysql_login.php'* ------
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "seaauth"; //Name of your database
