<?php
include "db.php";
$username = $_POST['username'];
$examID = $_POST['examID'];

//$result = mysqli_query($connection, "SELECT questionID, grade, comments FROM CS490_studentGrading WHERE examID = '$examID' and username = '$username'");
$result = mysqli_query($connection, "SELECT CS490_questions.description, CS490_studentGrading.grade, CS490_studentGrading.comments FROM CS490_studentGrading INNER JOIN CS490_questions ON CS490_studentGrading.questionID=CS490_questions.questionID WHERE username = '$username' and examID = '$examID'");
if (mysqli_num_rows($result) > 0) 
{
  $json = array();
  while($row = mysqli_fetch_assoc($result))
  {
    $json[] = $row;
  }
}
else 
{
 // No result, then we return the -1.
 $json = array("examID or username" => "-1");
}
echo json_encode($json);

mysqli_close($connection);

?>