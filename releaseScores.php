<?php
include "db.php";
$username = $_POST['username'];
$examID = $_POST['examID'];


$result = mysqli_query($connection, "UPDATE CS490_studentGrading SET releaseGrades = 1 WHERE username = '$username' and examID = '$examID'");

// Pass back the string !!! if we failed to add a new question
if ($result) {
echo "Successfully Updated";
} else {
echo "Error: " . $result . "<br>" . mysqli_error($connection);
}

mysqli_close($conn);
?>