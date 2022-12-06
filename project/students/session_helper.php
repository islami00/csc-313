<?php
require_once '../config.php';
require_once 'Database.php';
session_start();

function isLoggedIn()
{
    // https: //www.cloudways.com/blog/php-session-security/
    if (!isset($_COOKIE['session'])) return false;
    $sessionId =  $_COOKIE['session'];
    return isset($_SESSION[$sessionId]);
}

function maybe_redirect()
{
    $REGISTER = get_path('/students/register.php');
    if (!isLoggedIn()) {
        header("location: ${REGISTER}");
    }
}
function profilePicture()
{
    if (isset($_SESSION['dp']) && !is_null($_SESSION['dp'])) {
        return $_SESSION['dp'];
    } else {
        if ($_SESSION['gender'] == 'M') {
            return get_upload_path("/avatar1.png");
        }

        if ($_SESSION['gender'] == 'F') {
            return get_upload_path("/avatar2.png");
        }
        return get_upload_path("/boxed-bg.jpg");
    }
}

function checkUsername(string $username)
{
    $db = new Database;
    $stmt = $db->prepare('SELECT * FROM users WHERE username=:username');
    if (!$stmt) return;
    $db->bind(':username', $username);
    $db->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // debug.
    var_dump($result);
    return !empty($result);
}

function guidv4()
{
    return random_bytes(16);
}
/**
 * @return User|false
 */
function get_current_appuser()
{
    if (!isLoggedIn()) throw new Error("Unauthorized", 401);
    $sessionId = $_COOKIE['session'];
    $userId =  $_SESSION[$sessionId];

    $db =  new Database;
    $sql_user =  "SELECT * FROM `users` where `user`.id = ':userId' LIMIT 1";
    $stmt_user = $db->prepare($sql_user);
    $db->bind(":userId", $userId);
    if (!$db->execute()) return false;
    $user = $stmt_user->fetch();
    return $user;
}

$MINUTE =  60;
$HOUR = 60 * $MINUTE;
$DAY = 24 * $HOUR;

$SESSION_KEY = 'session';

?>