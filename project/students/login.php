<!DOCTYPE html>
<html>
<?php require '../config.php' ?>
<?php $LOGIN_CSS =  get_path("/public/admin-login.css") ?>

<head>
  <title>Student Login</title>
  <link rel="stylesheet" type="text/css" href="<?php echo $LOGIN_CSS ?>">
</head>

<body>
  <div class="user-login">
    <h1>User Logi n</h1>
    <form action="#" method="post">
      <p>User Name</p>
      <input type="text" name="user" placeholder="User Name">
      <p>Password</p>
      <input type="Password" name="Password" placeholder="Password">
      <button type="submit">Login</button>
      <a href="#">Forgot your password</a><br>
      <a href="#">Don't have an account?</a>
    </form>
  </div>

</html>