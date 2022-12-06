<?php
$dbhost = DB_HOST;
$dbuser = DB_USER;
$dbpass = DB_PASS;
$dbname = DB_NAME;
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$con) {
  die("failed to connect");
}

 ?>