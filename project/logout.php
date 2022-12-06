<?php

require __DIR__ . '/students/session_helper.php';
$sessionId = $_COOKIE[$SESSION_COOKIE_KEY];

if (!isset($_COOKIE[$SESSION_COOKIE_KEY])) {
  header("location: ${get_path('/')}");
}
unset($_SESSION[$sessionId]);
setcookie(
  $SESSION_COOKIE_KEY,
  '',
  time() - 7 * $DAY
);
echo "Redirecting to home page...";

header("location: .");
