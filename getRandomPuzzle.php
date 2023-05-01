<?php
include 'db_connection.php';
$conn = OpenCon();
if ($result = mysqli_query($conn, "SELECT * FROM Puzzle ORDER BY RAND() LIMIT 1")) {
  while ($rowData = mysqli_fetch_array($result)) {
      echo $rowData["PuzzleID"].'<br>';
      echo $rowData["Position"].'<br>';
      echo $rowData["Solutions"].'<br>';
  }
}
CloseCon($conn);
?>
