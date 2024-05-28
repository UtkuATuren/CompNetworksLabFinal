<?php
    include("connection.php");
    function checkUser() : void {
        if (!isset($_SESSION['user_id'])){
            header("Location:unauthorized.php");
        }
    }
?>