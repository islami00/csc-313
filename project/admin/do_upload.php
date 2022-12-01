<?php
require('../vendor/autoload.php');

use Rakit\Validation\Validator;
// https://github.com/rakit/validation
$validator = new Validator;

$rules = [
  'upload' => 'required|uploaded_file:1,500K,png,jpeg',
  "submit" => "required"
];
$validation = $validator->make($_POST + $_FILES, $rules);
$validation->validate();
$message = null;
var_dump($_FILES);
if (
  $validation->fails()
) {

  $message = "<p>Please choose a file</p>";
}
?>
<?php if ($message) :  ?>
  <p><?php echo $message ?></p>

  <?php header("Location: ./upload.php"); ?>
<?php endif  ?>