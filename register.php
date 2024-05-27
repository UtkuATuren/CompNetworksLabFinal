<?php
include('connection.php');

$name = $_POST['name'];
$id = $_POST['id'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$gpa = $_POST['gpa'];
$semester = $_POST['semester'];
$imageUrl = $_POST['imageUrl'];
$password = $_POST['pass'];
$passwordCheck = $_POST['pass2'];


// Validate input
if (empty($id) || empty($password || empty($passwordCheck) || 
    empty($name) || empty($email) || empty($phone) || empty($gpa) || 
    empty($semester) || empty($imageUrl))) {
    echo "<h1>Registration failed. All fields are required.</h1>";
    header("refresh:3; url=register.php");
    exit();
}

// Prevent SQL injection
$id = stripcslashes($id);
$password = stripcslashes($password);
$id = mysqli_real_escape_string($con, $id);
$password = mysqli_real_escape_string($con, $password);

// Act like you hash the password
$passwordHash = $password;

// Check if user already exists
$sql = "SELECT * FROM students WHERE id = '$id'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h1>Registration failed. Username already exists.</h1>";
    header("refresh:3; url=register.html");
} else {
    // Insert new user into the database
    $sql = "INSERT INTO students (id, password, name , email , phone , gpa , semester , imageUrl , isAdmin ) VALUES ('$id', '$passwordHash' , '$name' , '$email' , '$phone' , '$gpa' , '$semester' , '$imageUrl' , '0')";
    if (mysqli_query($con, $sql)) {
        echo "<h1>Registration successful. You can now log in.</h1>";
        header("refresh:3; url=index.html");
    } else {
        echo "<h1>Registration failed. Please try again.</h1>";
        header("refresh:3; url=register.html");
    }
}

mysqli_close($con);
?>
