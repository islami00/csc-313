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
    var_dump($validation->errors()->all());
    return '<p>Error on input validation</p>';
  }

  $success = do_upload();
  if ($success) {
    return '<p>File uploaded successfully!</p>';
  } else {
    return '<p>Error on file upload</p>';
  }
}
$message = do_validate();
$sql = 'SELECT * FROM `files`';
$stmt = $connection->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete</title>
</head>

<body>
  <?php if ($message !== null) : ?>
    <p><?php echo $message; ?></p>
  <?php endif ?>
  <ul>
    <?php foreach ($result as $key => $value) : ?>
      <li>
        <?php
        $title =  $value->title;
        $path =  $value->path;
        $link =  $path;
        ?>
        <a download="<?php echo $title ?>" href="<?php echo $link ?>"><?php echo $title ?></a>
        <button type="button" class="delete-btn" data-modalid="<?php echo $key ?>">Delete</button>

      </li>
    <?php endforeach ?>
    <dialog id="modal">
      <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
        <input hidden type="number" name="id">
        <button type="submit" value="submit" name="submit">
          Accept
        </button>
        <button class="cancel-btn" type="button">Cancel</button>
      </form>
    </dialog>
  </ul>
  <script>
    const buttons = document.querySelectorAll(".delete-btn");
    const cancelBtn = document.querySelector("#modal .cancel-btn");
    const submitBtn = document.querySelector('#modal button[type="submit"]');

    const modal = document.querySelector(`#modal`);
    const idInput = document.querySelector('input[name="id"]');
    buttons.forEach((button) => {
      button.addEventListener("click", () => {
        const id = button.dataset.modalid;
        idInput.value = `${id}`;
        modal.showModal();
      });
    });
    cancelBtn.addEventListener("click", doClose);
    submitBtn.addEventListener("click", closeModal)

    function doClose() {
      idInput.value = "";
      closeModal();
    }

    function closeModal() {
      modal.close();
    }
  </script>
</body>

</html>