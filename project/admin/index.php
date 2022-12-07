<?php
require_once __DIR__ . "/admin-heading.php";
require_once __DIR__ . "/do-delete.php";
maybe_redirect_admin();

$INDEX_CSS = get_path("/public/webdevelop.css")

?>


<body>

  <svg width="0" height="0" class="hidden">
    <symbol xmlns="http://www.w3.org/2000/svg" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" id="download">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
      <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
      <polyline points="7 11 12 16 17 11"></polyline>
      <line x1="12" y1="4" x2="12" y2="16"></line>
    </symbol>
  </svg>

  <nav class="nav">
    <a href="<?php echo get_path("/logout.php"); ?>">Logout</a>
    <div class="user-info">
      <div>
        <img class="user-img" />
      </div>
      <div>
        <p><?php echo  $user->username ?></p>
        <p><?php echo $user->level ?></p>
      </div>
    </div>
  </nav>
  <?php if ($messages  !== null) : ?>
    <?php foreach ($messages as $message) {
      echo $message;
    }
    ?>
  <?php endif ?>

  <div class="title-list">
    <?php if (gettype($result) === "array") : ?>

      <?php foreach ($result as $result_item) : ?>
        <?php
        $name = $result_item->uploaded_file_name;
        $title = $result_item->title;
        $path =  get_path("/uploads/${name}");
        $key =  $result_item->id;
        ?>

        <div class="title-row">
          <p><?php echo $title ?></p>
          <a class="icon-small" href="<?php echo $path ?>" download>
            <svg class="icon">
              <use xlink:href="#download"></use>
            </svg>
          </a>
          <button type="button" class="delete-btn" data-modalid="<?php echo $key ?>">Delete</button>
        </div>
      <?php endforeach ?>
    <?php endif ?>
    <?php if (gettype($result) === "string") : ?>
      <p><?php echo $result ?></p>
    <?php endif ?>
  </div>
  <button id="upload-btn">Upload Course</button>
  <dialog id="modal">
    <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
      <input hidden type="number" name="id">
      <button type="submit" value="submit" name="submit">
        Accept
      </button>
      <button class="cancel-btn" type="button">Cancel</button>
    </form>
  </dialog>
  <?php require_once __DIR__ . '/upload.php' ?>
  <script>
    const buttons = document.querySelectorAll(".delete-btn");
    const uploadBtn = document.querySelector("#upload-btn");
    const cancelBtn = document.querySelector("#modal .cancel-btn");
    const submitBtn = document.querySelector('#modal button[type="submit"]');

    const modal = document.querySelector(`#modal`);
    const uploadModal = document.querySelector(`#upload-modal`);
    const idInput = document.querySelector('input[name="id"]');
    buttons.forEach((button) => {
      button.addEventListener("click", () => {
        const id = button.dataset.modalid;
        idInput.value = `${id}`;
        modal.showModal();
      });
    });
    uploadBtn.addEventListener("click", () => {
      uploadModal.showModal();
    })
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