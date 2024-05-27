<?php
// Start the session at the very beginning of the file
session_start();

// Include your connection file
include('connection.php');

// Your other PHP code and HTML content go here
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggestion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
    <div id="topbar"
        style="background-color: #00421c; margin-bottom: 18px; border-top: 2px solid #eab676; border-bottom: 7px solid #eab676; color: #ffffff; text-align: center;">
        <table style="margin: 20px auto; vertical-align: center; padding: 20px;">
            <tr>
                <td rowspan="2" style="padding: 10px;"><img
                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/%C3%87ukurova_University_logo.svg/1200px-%C3%87ukurova_University_logo.svg.png"
                        alt="" style="width: 100px;"></td>
                <td style="font-size: 16px; font-weight: 500; padding-top:10px; padding-left: 20px; color: #ffffff;">
                    CUKUROVA UNIVERSITY / FACULTY OF ENGINEERING</td>
            </tr>
            <tr>
                <td style="font-size: 32px; font-weight: 500; padding-left: 20px; color: #ffffff;">COMPUTER ENGINEERING
                </td>
            </tr>
        </table>
    </div>
    <div class="container-fluid p-0">
        <div class="row mx-auto">
            <!--LEFT-->
            <div class="col-md-8 p-0 mx-auto">
                <div class="container p-0">
                    <!--TOP-->
                    <div class="row-md-2 info-container p-3">
                        <div class="container-fluid">
                            <div class="row mx-auto mt-3">
                                <div class="col-md-3 mx-auto">
                                <p style="color: black; font-weight: 700;">Type: Petition<br>
                                <?php
                                include('connection.php');

                                $userId = $_SESSION['user_id'];

                                $query = "SELECT name,id FROM students WHERE id = $userId";
                                $result = mysqli_query($con, $query);
                                $row = mysqli_fetch_assoc($result);
                                $name = $row['name'];
                                $id = $row['id'];

                                echo "<p style='color:black; font-weight: 700'>Student Name: $name</p><p style='color: black; font-weight: 700'>Student ID: $id</p>";
                            ?>
                            </div>
                                    <!-- BURAYI KURCALIYORUM
                                <p style="color: black; font-weight: 700;">Type: Complaint<br>
                                Student Name: Tolga Küçükaşçı<br>
                                Student ID: 2022555451</p>
                                </div> -->

                                <div class="col-md-6"></div>
                                <div class="col-md-3 mx-auto" p-0>
                                <p style="float: right; color: black; font-weight: 700;">
                                    Date:<?php 
                                    echo date("d.m.Y");
                                    ?> 
                                </div> 
                            </div>
                        </div>
                    </div>
                    <!--MIDDLE-->
                    <form action="sendMessage.php" method="POST">
                        <!-- hidden input implying this is a complaint-->
                        <input type="hidden" name="type" value="Petition">
                        <!--MIDDLE-->
                    <div class="row-md-6 mt-5 mb-5 info-container p-3">
                        <div class="row text-center text-black">
                            <div class="row" style="align-items: center; margin: auto;">
                                <div class="container mt-3 text-start">
                                    <h3 style="text-align: center;">Bilgisayar Mühendisliği Bölüm Başkanlığına</h3><br>                                   
                                    <textarea  id="content" name="content" rows="12" ></textarea><br>                                    
                                    <p>Gereğinin yapılmasını arz ederim.                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--BOTTOM-->
                    <div class="container info-container mb-3 p-3 text-center">
                        <div class="btn-group d-flex justify-content-around " role="group" aria-label="Basic example">
                            <button onclick="window.location.href = 'userpage.php';" type="button" class="btn btn-primary green-button align-items-center justify-content-center" style="border: #ffffff; width: 25%; border-radius: 10px; height: 5vh;" ><i style="margin-right: 3%; width: 24px; height: 24px ;" class="fa-solid fa-left-long"></i> Go back</button>
                            <input type="file" class="form-control" id="inputGroupFile01" style="padding: 1%;padding-left: 9.3%; width: 40%; margin-left: 10%; margin-right: 10%; color: white;  background-color: #00421c;">

                            
                            <button type="submit" class="btn btn-primary green-button align-items-center justify-content-center" style="border: #ffffff; width: 25%; border-radius: 10px; height: 5vh">Send<i style="margin-left: 3%;" class="fa-solid fa-share"></i></button>
                        </div>
                    </div>
                    </form>
                
                </div>
            </div>
            
            
            <!--RİGHT-->
            <div class="col-md-3 info-container p-0 mx-auto mb-3">
                <!--1.4-->
                    <div class="row-md-4">
                    <?php
                   
                   include('connection.php');

                   $userId = $_SESSION['user_id'];

                   $query = "SELECT imageUrl FROM students WHERE id = $userId";
                   $result = mysqli_query($con, $query);
                   $row = mysqli_fetch_assoc($result);
                   $imageUrl = $row['imageUrl'];
                   
                   echo "<div style='background-image: url($imageUrl);' class='avatar'></div>"

                   ?>
                    </div>
                <!--1.2-->
                    <div class="row-md-2 text-center">
                        <div>
                            <h2 style="color: black;">Student's</h2>
                        </div>
                        <hr style="color: black;">
                    </div>
                <!--1.6-->
                    <div class="row-md-6">
                        <div class="col text-center mx-5 px-5 py-2 text-black">
                            <div class="row" style="font-weight: bold;">Name</div>
                <!--2.3 (Name)-->           
                <div class="row mb-3">
                            <?php
                                include('connection.php');

                                $userId = $_SESSION['user_id'];

                                $query = "SELECT name FROM students WHERE id = $userId";
                                $result = mysqli_query($con, $query);
                                $row = mysqli_fetch_assoc($result);
                                $name = $row['name'];

                                echo "<div class='container bg-light p-2' style='height: 2%;'><p style='margin: auto;'>$name</p></div>";
                            ?>
                            </div>                       
                        <div class="row" style="font-weight: bold;">ID</div>
            <!--2.3 (Id)--> 
                        <div class="row mb-3">                            
                                <?php
                                    $userId = $_SESSION['user_id'];
                                    echo "<div class='container bg-light p-2' style='height: 2%;'><p style='margin: auto;'>$userId</p></div>";
                                ?>                            
                        </div>
                        <div class="row" style="font-weight: bold;">E-mail</div>
            <!--2.3 (E-mail)--> 
                        <div class="row mb-3">
                        <?php
                                include('connection.php');

                                $userId = $_SESSION['user_id'];

                                $query = "SELECT email FROM students WHERE id = $userId";
                                $result = mysqli_query($con, $query);
                                $row = mysqli_fetch_assoc($result);
                                $email = $row['email'];

                                echo "<div class='container bg-light p-2' style='height: 2%;'><p style='margin: auto;'>$email</p></div>";
                            ?>
                        </div>
            <!--2.3 (GPA and Semester)--> 
            <div class="row">
                <!--3.5 (GPA)--> 
                            <div class="col-md-5 p-0 mb-5 text-start" ><b>GPA</b>
                                <?php
                                    include('connection.php');

                                    $userId = $_SESSION['user_id'];

                                    $query = "SELECT gpa FROM students WHERE id = $userId";
                                    $result = mysqli_query($con, $query);
                                    $row = mysqli_fetch_assoc($result);
                                    $gpa = $row['gpa'];

                                    echo "<div class='container bg-light text-center p-2' style='height: 60%;'><p style='margin: auto;'>$gpa</p></div>";
                                ?>                    
                            </div>
                <!--3.2--> 
                                <div class="col-md-2"></div>
                <!--3.5 (Semester)-->
                                <div class="col-md-5 p-0 mb-5 text-start"><b>Semester</b>
                                    <?php
                                        include('connection.php');

                                        $userId = $_SESSION['user_id'];

                                        $query = "SELECT semester FROM students WHERE id = $userId";
                                        $result = mysqli_query($con, $query);
                                        $row = mysqli_fetch_assoc($result);
                                        $semester = $row['semester'];

                                        echo "<div class='container bg-light text-center p-2' style='height: 60%;'><p style='margin: auto;'>$semester</p></div>";
                                    ?>
                                </div>
                                
                                <button type="submit" class="btn green-button"
                                            style="float: right; width: 60%;">
                                            <p style="margin:auto; color: black; font-weight: 600; font-size: larger;">Edit
                                            <i class="fa-regular fa-pen-to-square"></i></p>
                                        </button>
                        </div>
                    </div>
                    </div>
                </div>
                
            </div>
            
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>


</body>

</html>
