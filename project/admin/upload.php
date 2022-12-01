<?php
require('../vendor/autoload.php');

$message = null;

use Rakit\Validation\Validator;
// https://github.com/rakit/validation
$validator = new Validator;

$rules = [
  'upload' => 'required|uploaded_file:1,500K,png,jpeg,pdf',
  "submit" => "required"
];
$validation = $validator->make($_POST + $_FILES, $rules);
$host =  'localhost';
$user = 'root';
// $password = '123456';
$dbname = 'project_test';
// Set DSN
$dsn = "mysql:host=${host};dbname=${dbname}";
// Create a PDO instance
$pdo = new PDO($dsn, $user);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
# PRDO QUERY
// INSERT INSERT INTO files VALUES (DEFAULT,'?name','?path','?level'); 
$stmt = $pdo->query('SELECT * FROM files');
// while ($row = $stmt->fetch()) {
//   echo $row->title . $row->path . $row->level .  $row->id . '<br>';
//   var_dump($row);
// }

function do_upload()
{
  $file_name = $_FILES['upload']['name'];
  $file_size = $_FILES['upload']['size'];
  $file_tmp = $_FILES['upload']['tmp_name'];
  $upload_dir = "uploads";
  $target_dir = "${upload_dir}/${file_name}";
  echo $target_dir;

  if (!file_exists($upload_dir)) mkdir($upload_dir);
  move_uploaded_file($file_tmp, $target_dir);
  
}
function do_validate()
{
  if (empty($_POST['submit'])) return;
  global $validation, $message;
  $validation->validate();

  if (
    $validation->fails()
  ) {
    var_dump($validation->errors()->get("upload"));
  } else {

    do_upload();
    $message = "<p>File uploaded successfully!</p>";
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
  <p><?php echo $message ?></p>
  <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <input maxlength="" type="file" name="upload" id="">
    <input type="submit" name="submit" value="submit">
  </form>
</body>

</html>