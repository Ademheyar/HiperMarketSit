<?php
@include '../../config.php';
// PHP code
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$result = $conn->query("SELECT * FROM doc_table");
$length = $result->num_rows;
# TODO GET TOTAL ITEAM AND IF ITEM REACHED TO THE LAST LIST START FROM BOTTOM AND RESPOND THAT IT STARTS FROM FIRST ITEM
$items = array(); // Create an empty array to hold the items
$a = "";

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    // Add the item to the items array
    $items[] = $row;
  }
}
// Create the response array
$response = array(
  'doc' => $items, // Include the items array
  'a' => $a
);

// Encode the response array as JSON
$jsonResponse = json_encode($response);

// Close the database connection
$conn->close();

// Echo the JSON response
echo $jsonResponse;
?>