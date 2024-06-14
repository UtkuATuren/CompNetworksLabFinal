<?php
session_start();

include('connection.php');
include('checkuser.php');

checkUser();

// Determine the current page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page =8;
$offset = ($page - 1) * $records_per_page;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
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
    <div class="container-fluid">
        <div class="row">
            <!--MİDDLE-->
            <div class="col-md-9 p-0 ">
                <div class="container">
                    <!--TOP-->
                    <div class="row-md-2 info-container p-3 text-center">
                        <h2 style="color: black; font-weight: 600;">Recent Activity</h2>
                    </div>
                    <!--BOTTOM-->
                    <div class="row-md-10 mt-5 mb-5 info-container p-3">
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
                                                <th>From</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Last Update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        // Fetch messages with limit and offset
                                        $sql = "SELECT messageId, date, type, senderId, senderName, status, lastUpdate FROM messages ORDER BY lastUpdate DESC LIMIT $offset, $records_per_page";
                                        $result = mysqli_query($con, $sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $lastUpdate = htmlspecialchars($row["lastUpdate"]);
                                                $sendingDate = htmlspecialchars($row['date']);
                                                $updateDate = date("d/m/Y H.i", strtotime($lastUpdate));
                                                $date = date("d/m/Y H.i",strtotime($sendingDate));
                                                echo "<tr onclick=\"location.href='viewmessage.php?messageId=" . htmlspecialchars($row["messageId"]) . "'\" style='cursor:pointer;'>";
                                                echo "<td>" . $row["messageId"] . "</td>";
                                                echo "<td>" . $date . "</td>";
                                                echo "<td>" . $row["type"] . "</td>";
                                                echo "<td>" . $row["senderId"] . "</td>";
                                                echo "<td>" . $row["senderName"] . "</td>";
                                                echo "<td>" . $row["status"] . "</td>";
                                                echo "<td>" . $updateDate . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>0 results</td></tr>";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <div class="pagination">
                                        <?php
                                        // Count the total number of records
                                        $count_sql = "SELECT COUNT(*) as total FROM messages";
                                        $count_result = mysqli_query($con, $count_sql);
                                        $count_row = mysqli_fetch_assoc($count_result);
                                        $total_pages = ceil($count_row['total'] / $records_per_page);

                                        for ($i = 1; $i <= $total_pages; $i++) {
                                            if ($i == $page) {
                                                echo "<div class='green-button mx-1' style='color:white; border-radius: 25%; width: 30px; justify-content:center'><strong>$i</strong></div> ";
                                            } else {
                                                echo "<a class='green-button mx-1' style='color:white; text-decoration:none; border-radius: 25%; width: 30px; justify-content:center' href='?page=$i'>$i</a>";
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
            <!--RİGHT-->
            <div class="col-md-3 info-container p-0 mx-auto mb-3">
                <div class="row-md-4">
                    <?php
                    include('connection.php');
                    $userId = $_SESSION['user_id'];
                    $query = "SELECT imageUrl FROM students WHERE id = $userId";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_assoc($result);
                    $imageUrl = $row['imageUrl'];
                    echo "<div style='background-image: url($imageUrl);' class='avatar'></div>";
                    ?>
                </div>
                <div class="row-md-2 text-center">
                    <div>
                        <h2 style="color: black;">Admin's</h2>
                    </div>
                    <hr style="color: black;">
                </div>
                <div class="row-md-6">
                    <div class="col text-center mx-5 px-5 py-2 text-black">
                        <div class="row" style="font-weight: bold;">Name</div>
                        <div class="row mb-5">
                            <?php
                            $query = "SELECT name FROM students WHERE id = $userId";
                            $result = mysqli_query($con, $query);
                            $row = mysqli_fetch_assoc($result);
                            $name = $row['name'];
                            echo "<div class='container bg-light p-2' style='height: 2%;'><p style='margin: auto;'>$name</p></div>";
                            ?>
                        </div>
                        <div class="row" style="font-weight: bold;">ID</div>
                        <div class="row mb-5">
                            <?php
                            echo "<div class='container bg-light p-2' style='height: 2%;'><p style='margin: auto;'>$userId</p></div>";
                            ?>
                        </div>
                        <div class="row" style="font-weight: bold;">E-mail</div>
                        <div class="row mb-5">
                            <?php
                            $query = "SELECT email FROM students WHERE id = $userId";
                            $result = mysqli_query($con, $query);
                            $row = mysqli_fetch_assoc($result);
                            $email = $row['email'];
                            echo "<div class='container bg-light p-2' style='height: 2%;'><p style='margin: auto;'>$email</p></div>";
                            ?>
                        </div>
                        <div class="row mt-5">
                            <form action="logout.php" method="post">
                                <button type="submit" class="btn green-button mb-4" style="width: 60%;">
                                    <p style="margin:auto; color: white; font-weight: 600; font-size: larger;">Log Out
                                </button>
                            </form>
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
