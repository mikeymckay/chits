<?php
// Rename this file to _dbselect.php and update the values below to match your own database username/password
session_start();
$_SESSION["dbname"] = "example_database"; // Name of the database (probably chits)
$_SESSION["dbuser"] = "example_user"; // mysql username that you are using to connect to the database
$_SESSION["dbpass"] = "example_password"; // mysql password that you are using to connect to the database
$conn = mysql_connect("localhost", $_SESSION["dbuser"], $_SESSION["dbpass"]);
$db->connectdb($_SESSION["dbname"]);
?>
