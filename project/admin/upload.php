<?php

require_once __DIR__ .  '/db_conn.php';
require_once __DIR__ .  '/../students/session_helper.php';

require_once __DIR__ . '/../vendor/autoload.php';

use Rakit\Validation\Validator;
// https://github.com/rakit/validation
$validator = new Validator();
$rules = [
  'upload' => ['required', 'mimes:png,jpeg,pdf', "max:2M"],
  "level" => ['required'],
  'submit-upload' => 'required',
];
$validation = $validator->make($_POST + $_FILES, $rules);

function add_to_db($title, $file_name, $level, $admin_id)
{
  // PRDO QUERY
  $connection =  new Database;
  $sql = 'INSERT INTO topics (`title`,`uploaded_file_name`,`level`,`admin_id`) VALUES (:title, :file_name, :level,:admin_id);';
  $stmt = $connection->prepare($sql);
  $result = false;
  if ($stmt) {
    $result = $stmt->execute(
      [
        ':title' => $title,
        ':file_name' => $file_name,
        ':level' => $level,
        ':admin_id' => $admin_id,
      ]
    );
  }
  return $result;
}

function do_upload(User $admin)
{
  $file_name = $_FILES['upload']['name'];
  $file_tmp = $_FILES['upload']['tmp_name'];
  $title = $_POST['title'];
  $level = $_POST['level'];
  $upload_dir = get_upload_path("/");
  $target_path = get_upload_path("/${file_name}");
  // get user.
  if (!file_exists($upload_dir)) {
    mkdir($upload_dir);
  }
  move_uploaded_file($file_tmp, $target_path);
  return add_to_db($title, $file_name, $level, $admin->id);
}

$message = null;
function do_validate(User $admin_user)
{

  global $validation, $message;
  if (empty($_POST['submit-upload'])) {
    return null;
  }
  $validation->validate();
  if ($validation->fails()) {
    // var_dump($validation->errors()->get('upload'));
    $message = '<p>Error on file validation</p>';
    return;
  }
  if (!$admin_user) {
    $message = '<p>You are either not logged in or unauthorized</p>';
    return;
  }
  $success = do_upload($admin_user);
  if ($success) {
    $message = '<p>File uploaded successfully!</p>';
  } else {
    $message = '<p>Error on file upload</p>';
  }
}
$user = maybe_redirect_admin();
do_validate($user);
?>
<?php if ($message !== null) : ?>
  <p><?php echo $message; ?></p>
<?php endif ?>

<style>
  @import "https://unpkg.com/open-props";
  @import "https://unpkg.com/open-props/normalize.min.css";
  @import "https://unpkg.com/open-props/buttons.min.css";

  form {
    color: rgb(4, 5, 65);
  }

  h1 {
    color: #09243b;
  }

  body {
    background-color: lightslategrey;
  }


  #rcorners1 {


    background: lavender;
    border-style: groove;
    width: 180px;
    margin: 0px auto;
    height: auto;
    padding: 60px;
    border: 2px solid #09243b;
  }
</style>
<dialog id="upload-modal">
  <div id="rcorners1" class="asiya">
    <h1> Upload topic</h1>
    <form enctype="multipart/form-data" action="#" method="post">
      <div>
        <label for="title">Name of topic</label><br>
        <input type="text" name="title"><br><br>
      </div>
      <div class="form-group">
        <label for="level">Target level</label>
        <select class="form-control" name="level" required>
          <option value="beginner">Beginner</option>
          <option value="intermediate">Intermediate</option>
          <option value="expert">Expert</option>
        </select>
      </div>
      <div>
        <label for="title">Topic file</label><br>
        <input maxlength="2000" type="file" name="upload" required>
      </div>
      <button type="submit" name="submit-upload" value="submit-upload">Submit</button>
    </form>
  </div>
</dialog>