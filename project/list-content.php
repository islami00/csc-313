<?php

require "./admin/db_conn.php";

$sql = 'SELECT * FROM `files`';
$stmt = $connection->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
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