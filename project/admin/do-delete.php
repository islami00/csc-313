<!DOCTYPE html>
<html lang="en">
<?php

require_once __DIR__ . "/../students/session_helper.php";

require_once __DIR__ . '/../vendor/autoload.php';

use Rakit\Validation\Validator;

$user = maybe_redirect_admin();

// https://github.com/rakit/validation
$validator = new Validator();
$rules = [
  'id' => ["required", "numeric"],
  'submit' => 'required',
];

$validation = $validator->make($_POST + $_FILES, $rules);
/**
 * @param number $id
 * 
 * Choose not to delete it from uploads because we acn have rm '/' like that.
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
    var_dump($validation->errors()->all("<p>:message</p>"));
    return ['<p>Error on input validation</p>'];
  }
  $id =  $_POST['id'];
  if (!is_finite($id)) return ['<p>Error on file deletion, invalid file id</p>'];
  $success = do_delete($id);
  if ($success) {
    return ['<p>File deleted successfully!</p>'];
  } else {
    return ['<p>Error on file delete</p>'];
  }
}

$messages  = do_validate();
$sql = 'SELECT * FROM `files`';
$stmt = $connection->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
?>