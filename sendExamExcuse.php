
<?php
// Start the session at the very beginning of the file
session_start();

// Include your connection file
include("connection.php");

// Retrieve the ex, why, new and type from the form
$code = mysqli_real_escape_string($con, $_POST['code']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$credit = mysqli_real_escape_string($con, $_POST['credit']);
$AKTS = mysqli_real_escape_string($con, $_POST['AKTS']);
$type = mysqli_real_escape_string($con, $_POST['type']);
$why = mysqli_real_escape_string($con, $_POST['why']);

$userId = $_SESSION['user_id'];
$date = date("Y-m-d"); // Correct date format for SQL

// Get the username/senderName from the database
$query = "SELECT name FROM students WHERE id = $userId";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$senderName = mysqli_real_escape_string($con, $row['name']);

$content = "Bölümünüz " . $userId . " nolu öğrencisiyim. " . $why . " nedeniyle ara sınavına giremediğim aşağıda belirtilen dersten mazeret sınav hakkı verilmesini arz ederim."."<br>". Ders kodu: " . $code . "<br>" . " Ders Adı: " . $name . "<br>" . " Kredisi: " . $credit  . "<br>" . " AKTS: " . $AKTS;

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