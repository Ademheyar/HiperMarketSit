<?php
@include '../../config.php';
// PHP code
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(session_id() == "") session_start();

// Create the response array
$response = array(
  'Shop_name' => $_SESSION['Shop_name'], // Include the items array
  'on_view' => $_SESSION['on_view']
);

// Encode the response array as JSON
$jsonResponse = json_encode($response);

// Close the database connection
$conn->close();

// Echo the JSON response
echo $jsonResponse;
?>