<?php
if(session_id() == "") session_start(); // Start the session

if (isset($_POST['Shop_name'])) {
    // Update the session variable value
    $_SESSION['Shop_name'] = $_POST['Shop_name'];
    echo "The new value of Shop_name is: " . $_SESSION['Shop_name'];
} else {
    echo "No value provided";
}
?>
