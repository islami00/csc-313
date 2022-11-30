<?php
$message =  null;

if (isset($_POST['submit'])) {
  if (!empty($_FILES['upload']['name'])) {
    $file_name =  $_FILES["upload"]["name"];
    $file_size =  $_FILES["upload"]["size"];
    $file_tmp_name =  $_FILES["upload"]["tmp_name"];
    
  } else {
    $message =  "Please choose a file";
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload</title>
</head>

<body>
  <p hidden="<?php !$message ?>"><?php echo $message ?></p>
  <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <input maxlength="" type="file" name="upload" id="" required>
    <input type="submit" name="Submit" value="submit">
  </form>
</body>

</html>