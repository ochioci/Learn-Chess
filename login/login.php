<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include '../db_connection.php';
$conn = OpenCon();
$username = $_GET["user"];
$password = $_GET["pw"];
$username = preg_replace("/[^a-zA-Z0-9_]+/", "", $username);
$password = preg_replace("/[^a-zA-Z0-9!]+/", "", $password);
// echo $username . '<br>';
// echo $password . '<br>';
$query = "SELECT COUNT(*) as ct FROM User WHERE username = '" . $username . "' AND password = '" . $password . "'";
// echo $query . '<br>';
if ($result = mysqli_query($conn, $query)) {
	while ($rowData = mysqli_fetch_array($result)) {
			echo $rowData["ct"];
		}
  }
?>