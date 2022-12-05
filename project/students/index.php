<!DOCTYPE html>
<?php
require 'session_helper.php';
require 'Database.php';

maybe_redirect();
// Get current user obj from session.

// userid is not in session if not logged in.
$userId =  $_SESSION[$sessionId];

$db =  new Database;
$sql_user =  "SELECT * FROM `users` where `user`.id = ':userId' LIMIT 1";
$db->prepare($sql_user);
$db->bind(":userId", $userId);
$db->execute();
$user = $stmt_user->fetch();

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