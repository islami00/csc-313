<?php

$host =  'localhost';
$user = 'root';
// $password = '123456';
$dbname = 'project_test';
// Set DSN
$dsn = "mysql:host=${host};dbname=${dbname}";
// Create a PDO instance
$pdo = new PDO($dsn, $user);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
# PRDO QUERY
// INSERT INSERT INTO files VALUES (DEFAULT,'?name','?path','?level'); 
$stmt = $pdo->query('SELECT * FROM files');
while ($row = $stmt->fetch()) {
  echo $row->title . $row->path . $row->level .  $row->id . '<br>';
  var_dump($row);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload</title>
</head>

<body>
  <form enctype="multipart/form-data" action="./do_upload.php" method="post">
    <input maxlength="" type="file" name="upload" id="">
    <input type="submit" name="Submit" value="submit">
  </form>
</body>

</html>