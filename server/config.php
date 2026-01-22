<?php

#$conn = mysqli_connect('localhost','root','','Shop') die('connection failed'); 
$conn = mysqli_connect('0.0.0.0:3306','root','root','Shop') or die('connection faled');
#$conn = mysqli_connect('192.168.206.69:3306','root','root','Shop') or die('connection failed');
//if(session_id() == "") { session_start(); } 
#$conn = mysqli_connect('sql301.ezyro.com', 'ezyro_36534249', '8edaed67dac', 'ezyro_36534249_shop') or die('connection failed 2');
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