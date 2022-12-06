<?php
require __DIR__ . '/../config.php';
$host = 'localhost';
$user = 'root';
$dbname = 'project_test';
// Set DSN
$dsn = "mysql:host=${host};dbname=${dbname}";

// Create a PDO instance
$connection = new PDO($dsn, $user);
$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
