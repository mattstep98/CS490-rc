<?php
$connection = mysqli_connect('sql1.njit.edu', 'mjs239', 'd98qcADz', 'mjs239');

if (!$connection) 
{
  $json = array("output" => "Failed To Connect");
  echo json_encode($json);
  exit;
}
?>