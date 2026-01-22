<?php 
if (session_id() == "") session_start();
$_SESSION['msg'][] = "user work shop not found";
if ($_SESSION['previous_page']){
    header("Location: ".array_pop($_SESSION['previous_page']));
    }
    else {
        $_SESSION['on'] = 6;
       header("Location: /Home.php");
       }
   exit;     
?>