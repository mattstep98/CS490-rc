<?php
include "db.php";

$questionDescription = $_POST["questionDescription"];
$questionTopic = $_POST["questionTopic"];
$questionLevel = $_POST["questionLevel"];
$testCasesInputs = $_POST["testCasesInputs"];
$testCasesOutputs = $_POST["testCasesOutputs"];




$format = substr($questionDescription,0,23);
$compareFormat = "Write a function named ";

if($format == $compareFormat)
{
  $result = mysqli_query($connection, "INSERT INTO `CS490_questions`(`description`, `topic`, `level`, `testCasesInputs`, `testCasesOutputs`) VALUES ('$questionDescription','$questionTopic','$questionLevel','$testCasesInputs','$testCasesOutputs')");
  
  // Pass back the string !!! if we failed to add a new question
  if ($result) 
  {
    $json = array("message_type" => "New question created successfully");
    echo json_encode($json);
  } 
  else 
  {
    $json = array("message_type" => "Failed to create new question");
    echo json_encode($json);
  }
  mysqli_close($conn);
}
else
{
  $json = array("message_type" => 'Please phrase questions in the form of Write a function named ');
  echo json_encode($json);
}
?>