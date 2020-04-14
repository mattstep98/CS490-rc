<?php
$examID = $_POST["examID"];
$questionID = $_POST["questionID"];
$questionDescription = $_POST["questionDescription"];
$username = $_POST["username"];
$studentAnswer = $_POST["studentAnswer"];
$testCases = $_POST["testCases"];


//Graded Vars------------------------------------
$correctName = false;







//----------------------------------------------
















$examID = 1;
$questionID = 1;
$questionDescription = "Write a function named doubleIt that takes in 1 integer variable and returns double that integer.";
$username = "test";
$studentAnswer = "def doubleIt(int1):return int1*2;";
$testCases=array();
$testCases = [[[4],8],[[6],12]];
//Testcase input and output seperation

//    [[[TC1I1,TC1I2,...,TC1IN],TC1OUT],[[TC2I1,TC2I2,...,TC2IN],TC2OUT],...,[[TCNI1,TCNI2,...,TCNIN],TCNOUT]]
$sepInputs = array();
$sepOutputs = array();
$outputs = array();
$inputs = array();


foreach ($testCases as $testCase){
  foreach($testCase as $output){
    $sepOutputs[] = $output;
    foreach($output as $input){
      $sepInputs[] = $input;
    }
  }
}

foreach ($sepInputs as $sepIn) //seperates inputs into a workable array
{
  $inputs[] = $sepIn;
}



$count =0;
foreach ($sepOutputs as $sepOut)  //seperates outputs into a workable array
{
  if ($count%2==0){
    $count++;
    continue;
  }
  $outputs[] = $sepOut;
  $count++;
}




$numInputs = (sizeof($inputs)/sizeof($outputs)); //determines how many inputs there are for each output
$numTestCases = sizeof($outputs); //determines how many test cases there are

$testCaseCounter = 0;
$inputCounter = 0;
$programFunctionCounter = 23;
$programFunctionName = "";



while($questionDescription[$programFunctionCounter] != ' '){
  $programFunctionName .=$questionDescription[$programFunctionCounter];
  $programFunctionCounter++;
}

$programFunctionCounter = 4;
$studentFunctionName = "";
while (($studentAnswer[$programFunctionCounter] != "(") && ($studentAnswer[$programFunctionCounter] != " ")) //goes through function name starting after "def " and ending when it hits a " " or {
{
  $studentFunctionName = $studentFunctionName .= $studentAnswer[$programFunctionCounter];
  $programFunctionCounter++;
}
$studentFunctionName = str_replace(' ', '', $studentFunctionName);
if ($studentFunctionName == $programFunctionName)
{
  $correctName = true;
}


while($testCaseCounter != $numTestCases){
  //TODO  CHECK ALL THE TEST CASES
}
































?>