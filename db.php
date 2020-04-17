<?php
$connection = mysqli_connect('SERVER', 'USER', 'DATABASEPASSWORD', 'TABLE');

if (!$connection) 
{
  $json = array("output" => "Failed To Connect");
  echo json_encode($json);
  exit;
}
?>
