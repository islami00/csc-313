<!DOCTYPE html>
<html lang="en">
<?php
require_once __DIR__ . "/../students/session_helper.php";
$user = maybe_redirect_admin();
$INDEX_CSS = get_path("/public/webdevelop.css");
?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo $INDEX_CSS ?>" />
  <title>Delete</title>
  <style>
    /* duplicate. todo: rwemove */
    .hidden {
      /* https://www.a11yproject.com/posts/how-to-hide-content/ */
      clip: rect(0 0 0 0);
      clip-path: inset(50%);
      height: 1px;
      overflow: hidden;
      position: absolute;
      white-space: nowrap;
      width: 1px;
    }
  </style>
</head>