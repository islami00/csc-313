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
/**
 * Gets FS path to uploaded file for moving. NB: Uploads should be saved by name for easy reference.
 */

function get_upload_path(string $part = "")
{
  return APPROOT . "/uploads" . $part;
}
