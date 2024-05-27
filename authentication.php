<?php 
    include('connection.php');  
    $id = $_POST['user'];  
    $password = $_POST['pass'];  
      
        //to prevent from mysqli injection  
        $id = stripcslashes($id);  
        $password = stripcslashes($password);  
        $id = mysqli_real_escape_string($con, $id);  
        $password = mysqli_real_escape_string($con, $password);  
      
        $sql = "select *from students where id = '$id' and password = '$password'";  
        $result = mysqli_query($con, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
          
        if($count == 1){  
            session_start();
            $_SESSION['user_id'] = $id;

            //admin mi değil mi kontrolü
            $userId = $_SESSION['user_id'];
            $query = "SELECT isAdmin FROM students WHERE id = $userId";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);
            $isAdmin = $row['isAdmin'];

            if ($isAdmin==0) {
                header("Location:userpage.php");
            }
            if ($isAdmin==1) {
                header("Location:adminpage.php");
            }
            
            exit();  
        }  
        else{  
            echo "<h1> Login failed. Invalid id $id or password.</h1>";
            header("refresh:3; url=index.html");  
        }     
?>  