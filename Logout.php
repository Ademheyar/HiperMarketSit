<?php
	session_start();
	$_SESSION['loged_user_name'] = "";
	$_SESSION['loged_user_password'] = "";
	$_SESSION['loged_user_type'] = 0;
	$_SESSION['on'] = 0;
	
	include('Home.php'); 
?>
