<?php
$tag = $_GET['tag'];
include 'db_connection.php';
$conn = OpenCon();
if ($tag != 'none') {
	if ($result = mysqli_query($conn, "SELECT * FROM Puzzle WHERE tags = '" . $tag .  "' AND Solutions IS NOT NULL ORDER BY RAND() LIMIT 1")) {
  	while ($rowData = mysqli_fetch_array($result)) {
      		echo $rowData["PuzzleID"].'<br>';
      		echo $rowData["Position"].'<br>';
     		echo $rowData["Solutions"].'<br>';
  		}
	}
} else {
	if ($result = mysqli_query($conn, "SELECT * FROM Puzzle WHERE Solutions IS NOT NULL ORDER BY RAND() LIMIT 1")) {
		while ($rowData = mysqli_fetch_array($result)) {
			echo $rowData["PuzzleID"].'<br>';
			echo $rowData["Position"].'<br>';
			echo $rowData["Solutions"].'<br>';
		}
	}
}
CloseCon($conn);
?>
