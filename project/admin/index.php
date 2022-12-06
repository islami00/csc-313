<?php require_once __DIR__ . "/do-delete.php"; ?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete</title>
</head>

<body>
  <?php if ($messages  !== null) : ?>
    <?php foreach ($messages as $message) {
      echo $message;
    }
    ?>
  <?php endif ?>
  <ul>
    <?php foreach ($result as  $value) : ?>
      <li>
        <?php
        $title =  $value->title;
        $path =  $value->path;
        $link =  $path;
        $key =  $value->id;
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