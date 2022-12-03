<?php

require "./db_conn.php";

require '../vendor/autoload.php';

use Rakit\Validation\Validator;
// https://github.com/rakit/validation
$validator = new Validator();
$rules = [
  'id' => ["required", "numeric", "min:1"],
  'submit' => 'required',
];

$validation = $validator->make($_POST + $_FILES, $rules);
/**
 * @param number $id
 */
function do_delete($id)
{
  global $connection;
  $sql = "DELETE FROM files WHERE `files`.`id` = :id";
  $stmt = $connection->prepare($sql);
  $result = false;
  if ($stmt) {
    $result = $stmt->execute([":id" => $id]);
  }
  return $result;
}

function do_validate()
{
  global $validation;
  if (empty($_POST['submit'])) {
    return null;
  }
  $validation->validate();
  if ($validation->fails()) {
    // var_dump($validation->errors()->get('upload'));
    return '<p>Error on file validation</p>';
  }

  $success = do_upload();
  if ($success) {
    return '<p>File uploaded successfully!</p>';
  } else {
    return '<p>Error on file upload</p>';
  }
}
$message = do_validate();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Show All</title>
</head>

<body>
  <?php if ($message !== null) : ?>
    <p><?php echo $message; ?></p>
  <?php endif ?>
  <?php foreach ($result as $key => $value) : ?>
    <?php
    $title =  $value->title;
    $path =  $value->path;
    $link =  "./admin/${path}";
    ?>
    <a download="<?php echo $title ?>" href="<?php echo $link ?>"><?php echo $title ?></a>
    <br>
  <?php endforeach ?>
</body>

</html>