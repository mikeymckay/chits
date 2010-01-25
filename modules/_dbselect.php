<?php
// 
// *** DO NOT use the chits_development database for real world deployments. Use chits_live with a secure password.
//
session_start();

$_SESSION["dbname"] = "chits_development"; // Name of the mysql database (try "SHOW DATABASES;" on the mysql console
$_SESSION["dbuser"] = "chits_developer"; // mysql username that you are using to connect to the database
$_SESSION["dbpass"] = "password"; // mysql password that you are using to connect to the database

$conn = mysql_connect("localhost", $_SESSION["dbuser"], $_SESSION["dbpass"]);
$db->connectdb($_SESSION["dbname"]);
?>
