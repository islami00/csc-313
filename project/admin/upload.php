<?php
require_once __DIR__ . '/admin-heading.php';

require_once __DIR__ .  '/../students/session_helper.php';

require_once __DIR__ . '/../vendor/autoload.php';

if (!isset($result)) {
  $ADMIN_UPLOAD = get_path("/admin/index.php");
  header("Location:  ${ADMIN_UPLOAD}");
}

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
function do_validate_upload(User $admin_user)
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
$BYTE = 8;
$KB =  1024 * $BYTE;
$MB =  1024 * $KB;
do_validate_upload($user);
?>
<?php if ($message !== null) : ?>
  <!-- modal? -->
  <p><?php echo $message; ?></p>
<?php endif ?>

<style>
  form {
    color: rgb(4, 5, 65);
  }

  h1 {
    color: #09243b;
  }

  .upload-form {
    display: flex;
    flex-direction: column;
    row-gap: 10px;
  }

  /* added,. */

  .upload-form>div {
    display: flex;
    column-gap: 10px;
    align-items: center;
  }

  #rcorners1 {
    background: lavender;
    border-style: groove;
    margin: 0px auto;
    height: auto;
    padding: 60px;
    border: 2px solid #09243b;
    /* added,. */
  }

  #rcorners1>h1 {
    /* added,. */
    margin-bottom: 10px;
  }
</style>
<dialog id="upload-modal">
  <div class="upload_overlay">
    <div id="rcorners1" class="asiya">
      <h1> Upload topic</h1>
      <form enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="upload-form">
        <div>
          <label for="title">Name of topic</label>
          <input type="text" name="title">
        </div>
        <div>
          <label for="level">Target level</label>
          <select name="level" required>
            <option value="beginner">Beginner</option>
            <option value="intermediate">Intermediate</option>
            <option value="expert">Expert</option>
          </select>
        </div>
        <div>
          <label for="title">Topic file</label><br>
          <input maxlength="<?php echo 2 * $MB ?>" type="file" name="upload" required>
        </div>
        <button type="submit" name="submit-upload" value="submit-upload">Submit</button>
      </form>
    </div>
  </div>
</dialog>