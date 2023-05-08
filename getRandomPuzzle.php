<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
$tag = $_GET['tag'];
$color = $_GET['color'];
$tag = preg_replace("/[^a-z]+/", "", $tag);
$color = preg_replace("/[^a-z]+/", "", $color);
$maxSolutions = $_GET["maxSolutions"];
include 'db_connection.php';
$conn = OpenCon();
$query = "SELECT * FROM Puzzle WHERE (tags = '" . ( ($tag == 'none') ? "' OR '1'='1'" : $tag . "'") .  ") AND (toMove='" . ( ($color == 'either') ? "' OR '1'='1'" : $color . "'") . ") AND Solutions IS NOT NULL AND CHAR_LENGTH(Solutions) < " . strval((intval($maxSolutions) * 5) + 1) . " ORDER BY RAND() LIMIT 1;";
echo $query;
if ($result = mysqli_query($conn, $query)) {
	while ($rowData = mysqli_fetch_array($result)) {
			echo $rowData["PuzzleID"].'<br>';
			echo $rowData["Position"].'<br>';
		   echo $rowData["Solutions"].'<br>';
		}
  }

CloseCon($conn);
?>
