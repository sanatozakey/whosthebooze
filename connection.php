<?php
    //Opens a connection to server
    $conn = mysqli_connect("localhost", "root", "", "php_connection", "3306", "D:/xampp/mysql/mysql.sock") or die(mysqli_error($conn));
    
    //Selects a database from server
    mysqli_select_db($conn, "php_connection") or die(mysqli_error($conn));
?>