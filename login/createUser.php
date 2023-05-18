<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include '../db_connection.php';
$conn = OpenCon();
$username = $_GET["user"];
$password = $_GET["pw"];
$username = preg_replace("/[^a-zA-Z0-9_]+/", "", $username);
$password = preg_replace("/[^a-zA-Z0-9!]+/", "", $password);
$ct = 1;
// echo $username . '<br>';
// echo $password . '<br>';
$query = "SELECT COUNT(*) as ct FROM User WHERE username = '" . $username . "'";
if ($result = mysqli_query($conn, $query)) {
	while ($rowData = mysqli_fetch_array($result)) {
			$ct = $rowData["ct"];
		}
  }
if (intval($ct) < 1) {
    $q = "INSERT INTO User (username, password) VALUES ('" . $username . "', '" . $password . "') ";
    
    if ($result = mysqli_query($conn, $q)) {
        echo "success";
    } else {
        echo "db_error";
    }

} else {
    echo "username_taken_error";
} 

?>