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
 * Choose not to delete it from uploads because we can have rm '/' like that.
 */
function do_delete($id)
{
  $db  = new Database;
  $sql = "DELETE FROM `topics` WHERE `topics`.`id` = :id";
  $stmt = $db->prepare($sql);
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
    // var_dump($validation->errors()->all("<p>:message</p>"));
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
function get_topics()
{
  global $user;
  if (!$user) return "User does not exist";
  $db =  new Database;
  $sql = "SELECT * FROM `topics`";
  $stmt = $db->prepare($sql);
  if (!$stmt) return "Error fetching topics";
  $db->execute();
  $result = $stmt->fetchAll();
  if (!$result) return "No topics available";
  return $result;
}

$result = get_topics();
?>