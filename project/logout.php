<?php

require __DIR__ . '/students/session_helper.php';
$sessionId = $_COOKIE[$SESSION_COOKIE_KEY];
unset($_SESSION[$sessionId]);
setcookie(
  $SESSION_COOKIE_KEY,
  '',
  time() - 7 * $DAY
);
echo "Done";

var_dump($_SESSION);
// header("location: ${get_path('/')}");
