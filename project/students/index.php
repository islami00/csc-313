<!DOCTYPE html>
<?php
require 'session_helper.php';


maybe_redirect();

// Get current user obj from session.

$user = get_current_student();
function get_topics()
{
  global $user;
  if (!$user) return "User does not exist";
  $db =  new Database;
  $sql = "SELECT * FROM `topics` where `topics`.`level` = :level";
  $stmt = $db->prepare($sql);
  if (!$stmt) return "Error fetching topics";

  $db->bind(":level", $user->level);

  $result = $stmt->fetchAll();
  if (!$result) return "No topics available";
  return $result;
}
$result = [];
$message = null;
try {
  $result  = get_topics();
  if (gettype($result) === "string") {
    $message =  $result;
  }
} catch (\Throwable $th) {
  echo "Error getting course content";
}

?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student view</title>
</head>

<body>
  <?php if (isset($message)) : ?>
    <p><?php echo $message ?></p>
  <?php endif ?>
  <a href="<?php echo get_path("/logout.php"); ?>">Logout</a>
</body>


</html>