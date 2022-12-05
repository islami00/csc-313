<?php
require_once '../config.php';
require_once 'Database.php';
session_start();

function isLoggedIn()
{
    // https: //www.cloudways.com/blog/php-session-security/
    $sessionId =  $_COOKIE['session'];
    return !empty($_SESSION[$sessionId]);
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

function isRegistered(int $studentId)
{
    $db = new Database;
    $db->prepare('SELECT * FROM student WHERE id=:id');

    $db->bind(':id', $studentId);
    $db->execute();
    $result = $db->single();

    if ($result) {
        return true;
    } else {
        return false;
    }
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


?>