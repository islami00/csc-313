<?php
require_once '../config.php';
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

?>