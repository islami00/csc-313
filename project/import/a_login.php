<?php 

session_start();

include("connection.php");
/**
 * Actionable:
 * 1. Use username column, and admin role.
 * Improvements:
 * 1. Use db.
 */

$ADMIN_INDEX = get_path('/admin/index.php');
  if($_SERVER['REQUEST_METHOD'] == "POST"){


    //SOMETHING WAS POSTED 
    $user= $_POST['user'];
    $Password=$_POST['Password'];

  if (!empty($user) && !empty($Password)) {


    // read from db


    // need to set user.
    $query = "select * from users where username = :user limit 1";
      $result = mysqli_query($con,$query);

      if($result){
      if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);

        // hash password.
        if (validate_password($Password, $user_data['Password'])) {
          login($user_data['id']);
          header("Location: ${ADMIN_INDEX}");
          die;
        }
      }
      }
      echo "incorrect username or password";

      

    }else{
      echo "Please enter valid information.";
    }
  }




 ?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" type="text/css" href="astyle.css">
</head>
<body>
<div class= "admin-login">
<h1>Admin Login</h1>
<form action="#" method="post">
<p>User Name</p>
<input type="text" name="user" placeholder="User Name">
<p>Password</p>
<input type="Password" name="Password" placeholder="Password">
<button type="submit">Login</button>
<a href="#">Forgot your password</a><br>
</form>
</div>
</body>
