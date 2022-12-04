<?php require_once './require.php' ?>
<?php

// PATHS
$STUDENTS = get_path('/students/index.php');
$STUDENTS_REGISTER = get_path('/students/register.php');
$STUDENTS_FOLDER = get_path('/students');
?>
<?php if (!isLoggedIn()) : ?>

  <?php

  $data = [
    'email' => '',
    'password' => '',
    'confirmPassword' => '',
    'firstName' => '',
    'lastName' => '',
    'phone' => '',
    'gender' => '',
    'level' => '',
    'profilePic' => '',
    'emailError' => '',
    'passwordError' => '',
    'confirmPasswordError' => '',
    'firstNameError' => '',
    'lastNameError' => '',
    'genderError' => '',
    'profilePicError' => '',
    'phoneError' => '',
    'levelError' => '',
    'errorCode' => -1,
  ];
  function findStudentByEmail($email)
  {
    $db = new Database;
    // prepared statement
    $db->query('SELECT * FROM student WHERE email = :email');

    $db->bind(':email', $email);

    $result = $db->single();

    // check if email already exists
    return !!$result;
  }

  if (isset($_POST['submit'])) {
    $db = new Database;
    global $data;
    $data = [
      ...$data,     'email' => trim($_POST['email']),
      'password' => trim($_POST['password']),
      'confirmPassword' => trim($_POST['confirm_password']),
      'firstName' => trim($_POST['first_name']),
      'lastName' => trim($_POST['last_name']),
      'phone' => trim($_POST['phone']),
      'gender' => trim($_POST['gender']),
      'level' => trim($_POST['level']),
      'profilePic' => $_FILES['profilePic']
    ];
    // 1: Don't mutate globals. (unless it's fine.)
    // $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $error_match = "/Error/i";
    $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";
    $levels = ["beginner", "intermedaite", "advanced"];

    try {
      // validate username
      if (empty($data['email'])) {
        $data['emailError'] = 'Please enter an email address';
      } else {
        if (findStudentByEmail($data['email'])) {
          $data['emailError'] = 'An account with this email address already exists';
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
          $data['emailError'] = "Invalid email format";
        }
      }

      // validate password
      if (empty($data['password'])) {
        $data['passwordError'] = 'Please enter a password';
      } else {
        if ($data['password'] == $data['confirmPassword']) {
          $password = $data["password"];
          $cpassword = $data["confirmPassword"];
          if (
            strlen($password) <= '8'
          ) {
            $data['passwordError'] = "Your Password Must Contain At Least 8 Characters!";
          } elseif (preg_match($passwordValidation, $data['password'])) {
            $data['passwordError'] = 'Password must be have at least one numeric value.';
          }
        } else {
          $data['passwordError'] = "Passwords don't match";
          $data['confirmPasswordError'] = "Passwords don't match";
        }
      }

      if (empty($data['firstName'])) {
        $data['firstNameError'] = 'Please enter first name';
      } else {
        if (!preg_match("/^[a-zA-Z-' ]*$/", $data['firstName'])) {
          $data['firstNameError'] = "Only letters and white space allowed";
        }
      }

      if (empty($data['lastName'])) {
        $data['lastNameError'] = 'Please enter last name';
      } else {
        if (!preg_match("/^[a-zA-Z-' ]*$/", $data['lastName'])) {
          $data['lastNameError'] = "Only letters and white space allowed";
        }
      }

      if (empty($data['phone'])) {
        $data['phoneError'] = 'Please enter phone number';
      }

      if (empty($data['gender'])) {
        $data['genderError'] = 'Please enter gender';
      }
      // Photo must have a name
      if (empty($data['profilePic']['name'])) {
        $data['profilePicError'] = 'Please select profile picture';
      }
      if (empty($data['level'])) {
        $data['levelError'] = 'Please select a level';
      }
      // VALIDATION
      // validate image size. Size is calculated in Bytes
      if ($_FILES['profilePic']['size'] > 200000) {
        $data['profilePicError'] = "Image size should not be greated than 200Kb";
      }
      // 2: No need.  timestamp will make files unique. Plus, users shouldn't be limited by filename.
      // // check if file exists
      // if (file_exists($target_file)) {
      //   $data['profilePicError'] = "File already exists";
      // }
      $hasNonEmpty = false;
      foreach ($data as $key => $value) {
        if (!preg_match($error_match, $key) || $key === 'errorCode') continue;
        $hasNonEmpty =  !empty($value);
        if ($hasNonEmpty) throw new Error(); // already have an ans
      }
    } catch (\Throwable $th) {
      //validation error
      $data['errorCode'] = 0;
    }



    $profileImageName = time() . '-' . $_FILES["profilePic"]["name"];
    // For image upload
    $upload_dir = get_upload_path("/");
    if (!file_exists($upload_dir)) {
      mkdir($upload_dir);
    }
    $target_file = $upload_dir . basename($profileImageName);
    $moved = false;
    if ($data['errorCode'] !== 0) {
      $moved  = move_uploaded_file($_FILES['profilePic']['tmp_name'], $target_file);
    }
    if ($moved) {
      $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

      $db->query('INSERT INTO student (first_name, last_name, email, password, phone, gender, profile_pic, level) 
        VALUES (:first_name, :last_name, :email, :password, :phone, :gender, :profilePic, :level)');

      // bind value
      $db->bind(':first_name', $data['firstName']);
      $db->bind(':last_name', $data['lastName']);
      $db->bind(':email', $data['email']);
      $db->bind(':password', $data['password']);
      $db->bind(':phone', $data['phone']);
      $db->bind(':gender', $data['gender']);
      $db->bind(':profilePic', $target_file);
      $db->bind(':level', $data['level']);

      if ($db->execute()) {
        $_SESSION['user_id'] = $db->lastInsertId();
        $_SESSION['first_name'] = $data['firstName'];
        $_SESSION['last_name'] = $data['lastName'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['gender'] = $data['gender'];
        $_SESSION['phone'] = $data['phone'];
        $_SESSION['dp'] = $target_file;
        header("location: ${STUDENTS}");
      } else {
        $data['errorCode'] = 1; // execute error
      }
    } else if ($data['errorCode'] !== 0) {
      $data['errorCode'] = 2; // upload error
    }
  }

  ?>


<?php require 'signup-page.php' ?>
<?php else : ?>
  <?php header("location: ${STUDENTS}"); ?>
<?php endif; ?>