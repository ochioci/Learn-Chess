<?php
$tag = $_GET['tag'];
$color = $_GET['color'];
include 'db_connection.php';
$conn = OpenCon();
$query = "SELECT * FROM Puzzle WHERE tags = '" . ( ($tag == 'none') ? "' OR '1'='1'" : $tag . "'") .  " AND toMove='" . ( ($color == 'either') ? "' OR '1'='1'" : $color . "' AND Solutions IS NOT NULL ORDER BY RAND() LIMIT 1"); 
if ($result = mysqli_query($conn, $query)) {
	while ($rowData = mysqli_fetch_array($result)) {
			echo $rowData["PuzzleID"].'<br>';
			echo $rowData["Position"].'<br>';
		   echo $rowData["Solutions"].'<br>';
		}
  }

CloseCon($conn);
?>
