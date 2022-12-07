<!DOCTYPE html>
<html lang="en">

<?php
require './config.php';
$ADMIN_LOGIN = get_path("/admin/login.php");
$STUDENT_LOGIN = get_path("/students/login.php");
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            /* Remove margin on body so container does not cause scrolling */
            margin: 0;
            /* Background of body */
            background-color: aliceblue;
        }

        .link_box {
            /* allow padding to work well */
            display: block;
            /* make box bigger */
            padding: 50px;
            /* Make width same as text without padding */
            width: fit-content;
            /* box background. */
            background-color: white;
            /* Link shadow */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);

            /* Make link prettier */
            /* 1. Remove underline */
            text-decoration: none;
            /* 2. Prettier font family */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* 3. Better text color */
            color: darkblue;
            /* 4. Making it bold */
            font-weight: bold;
            /* 5. Capital text*/
            text-transform: capitalize;
        }

        .link_box:hover {
            outline: 2px solid rgb(115, 183, 242);
        }

        .link_container {
            /* Enabling flexbox. */
            display: flex;
            /* Add space between links (which are now flex columns)*/
            column-gap: 50px;
            /* Make the container of the links as large as the body */
            height: 100vh;
            /* CEnter the links horizontally and vertically. */
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>

    <main class="link_container">
        <a href="<?php echo $STUDENT_LOGIN ?>" class="link_box">Student Signup / login </a>
        <a href="<?php echo $ADMIN_LOGIN ?>" class="link_box">Admin login </a>
    </main>

</body>

</html>