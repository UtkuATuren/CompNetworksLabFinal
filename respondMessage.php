<?php
include('connection.php');

$messageId = $_POST['messageId'];
$status = $_POST['action'];
$statusDesc = $_POST['statusDesc'];

    // Sanitize the inputs to prevent SQL Injection
    $status = mysqli_real_escape_string($con, $status);
    $statusDesc = mysqli_real_escape_string($con, $statusDesc);
    $messageId = mysqli_real_escape_string($con, $messageId);

    // Update the database with the new status and description
    $sql = "UPDATE messages SET status = '$status', statusDesc = '$statusDesc' WHERE messageId = $messageId ";

    if (mysqli_query($con, $sql)) {
        echo "Your update has been successfully sent.";
        header("refresh:2;url=adminpage.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
        header("refresh:5;url=adminpage.php");
    }

    // Close the database connection
    mysqli_close($con);

?>
