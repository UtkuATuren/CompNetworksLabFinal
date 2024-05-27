
<?php
// Start the session at the very beginning of the file
session_start();

// Include your connection file
include("connection.php");

// Retrieve the ex, why, new and type from the form
$ex = mysqli_real_escape_string($con, $_POST['ex']);
$why = mysqli_real_escape_string($con, $_POST['why']);
$new = mysqli_real_escape_string($con, $_POST['new']);
$type = mysqli_real_escape_string($con, $_POST['type']);
$userId = $_SESSION['user_id'];
$date = date("Y-m-d"); // Correct date format for SQL

// Get the username/senderName from the database
$query = "SELECT name FROM students WHERE id = $userId";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$senderName = mysqli_real_escape_string($con, $row['name']);

$content = "<br>Dersin kodu: " . $ex . "<br>Bırakılma nedeni: " . $why . "<br>Alınması istenen ders: " . $new;

// Construct the SQL query to insert the data into the messages table
$sqlquery = "INSERT INTO messages (senderId, senderName, date, type, content) VALUES ('$userId', '$senderName', '$date', '$type', '$content')";

// Execute the query and check for errors
if ($con->query($sqlquery) === TRUE) {
    echo "Your message has been succesfully sent.";
    header("refresh:2;url=userpage.php");
} else {
    echo "Error: " . $sqlquery . "<br>" . $con->error;
    header("refresh:5;url=userpage.php");
}
?>