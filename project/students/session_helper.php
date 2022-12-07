<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ .  '/Database.php';
session_start();

$MINUTE =  60;
$HOUR = 60 * $MINUTE;
$DAY = 24 * $HOUR;

$SESSION_COOKIE_KEY = 'session';
$GET_ONE_ADMIN_QUERY_BY_ID = "SELECT * FROM `users` where `users`.`id` = :userId AND `users`.`role` = 'admin' LIMIT 1";
$GET_ONE_ADMIN_QUERY_BY_USERNAME = "SELECT * FROM `users` where `users`.`username` = :username AND `users`.`role` = 'admin' LIMIT 1";
$GET_ONE_STUDENT_QUERY_BY_USERNAME = "SELECT * FROM `users` where `users`.`username` = :username AND `users`.`role` = 'normal'  LIMIT 1";
$GET_ONE_STUDENT_QUERY_BY_ID = "SELECT * FROM `users` where `users`.`id` = :userId AND `users`.`role` = 'normal'  LIMIT 1";

function isLoggedIn()
{
    // https: //www.cloudways.com/blog/php-session-security/
    if (!isset($_COOKIE['session'])) return false;
    $sessionId =  $_COOKIE['session'];
    return isset($_SESSION[$sessionId]);
}

function maybe_redirect()
{
    $LOGIN = get_path('/students/login.php');
    if (!isLoggedIn()) {
        header("location: ${LOGIN}");
    }
}

function maybe_pass(bool $cond, string $route)
{
    if ($cond) {
        header("location: ${route}");
    }
}
function maybe_pass_student()
{
    $STUDENT_INDEX = get_path('/students/index.php');
    maybe_pass(isLoggedIn(), $STUDENT_INDEX);
}
function maybe_pass_admin()
{
    $ADMIN_INDEX = get_path('/admin/index.php');
    $admin = get_current_admin();
    maybe_pass(!!$admin, $ADMIN_INDEX);
}
function maybe_redirect_admin()
{
    $LOGIN = get_path('/admin/login.php');
    $admin_user = get_current_admin();
    if (!$admin_user) {
        header("location: ${LOGIN}");
        die;
    }
    return $admin_user;
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
    $db->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // debug.
    if (!$result) return true;
    return !empty($result);
}

function guidv4()
{
    return random_bytes(16);
}
/**
 * @param string $sql_user -- SQL of form : 
 * ```SQL
 * SELECT * FROM `users` where `users`.`id` = :userId LIMIT 1;
 * ```
 * Tries to get The :userId param from session.
 * @return User|false
 */
function get_current_appuser(string $sql_user)
{
    global $SESSION_COOKIE_KEY;
    if (!isLoggedIn()) return false;
    $sessionId = $_COOKIE[$SESSION_COOKIE_KEY];
    $userId =  $_SESSION[$sessionId];
    $db =  new Database;
    
    $stmt_user = $db->prepare($sql_user);
    if (!$db->bind(":userId", +$userId)) {
        return false;
    }
    if (!$db->execute()) {
        return false;
    }
    $_user = $stmt_user->fetch();
    $user = new User($_user->id, $_user->firstname, $_user->username, $_user->password, $_user->lastname, $_user->role, $_user->level);
    return $user;
}
function get_current_student()
{
    global $GET_ONE_STUDENT_QUERY_BY_ID;
    return get_current_appuser($GET_ONE_STUDENT_QUERY_BY_ID);
}
function get_current_admin()
{
    global $GET_ONE_ADMIN_QUERY_BY_ID;
    return get_current_appuser($GET_ONE_ADMIN_QUERY_BY_ID);
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

?>