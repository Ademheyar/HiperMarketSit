<?php
#$conn = mysqli_connect('0.0.0.0:3306','root','root','Shop') or die('connection failed');
$conn = mysqli_connect('localhost','root','','Shop') or die('connection failed 2');
if(session_id() == "") { session_start(); } 
if($conn){
    $users_list = $conn->query("SELECT * FROM users");
    if($users_list && $users_list->num_rows > 0){
        $_SESSION['Users_length'] = $users_list->num_rows;
    }

    $products_list = $conn->query("SELECT * FROM products");
    if($products_list && $products_list->num_rows > 0){
        $_SESSION['products_length'] = $products_list->num_rows;
        

    }   

    if(!isset($_SESSION['Shops_Table'])){
        $select_s = $conn->query("SELECT * FROM `Shops`");
        if(mysqli_num_rows($select_s) > 0){
            while($row = mysqli_fetch_assoc($select_s))                
            {
                $_SESSION['Shops_Table'][] = $row;
            }
        }
    }
}
?>