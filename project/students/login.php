<!DOCTYPE html>
<html>

<?php
require __DIR__ . '/../students/session_helper.php';


$LOGIN_CSS = get_path("/public/style.css");

$STUDENT_INDEX = get_path('/students/index.php');
$REGISTER =  get_path("/students/register.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {


  //SOMETHING WAS POSTED
  $user = $_POST['user'];
  $Password = $_POST['Password'];

  if (!empty($user) && !empty($Password) && !is_numeric($user)) {


    // read from db



    $db = new Database;
    $stmt = $db->prepare($GET_ONE_STUDENT_QUERY_BY_USERNAME);
    echo $user;
    $db->bind(":username", $user);
    $result = $db->execute();
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $user_data) {
      // hash password.
      if (validate_password($Password, $user_data['password'])) {
        login($user_data['id']);
        header("Location: ${STUDENT_INDEX}");
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
  <title>User Login</title>
  <link rel="stylesheet" type="text/css" href="<?php echo $LOGIN_CSS ?>">
</head>

<body>
  <div class="user-login">
    <h1>User Login</h1>
    <form action="#" method="post">
      <p>User Name</p>
      <input type="text" name="user" placeholder="User Name">
      <p>Password</p>
      <input type="Password" name="Password" placeholder="Password">
      <button type="submit">Login</button>
      Don't have an account?<a href="<?php echo $REGISTER; ?>">Register</a>
    </form>
  </div>

</html>