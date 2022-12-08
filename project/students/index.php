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
  $db->execute();
  $result = $stmt->fetchAll();
  if (!$result) return "No topics available";
  return $result;
}
$result = [];
$message = null;
try {
  $result  = get_topics();
} catch (\Throwable $th) {
  $result  = "Error getting course content";
}
$INDEX_CSS = get_path("/public/webdevelop.css")

?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student view</title>
  <link rel="stylesheet" href="<?php echo $INDEX_CSS ?>" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

    * {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body>
  <svg width="0" height="0" class="hidden">
    <symbol xmlns="http://www.w3.org/2000/svg" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" id="download">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
      <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
      <polyline points="7 11 12 16 17 11"></polyline>
      <line x1="12" y1="4" x2="12" y2="16"></line>
    </symbol>
  </svg>

  <nav class="nav">
    <a href="<?php echo get_path("/logout.php"); ?>">Logout</a>
    <div class="user-info">
      <div>
        <img src="https://avatars.dicebear.com/api/initials/<?php echo $user->firstname . $user->lastname ?>.svg" class="user-img" />
      </div>
      <div>
        <p><?php echo  $user->username ?></p>
        <p><?php echo $user->level ?></p>
      </div>
    </div>
  </nav>
  <div class="title-list">
    <?php if (gettype($result) === "array") : ?>
      <?php foreach ($result as $result_item) : ?>
        <?php
        $name = $result_item->uploaded_file_name;
        $title = $result_item->title;
        $path =  get_path("/uploads/${name}");
        ?>

        <div class="title-row">
          <p><?php echo $title ?></p>
          <a class="icon-small" href="<?php echo $path ?>" download>
            <svg class="icon">
              <use xlink:href="#download"></use>
            </svg>
          </a>
        </div>
      <?php endforeach ?>
    <?php endif ?>
    <?php if (gettype($result) === "string") : ?>
      <p><?php echo $result ?></p>
    <?php endif ?>
  </div>
</body>


</html>