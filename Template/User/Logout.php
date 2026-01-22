<?php
	session_start();
	$_SESSION['loged_user_name'] = "";
	$_SESSION['loged_user_password'] = "";
	$_SESSION['loged_user_type'] = 0;
	$_SESSION['on'] = 0;
	$_SESSION['User_Shops'] = 0;
	
  if(file_exists("../../Home.php")) header("Location: ../../Home.php");
if(file_exists("../Home.php")) header("Location: ../Home.php");
  exit; // Make sure to include exit after the header redirect
?>
