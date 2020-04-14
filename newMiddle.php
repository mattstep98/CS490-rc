<?php
//Group 10 rc Middle
//Matthew Stepnowski

//POST Variables----------------
$username = $_POST["username"];
$password = $_POST["password"];
$message_type = $_POST["message_type"];
$studentAnswer = $_POST["studentAnswer"];
$examName = $_POST["examName"]; 
$examID = $_POST["examID"];
$examQuestionsAndPoints = $_POST[$examQuestionsAndPoints];
$questionID = $_POST["questionID"];
$points = $_POST["points"];
$questionName = $_POST["questionName"];
$questionLevel = $_POST["questionLevel"];
$questionTopic = $_POST["questionTopic"];
$questionDescription = $_POST["questionDescription"];
$teacherComment = $_POST["teacherComment"];
$newScore = $_POST["newScore"];
$testCases = $_POST["testCases"];
$grade = $_POST["grade"];


//message_types-------------------------------------------------------
if ($message_type == "login_request"){ //login
  $res_login=login_backEnd($username,$password);
  echo $res_login;
}  
elseif ($message_type == "run_code"){ //runs python code
  $res_run=run($questionID,$username,$examID); //returns the 3 cases in string format (0 is wrong, 1 is correct)
  $res_process=process_score($res_run,$points);  //returns how many points the student will get for the question
  $res_send_results_to_back=send_results_to_back($questionID,$examID,$username,$res_process); //sends the grade to the back
  echo $res_send_results_to_back;
}
elseif ($message_type == "create_exam"){ //requests to add an exam to the database
   $res_create_exam=create_exam($examName, $examQuestionsAndPoints); //adds the exam to the database
   echo $res_create_exam;
}

elseif ($message_type == "select_question"){ //selects a question from the question bank
   $res_select_question=select_question($questionID);
   echo $res_select_question;
}
elseif ($message_type == "list_exams"){ //lists all exams in the database
   $res_list_exams = list_exams();
   echo $res_list_exams;
}
elseif ($message_type == "view_results_teacher"){ //views results from back
   $res_view_results_teacher = view_results_teacher($username,$examID);
   echo $res_view_results_teacher;
}
elseif ($message_type == "view_results_student"){ //views results from back
   $res_results_student = view_results_student($username,$examID);
   echo $res_results_student;
}
elseif ($message_type == "take_exam"){ //
   $res_take_exam = take_exam($examID);
   echo $res_take_exams;
}
elseif ($message_type == "add_student_answer"){ //adds the students answer to the database
   $res_add_student_answer = add_student_answer($examID, $questionID, $username, $studentAnswer);
   echo $res_add_student_answer;
}
elseif ($message_type == "get_questions"){ //views all questions in the question bank
   $res_get_questions = get_questions();
   echo $res_get_questions;
}
elseif ($message_type == "teacher_override"){ //Teacher overrides existing score with a new one
   $res_teacher_override = teacher_override($examID,$questionID,$username,$grade,$comments);
   echo $res_teacher_override;
}
elseif ($message_type == "create_question"){ //adds a question to the database
   $res_create_question=create_question($questionDescription, $questionTopic, $questionLevel, $testCases);
   echo $res_create_question;
}
elseif ($message_type == "release_scores"){ //releases scores
   $res_release_scores=releaseScores($examID,$username);
   echo $res_release_scores;
}
elseif ($message_type == "filter_question"){ //releases scores
   $res_filter_question=filter_question($topic,$level);
   echo $res_filter_question;
}
if ($message_type == "auto_grade"){ //trigger the autograding
  $res_auto_grade=autoGrade($examID,$questionID, $username, $studentAnswer, $testCases);
  echo $res_auto_grade;
}  
if ($message_type == "list_students_that_took_exam"){ //trigger the autograding
  $res_list_students_that_took_exam=list_students_that_took_exam($username,$examID);
  echo $res_list_students_that_took_exam;
}  
else{
  echo '{"message_type": "error"}';
}

//functions----------------------------------------------------------------------------------------------------
function login_backEnd($username,$password)
{
 	$data = array('username' => $username, 'password' => $password);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/login.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}

function create_exam($examName, $examQuestionsAndPoints)
{
 	$data = array('examName' => $examName, 'examQuestionsAndPoints' => $examQuestionsAndPoints);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/createExam.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}

function create_question($questionDescription, $questionTopic, $questionLevel, $testCases)
{
 	$data = array('questionDescription' => $questionDescription, 'questionTopic' => $questionTopic, 'questionLevel' => $questionLevel, 'testCases' => $testCases);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/createQuestion.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}

function select_question($questionID)
{
 	$data = array('questionID' => $questionID);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/selectQuestion.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}



function filter_question($topic,$level)
{
 	$data = array('topic' => $topic, 'level' => $level);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/filterQuestions.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}

function list_exams()
{
 	$data = array();
 	$url = "https://web.njit.edu/~mjs239/CS490/database/listExams.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}

function take_exam($examID)
{
 	$data = array('examID' => $examID);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/takeExam.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}


function add_student_answer($examID, $questionID, $username, $studentAnswer)
{
 	$data = array('examID' => $examID,'questionID' => $questionID,'username' => $username,'studentAnswer' => $studentAnswer);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/addStudentAnswer.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}

function teacher_override($examID,$questionID,$username,$grade,$teacherComment)
{
 	$data = array('examID' => $examID, 'questionID' => $questionID,'username' => $username,'grade' => $grade,'teacherComment' => $teacherComment);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/teacherOverride.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}

function list_students_that_took_exam($examID)
{
 	$data = array('examID' => $examID);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/listStudentsThatTookExam.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}


function view_results_teacher($username,$examID)
{
 	$data = array('examID' => $examID, 'username' => $username);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/viewResultsTeacher.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}

function view_results_student($username,$examID)
{
 	$data = array('examID' => $examID, 'username' => $username);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/viewResultsStudent.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}




function get_questions()
{
 	$data = array();
 	$url = "https://web.njit.edu/~mjs239/CS490/database/allQuestions.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}


function release_scores($examID,$username)
{
 	$data = array('examID' => $examID,'username' => '$username');
 	$url = "https://web.njit.edu/~mjs239/CS490/database/releaseScores.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}







//Testing user input functions-----------------------------------------------------------
function get_test_cases($questionID){
  $data = array('questionID' => $questionID);
 	$url = "https://web.njit.edu/~fw73/selectTestcase.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}

function get_user_code($questionID,$username,$examID){
  $data = array('questionID' => $questionID,'username' => $username,'examID' => $examID);
 	$url = "https://web.njit.edu/~fw73/reviewRawAnswer.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}

function send_results_to_back($questionID,$examID,$username,$res_process){
  $data = array('questionID' => $questionID,'examID' => $examID,'username' => $username,'grade' => $res_process);
 	$url = "https://web.njit.edu/~fw73/GradeAnswer.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); //Recieve the encoded JSON response from the backend
  curl_close ($curl);
  return $res;
}

//Testing User Input(Autograding)-------------------------------------------------------------------------

function autoGrade($examID,$questionID, $username, $studentAnswer, $testCases)
{
  
}












































?>