<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ .  '/Database.php';
session_start();

$MINUTE =  60;
$HOUR = 60 * $MINUTE;
$DAY = 24 * $HOUR;

$SESSION_COOKIE_KEY = 'session';

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

function checkField(string $field, string $value)
{
    $db = new Database;
    $stmt = $db->prepare("SELECT * FROM users WHERE :fieldname=':fieldvalue' ");
    if (!$stmt) return;
    $db->bind(':fieldvalue', $value);
    $db->bind(':fieldname', $field);
    var_dump($stmt);
    $db->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // debug.
    var_dump($stmt->errorInfo());
    var_dump(!$result);
    if (!$result) return true;
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
    global $SESSION_COOKIE_KEY;
    if (!isLoggedIn()) throw new Error("Unauthorized", 401);
    $sessionId = $_COOKIE[$SESSION_COOKIE_KEY];
    $userId =  $_SESSION[$sessionId];
    echo $userId;
    $db =  new Database;
    $sql_user =  "SELECT * FROM `users` where `users`.`id` = :userId LIMIT 1";
    $stmt_user = $db->prepare($sql_user);
    if (!$db->bind(":userId", +$userId)) {
        return false;
    }
    if (!$db->execute()) {
        return false;
    }
    $user = $stmt_user->fetch();
    return $user;
}

/**
 * Log the user in by creating a session and setting a cookie.
 */
function login(string $userId)
{
    global $SESSION_COOKIE_KEY, $DAY;
    $sessionId =  guidv4();
    setcookie(
        $SESSION_COOKIE_KEY,
        $sessionId,
        time() + 1 * $DAY,
        '/'
    );
    $_SESSION[$sessionId] = $userId;
}
/**
 * Check if the password matches db.
 * 
 * @param string $psw -- Password as entered by user
 * @param string $dbpsw -- Password entry fetched from db.
 */
function validate_password(string $psw, string $dbpsw)
{
    $hashedInput = password_hash($psw, PASSWORD_DEFAULT);
    return $hashedInput === $dbpsw;
}
?>