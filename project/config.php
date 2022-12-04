<?php

// Database parameters
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'project_test');


/**
 * The root to use in resolving paths.
 */
define('URLROOT', "/project");

/**
 * The root to use in resolving files
 */
define('APPROOT', __DIR__);

/**
 * Concats path with URLROOT
 */
function get_path(string $part = "")
{
  return URLROOT . $part;
}

function get_upload_path(string $part = "")
{
  return get_path("/uploads" . $part);
}
echo "<p> server 1 </p>";
echo URLROOT . "<br>";
echo APPROOT . "<br>";
