<?php

#$conn = mysqli_connect('localhost','root','','Shop') die('connection failed'); 
#$conn = mysqli_connect('0.0.0.0:3306','root','root','Shop') or die('connection faled');
#$conn = mysqli_connect('192.168.206.69:3306','root','root','Shop') or die('connection failed');
//if(session_id() == "") { session_start(); } 
$conn = mysqli_connect('sql311.infinityfree.com', 'if0_37213501', 'sFHzi6KnuRp8t', 'if0_37213501_Shop') or die('connection failed infinityfree db');
if($conn){
    /*$users_list = $conn->query("SELECT * FROM users");
    if($users_list && $users_list->num_rows > 0){
        $_SESSION['Users_length'] = $users_list->num_rows;
    }

    $products_list = $conn->query("SELECT * FROM products");
    if($products_list && $products_list->num_rows > 0){
        $_SESSION['products_length'] = $products_list->num_rows;
    }   */
}
?>