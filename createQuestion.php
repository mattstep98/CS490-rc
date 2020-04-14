<?php
include "db.php";

$questionDescription = $_POST["questionDescription"];
$questionTopic = $_POST["questionTopic"];
$questionLevel = $_POST["questionLevel"];
$testCases = $_POST["testCases"];

$format = substr($questionDescription,0,23);
$compareFormat = "Write a function named ";

if($format == $compareFormat)
{
  $result = mysqli_query($connection, "INSERT INTO `CS490_questions`(`description`, `topic`, `level`, `testCases`) VALUES ('$questionDescription','$questionTopic','$questionLevel','$testCases')");
  
  // Pass back the string !!! if we failed to add a new question
  if ($result) 
  {
    $json = array("message" => "New question created successfully");
    echo json_encode($json);
  } 
  else 
  {
    echo "Error: " . $result . "<br>" . mysqli_error($connection);
  }
  mysqli_close($conn);
}
else
{
  $json = array("message" => 'Please phrase questions in the form of Write a function named ');
  echo json_encode($json);
}
?>