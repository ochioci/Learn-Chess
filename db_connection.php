<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function OpenCon()
 {
 $dbhost = "66.175.213.70";
 $dbuser = "tgbUser";
 $dbpass = "1000onLich3ss!";
 $db = "tgbchess";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

 return $conn;
 }

function CloseCon($conn)
 {
 $conn -> close();
 }

?>
