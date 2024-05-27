<?php
// userinfo.php

// Assuming you've already started the session to access session variables
session_start();

// Check if the user is logged in (you can adjust this based on your authentication mechanism)
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: index.html");
    exit();
}

// Include your database connection file
include_once "db_connection.php"; // Adjust the file path as per your project structure

// Retrieve user information from the database
$userId = $_SESSION['user_id']; // Assuming you store user ID in session after successful login
$query = "SELECT * FROM users WHERE id = $userId";
$result = mysqli_query($connection, $query);

if (!$result) {
    // Handle database query error
    echo json_encode(array("error" => "Database query error"));
    exit();
}

// Fetch user information
$user = mysqli_fetch_assoc($result);

// Check if user exists
if (!$user) {
    // Handle user not found error
    echo json_encode(array("error" => "User not found"));
    exit();
}

// Return user information in JSON format
echo json_encode($user);

// Close database connection
mysqli_close($connection);
?>