<?php
$host = 'localhost';
$user = 'root';
$dbname = 'project_test';
// Set DSN
$dsn = "mysql:host=${host};dbname=${dbname}";

// Create a PDO instance
$connection = new PDO($dsn, $user);
$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

// PDO QUERY
// :x means named parameters
// $sql = 'INSERT INTO files VALUES (DEFAULT, :title, :path, :level);';
// $stmt = $connection->prepare($sql);
// $result = false;
// if ($stmt) {
// You define the parameters here in an associative array
//   $result = $stmt->execute([':title' => $file_name, ':path' => $target_path, ':level' => $level]);
// }
// $result is true if it succeeds, react as needed
// if ($result) {
//   echo "Success";
// } else {
//   echo "Failure";
// }