<?php

require './students/session_helper.php';
$sessionId = $_COOKIE[$SESSION_COOKIE_KEY];
unset($_SESSION[$sessionId]);
setcookie(
  $SESSION_COOKIE_KEY,
  '',
  time() - 7 * $DAY
);


header("location: ${get_path('/')}");
