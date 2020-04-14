<?php
include "db.php";
$examID = $_POST['examID'];
$questionID = $_POST['questionID'];
$username = $_POST['username'];
$studentAnswer = $_POST['studentAnswer'];


$result = mysqli_query($connection, "INSERT INTO CS490_studentGrading(examID, questionID, username, studentAnswer) VALUES ('$examID','$questionID','$username','$studentAnswer')");

// Pass back the string !!! if we failed to add a new question
if ($result) {
echo "New answer Added!";
} else {
echo "Error: " . $result . "<br>" . mysqli_error($connection);
}


$testCases = mysqli_query($connection, "SELECT testCases FROM CS490_questions WHERE questionID = '$questionID'");
$questionDescription = mysqli_query($connection, "SELECT description FROM CS490_questions WHERE questionID = '$questionID'");



//trigger the autograding
function triggerAutograde($examID, $questionID,$questionDescription, $username, $studentAnswer, $testCases){
  $data = array('message_type' => "auto_grade", 'examID' => $examID, '$questionID' => $questionID,'$questionDescription' => $questionDescription,'username' => $username, 'studentAnswer' => $studentAnswer, 'testCases' => $testCases);
 	$url = "https://web.njit.edu/~mjs239/CS490/rc/newMiddle.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}

$result = triggerAutograde($examID, $questionID, $userName, $studentAnswer, $testCases)


//TODO: PUT $result in the database



mysqli_close($conn);
?>