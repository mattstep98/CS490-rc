<?php
include "db.php";
$examID = $_POST['examID'];
$questionID = $_POST['questionID'];
$username = $_POST['username'];
$studentAnswer = $_POST['studentAnswer'];
$json = array();
$gradeArr = array(); 
$commentArr = array();


$examID = 1;
$questionID = 1;
$username = "test";
$studentAnswer = "def doubleIt(int1):\n\treturn int1*2;";




//$result = mysqli_query($connection, "INSERT INTO CS490_studentGrading(examID, questionID, username, studentAnswer) VALUES ('$examID','$questionID','$username','$studentAnswer')");
//
//// Pass back the string !!! if we failed to add a new question
//if ($result) {
//echo "New answer Added!";
//} else {
//echo "Error: " . $result . "<br>" . mysqli_error($connection);
//}


$testCasesInputs = mysqli_query($connection, "SELECT testCasesInputs FROM CS490_questions WHERE questionID = '$questionID'");
$testCasesInputs = mysqli_fetch_assoc($testCasesInputs);
$testCasesInputs=$testCasesInputs["testCasesInputs"];


$testCasesOutputs = mysqli_query($connection, "SELECT testCasesOutputs FROM CS490_questions WHERE questionID = '$questionID'");
$testCasesOutputs = mysqli_fetch_assoc($testCasesOutputs);
$testCasesOutputs=$testCasesOutputs["testCasesOutputs"];

$questionDescription = mysqli_query($connection, "SELECT description FROM CS490_questions WHERE questionID = '$questionID'");
$questionDescription = mysqli_fetch_assoc($questionDescription);
$questionDescription=$questionDescription["description"];

$points = mysqli_query($connection, "SELECT points FROM CS490_exams WHERE examID='$examID' AND questionID = '$questionID'");
$points = mysqli_fetch_assoc($points);
$points=$points["points"];

//trigger the autograding
function triggerAutograde($examID, $questionID,$questionDescription, $username, $studentAnswer, $testCasesInputs, $testCasesOutputs, $points){
  $data = array('message_type' => 'auto_grade', 'examID' => $examID, 'questionID' => $questionID,'questionDescription' => $questionDescription,'username' => $username, 'studentAnswer' => $studentAnswer, 'testCasesInputs' => $testCasesInputs, 'testCasesOutputs' => $testCasesOutputs, 'points' => $points);
 	
  $url = "https://web.njit.edu/~mjs239/CS490/rc/newMiddle.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}

$result = triggerAutograde($examID, $questionID,$questionDescription, $username, $studentAnswer, $testCasesInputs, $testCasesOutputs, $points);

//NEED TO FIND HOW TO ACCESS GRADES IN THE RETURNED JSON, NOTHING IS WORKING THEN INSERT THEM INTO THE DATABASE







//$result = mysqli_query($connection, "INSERT INTO CS490_studentGrading(examID, questionID, username, studentAnswer) VALUES ('$examID','$questionID','$username','$studentAnswer')");
//
//// Pass back the string !!! if we failed to add a new question
//if ($result) {
//echo "New answer Added!";
//} else {
//echo "Error: " . $result . "<br>" . mysqli_error($connection);
//}





































mysqli_close($conn);
?>