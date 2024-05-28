<?php
// Start the session at the very beginning of the file
session_start();

// Include your connection file
include('connection.php');
include('checkuser.php');
checkUser();

// Determine the current page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 6;
$offset = ($page - 1) * $records_per_page;

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Count the total number of messages for this user
$count_sql = "SELECT COUNT(*) as total FROM messages WHERE senderId = ?";
$stmt = $con->prepare($count_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$count_result = $stmt->get_result();
$count_row = $count_result->fetch_assoc();
$total_pages = ceil($count_row['total'] / $records_per_page);

// Fetch messages for the user with limit and offset
$sql = "SELECT messageId, date, type, status, lastUpdate FROM messages WHERE senderId = ? ORDER BY  lastUpdate DESC LIMIT ?, ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("iii", $user_id, $offset, $records_per_page);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Userpage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
    <div id="topbar" style="background-color: #00421c; margin-bottom: 18px; border-top: 2px solid #eab676; border-bottom: 7px solid #eab676; color: #ffffff; text-align: center;">
        <table style="margin: 20px auto; vertical-align: center; padding: 20px;">
            <tr>
                <td rowspan="2" style="padding: 10px;"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/%C3%87ukurova_University_logo.svg/1200px-%C3%87ukurova_University_logo.svg.png" alt="" style="width: 100px;"></td>
                <td style="font-size: 16px; font-weight: 500; padding-top:10px; padding-left: 20px; color: #ffffff;">CUKUROVA UNIVERSITY / FACULTY OF ENGINEERING</td>
            </tr>
            <tr>
                <td style="font-size: 32px; font-weight: 500; padding-left: 20px; color: #ffffff;">COMPUTER ENGINEERING</td>
            </tr>
        </table>
    </div>
    <div class="container-fluid">
        <div class="row">
            <!--LEFT-->
            <div class="col-md-3 p-0 mx-auto">
                <div class="containerW">
                    <div class="row-md-4 info-container p-3 text-center">
                        <h2 style="color: black; font-weight: 600;">Create New</h2>
                    </div>
                    <div class="row-md-8 mt-5 mb-5 info-container">
                        <div class="d-grid">
                            <button onclick="window.location.href = 'petition.php'" type="submit" class="btn white-button mt-5 mb-4">
                                <p style="margin: auto; color: black; font-weight: 600; font-size: larger; font-size: 1v;">Petition</p>
                            </button>
                            <button onclick="window.location.href = 'complaint.php';" type="submit" class="btn white-button mb-4">
                                <p style="margin: auto; color: black; font-weight: 600; font-size: larger;">Complaint</p>
                            </button>
                            <button onclick="window.location.href = 'exam-excuse.php';" type="submit" class="btn white-button mb-4">
                                <p style="margin: auto; color: black; font-weight: 600; font-size: larger;">Exam Excuse Petition</p>
                            </button>
                            <button onclick="window.location.href = 'elective-course.php';" type="submit" class="btn white-button mb-4">
                                <p style="margin: auto; color: black; font-weight: 600; font-size: larger;">Elective Course Petition</p>
                            </button>
                            <button onclick="window.location.href = 'suggestion.php';" type="submit" class="btn white-button mb-4">
                                <p style="margin: auto; color: black; font-weight: 600; font-size: larger;">Suggestion</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--MIDDLE-->
            <div class="col-md-5 p-0">
                <div class="container">
                    <!--TOP-->
                    <div class="row-md-2 info-container p-3 text-center">
                        <h2 style="color: black; font-weight: 600;">Recent Activity</h2>
                    </div>
                    <!--BOTTOM-->
                    <div class="row-md-10 mt-5 mb-5 info-container p-4">
                        <div class="row text-center text-black">
                            <div class="row" style="align-items: center; margin: auto;">
                                <div class="table-responsive mt-3">
                                    <!--Table-->
                                    <table class="hoverTable" style="width: 100%;">
                                        <thead>
                                            <tr style="font-size: x-large;" class="table-head-row">
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Last Update</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $lastUpdate = htmlspecialchars($row["lastUpdate"]);
                                                    $sendingDate = htmlspecialchars($row['date']);
                                                    $updateDate = date("d/m/Y H.i", strtotime($lastUpdate));
                                                    $date = date("d/m/Y H.i",strtotime($sendingDate));

                                                    echo "<tr onclick=\"location.href='viewmessage.php?messageId=" . htmlspecialchars($row["messageId"]) . "'\" style='cursor:pointer;'>";
                                                    echo "<td>" . htmlspecialchars($row["messageId"]) . "</td>";
                                                    echo "<td>" . $date . "</td>";
                                                    echo "<td>" . $row["status"] . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["type"]) . "</td>";
                                                    echo "<td>" . $updateDate . "</td>";
                                                    echo "</tr>";
                                                }
                                                
                                            } else {
                                                echo "<tr><td colspan='4'>0 results</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="pagination">
                                        <?php
                                        for ($i = 1; $i <= $total_pages; $i++) {
                                            if ($i == $page) {
                                                echo "<div class='green-button mx-1' style='color:white; border-radius: 25%; height:30px; width: 30px; justify-content:center; align-items:center'><strong>$i</strong></div> ";
                                            } else {
                                                echo "<a class='green-button mx-1' style='color:white; text-decoration:none; border-radius: 25%; height:30px; width: 30px; justify-content:center; align-items:center' href='?page=$i'>$i</a>";
                                            }
                                        }
                                        ?>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--RIGHT-->
            <div class="col-md-3 info-container p-0 mx-auto mb-3">
                <!--1.4-->
                <div class="row-md-4">
                    <?php
                    $query = "SELECT imageUrl FROM students WHERE id = ?";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $imageUrl = $row['imageUrl'];

                    echo "<div style='background-image: url($imageUrl);' class='avatar'></div>";
                    ?>
                </div>
                <!--1.2-->
                <div class="row-md-2 w-100 text-center">
                    <div>
                        <h2 style="color: black;">Student's</h2>
                    </div>
                    <hr style="color: black;">
                </div>
                <!--1.6-->
                <div class="row-md-6">
                    <div class="col text-center px-5 py-2 text-black">
                        <div class="row" style="font-weight: bold;">Name</div>
                        <!--2.3 (Name)-->
                        <div class="row mb-3">
                            <?php
                            $query = "SELECT name FROM students WHERE id = ?";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $name = $row['name'];

                            echo "<div class='uniform-container container bg-light p-2' style='height: 2%;'><p style='margin:auto;'>$name</p></div>";
                            ?>
                        </div>
                        <div class="row" style="font-weight: bold;">ID</div>
                        <!--2.3 (Id)-->
                        <div class="row mb-3">
                            <?php
                            echo "<div class='container bg-light p-2' style='height: 2%; min-width 200px;'><p style='margin: auto;'>$user_id</p></div>";
                            ?>
                        </div>
                        <div class="row" style="font-weight: bold;">E-mail</div>
                        <!--2.3 (E-mail)-->
                        <div class="row mb-3">
                            <?php
                            $query = "SELECT email FROM students WHERE id = ?";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $email = $row['email'];

                            echo "<div class='container bg-light p-2' style='height: 2%;'><p style='margin: auto;'>$email</p></div>";
                            ?>
                        </div>
                        <!--2.3 (GPA and Semester)-->
                        <div class="row">
                            <!--3.5 (GPA)-->
                            <div class="col-md-5 p-0 mb-5 text-start"><b>GPA</b>
                                <?php
                                $query = "SELECT gpa FROM students WHERE id = ?";
                                $stmt = $con->prepare($query);
                                $stmt->bind_param("i", $user_id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $gpa = $row['gpa'];

                                echo "<div class='container bg-light text-center p-2' style='height: 60%;'><p style='margin: auto;'>$gpa</p></div>";
                                ?>
                            </div>
                            <!--3.2-->
                            <div class="col-md-2"></div>
                            <!--3.5 (Semester)-->
                            <div class="col-md-5 p-0 mb-5 text-start"><b>Semester</b>
                                <?php
                                $query = "SELECT semester FROM students WHERE id = ?";
                                $stmt = $con->prepare($query);
                                $stmt->bind_param("i", $user_id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $semester = $row['semester'];

                                echo "<div class='container bg-light text-center p-2' style='height: 60%;'><p style='margin: auto;'>$semester</p></div>";
                                ?>
                            </div>
                            <form action="logout.php" method="post">
                                <button type="submit" class="btn green-button mb-4" style="width: 60%;">
                                    <p style="margin:auto; color: white; font-weight: 600; font-size: larger;">Log Out</p>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>
