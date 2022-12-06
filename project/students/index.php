<!DOCTYPE html>
<?php
require 'session_helper.php';


maybe_redirect();

// Get current user obj from session.

$user = get_current_appuser();
$sql = "SELECT * FROM `topics` where `topics`.`level` = ':level'";
$stmt = $db->prepare($sql);
$db->bind(":level", $user->level);

$result = $stmt->fetchAll();
?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student view</title>
</head>

<body>

</body>


</html>