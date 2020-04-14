<?php
include "db.php";

$questionDescription = $_POST["questionDescription"];
$questionTopic = $_POST["questionTopic"];
$questionLevel = $_POST["questionLevel"];
$testCases = $_POST["testCases"];

$result = mysqli_query($connection, "INSERT INTO `CS490_questions`(`description`, `topic`, `level`, `testCases`) VALUES ('$questionDescription','$questionTopic','$questionLevel','$testCases')");

// Pass back the string !!! if we failed to add a new question
if ($result) {
echo "New question created successfully";
} else {
echo "Error: " . $result . "<br>" . mysqli_error($connection);
}

mysqli_close($conn);
?>