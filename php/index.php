<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<?php
  $A  =  1;
  echo $A;

  // Arrays
  $posts  = ["Hi","Joe",1];
  /* Associative arrays */
  $posts  = [
    
    "first"=> "Hi" ,
    "second" => "Joe",
    "third"=>1,
  ];

  foreach ($posts as $key => $value) {
    echo $value;
  }
  // array_reverse
?>
</body>
</html>