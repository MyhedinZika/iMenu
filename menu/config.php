<?php
$host = "localhost";
$user = "root";
$pwd = "";
$dbname = "imenu";

$link = mysql_connect($host, $user, $pwd);
$db = mysql_select_db($dbname, $link);
if (!$db) die("failed to connect to database.......");

?>