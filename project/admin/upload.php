<?php

include './db_conn.php';

require '../vendor/autoload.php';
use Rakit\Validation\Validator;
// https://github.com/rakit/validation
$validator = new Validator();
$rules = [
  'upload' => ['required', 'mimes:png,jpeg,pdf', "max:2M"],
  'submit' => 'required',
];
$validation = $validator->make($_POST + $_FILES, $rules);

function add_to_db($file_name, $target_path, $level)
{
  global $connection;
  // PRDO QUERY
  $sql = 'INSERT INTO files VALUES (DEFAULT, :title, :path, :level);';
  $stmt = $connection->prepare($sql);
  $result = false;
  if ($stmt) {
    $result = $stmt->execute([':title' => $file_name, ':path' => $target_path, ':level' => $level]);
  }
  return $result;
}

function do_upload()
{
  $file_name = $_FILES['upload']['name'];
  $file_tmp = $_FILES['upload']['tmp_name'];
  $upload_dir = 'uploads';
  $target_path = "${upload_dir}/${file_name}";
  echo $target_path;
  if (!file_exists($upload_dir)) {
    mkdir($upload_dir);
  }
  move_uploaded_file($file_tmp, $target_path);
  return add_to_db($file_name, $target_path, 'beginner');
}

$message = null;
function do_validate()
{

  global $validation, $message;
  if (empty($_POST['submit'])) {
    return null;
  }
  $validation->validate();
  if ($validation->fails()) {
    // var_dump($validation->errors()->get('upload'));
    $message = '<p>Error on file validation</p>';
    return;
  }

  $success = do_upload();
  if ($success) {
    $message = '<p>File uploaded successfully!</p>';
  } else {
    $message = '<p>Error on file upload</p>';
  }
}
do_validate();
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
  <?php if ($message !== null) : ?>
    <p><?php echo $message; ?></p>
  <?php endif ?>
  <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input maxlength="" type="file" name="upload" id="">
    <input type="submit" name="submit" value="submit">
  </form>
</body>

</html>