<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBT Portal | Register</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <style>
    .content {
      margin-top: 50px;
    }

    #profileDisplay {
      display: block;
      height: 210px;
      width: 30%;
      margin: 0px auto;
      border-radius: 50%;
    }

    .img-placeholder {
      width: 30%;
      color: white;
      height: 100%;
      background: black;
      opacity: .7;
      height: 210px;
      border-radius: 50%;
      z-index: 2;
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      display: none;
    }

    .img-placeholder h4 {
      margin-top: 40%;
      color: white;
    }

    .img-div:hover .img-placeholder {
      display: block;
      cursor: pointer;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="offset-md-2"></div>
          <div class="col-sm-6">
            <h1>CBT Portal</h1>
            <?php if ($data['errorCode'] !== -1) : ?>

              <p class="text-danger"><?php echo $data['errorMsg'] ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="offset-md-2"></div>
          <div class="col-md-8">
            <!-- jquery validation -->
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Register</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label>Profile Picture</label>
                    <input type="file" name="profilePic" id="profileImage" class="form-control" value="">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">First name</label>
                    <input type="text" name="firstname" class="form-control" id="exampleInputEmail1" placeholder="Enter first name" required><span class="text-red">*<?php echo $data['firstNameError']; ?></span>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Last name</label>
                    <input type="text" name="lastname" class="form-control" id="exampleInputEmail1" placeholder="Enter last name" required><span class="text-red">*<?php echo $data['lastNameError']; ?></span>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" required><span class="text-red">*<?php echo $data['emailError']; ?></span>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Enter username" required><span class="text-red">*<?php echo $data['usernameError']; ?></span>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputEmail1" placeholder="Enter Password" required><span class="text-red">*<?php echo $data['passwordError']; ?></span>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" id="exampleInputEmail1" placeholder="Enter email" required><span class="text-red">*<?php echo $data['confirmPasswordError']; ?></span>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Phone Number</label>
                    <input type="tel" name="phone" class="form-control" id="exampleInputEmail1" placeholder="Enter phone number" required><span class="text-red"><?php echo $data['phoneError']; ?></span>
                  </div>
                  <div class="form-group">
                    <label>Gender</label>
                    <select class="custom-select" name="gender" required>
                      <option value="M">Male</option>
                      <option value="F">Female</option>
                      <option value="O">Other</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Level</label>
                    <select class="custom-select" name="level" required>
                      <option value="beginner">Beginner</option>
                      <option value="intermediate">Intermediate</option>
                      <option value="expert">Expert</option>
                    </select>
                    <?php echo $data['levelError']; ?></span>
                  </div>

                </div>

                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-dark" name="submit" value="submit">Register</button>
                  <span class="float-right">
                    Already have an account? <a href="login.php">Login</a>
                  </span>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section><br>
    <!-- /.content -->

    <!-- Main Footer -->
    <footer class="main-footer float-left">
      <!-- Default to the left -->
      <strong>Copyright &copy; 2021 <a href="<?php echo $STUDENTS ?>">CBT Portal</a>.</strong> All rights reserved.
    </footer>
  </div>
</body>

<script>
  // You're given form_data in format:
  /*
  dataFormat {
    email:                string;
    password:             string;
    confirmPassword:      string;
    firstName:            string;
    lastName:             string;
    phone:                string;
    gender:               string;
    level:                string;
    profilePic:           ProfilePic; // this is an object with same shape as ProfilePic,
    emailError:           string;
    passwordError:        string;
    confirmPasswordError: string;
    firstNameError:       string;
    lastNameError:        string;
    genderError:          string;
    profilePicError:      string;
    phoneError:           string;
    levelError:           string;
    errorCode:            number; // 0 =  "validation error, use respective  *Error fields to show an error", // 1 = "Registration error", we couldn't register the user on db. 2  = "Upload error" , the selected file couldn't be uploaded to the server.
}

  ProfilePic {
    name:      string;
    full_path: string;
    type:      string;
    tmp_name:  string;
    error:     number;
    size:      number;
}
    */
  const form_data = JSON.parse('<?php echo json_encode($data); ?>');
  console.log(form_data);
</script>

</html>