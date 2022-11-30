<?php

$now =  time();
$name= "Hello";
$file =  "uploads/${name}-${now}";

if(file_exists($file)){
  $handle =  fopen($file,"r");
  $contents =  fread($handle,filesize($file));
  
}
?>