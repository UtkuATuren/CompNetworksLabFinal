<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: index.html");
    exit();
}

include_once "db_connection.php"; 

$userId = $_SESSION['user_id']; 
$query = "SELECT * FROM users WHERE id = $userId";
$result = mysqli_query($connection, $query);

if (!$result) {
    echo json_encode(array("error" => "Database query error"));
    exit();
}

$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo json_encode(array("error" => "User not found"));
    exit();
}

echo json_encode($user);

mysqli_close($connection);
?>