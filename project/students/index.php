<!DOCTYPE html>
<?php require 'session_helper.php'; ?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

</body>
<script>
  const session = '<?php echo json_encode($_SESSION); ?>';
  const session_obj = JSON.parse(session); // use session
</script>

</html>