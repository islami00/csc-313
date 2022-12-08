<!DOCTYPE html>
<html>

<?php

require __DIR__ . '/../students/session_helper.php';
maybe_pass_admin();
$LOGIN_CSS = get_path("/public/style.css");
/**
 * Actionable:
 * 1. Use username column, and admin role.
 * Improvements:
 * 1. Use db.
 */

$ADMIN_INDEX = get_path('/admin/index.php');
if ($_SERVER['REQUEST_METHOD'] == "POST") {


  //SOMETHING WAS POSTED 
  $user = $_POST['user'];
  $Password = $_POST['Password'];

  if (!empty($user) && !empty($Password)) {


    // read from db


    // need to set user.
    $db = new Database;
    $stmt = $db->prepare($GET_ONE_ADMIN_QUERY_BY_USERNAME);
    $db->bind(":username", $user);
    $result = $db->execute();
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && $user_data) {
      // hash password.
      if (password_verify($Password, $user_data['password'])) {
        login($user_data['id']);
        header("Location: ${ADMIN_INDEX}");
        die;
      }
    } else if ($stmt->rowCount() === 0) {
      echo "User does not exist";
    } else {
      echo "incorrect username or password";
    }
  } else {
    echo "Please enter valid information.";
  }
}




?>

<head>
  <title>Admin Login</title>
  <style>
    :root {
      --background-img: url(<?php echo get_path("/public/IN.jpeg") ?>);
    }
  </style>
  <link rel="stylesheet" type="text/css" href="<?php echo $LOGIN_CSS; ?>">
</head>

<body>
  <div class="user-login">
    <h1>Admin Login</h1>
    <form action="#" method="post">
      <p>User Name</p>
      <input type="text" name="user" placeholder="User Name">
      <p>Password</p>
      <input type="Password" name="Password" placeholder="Password">
      <button type="submit">Login</button>
    </form>
  </div>
</body>

</html>