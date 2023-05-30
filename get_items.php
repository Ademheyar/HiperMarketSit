<?php
// PHP code
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve the offset and limit from the AJAX request
$offset = $_POST['offset'];
$limit = $_POST['limit'];

// Fetch items from the database based on the offset and limit
$sql = "SELECT * FROM products ORDER BY id DESC LIMIT $offset, $limit";
$result = $conn->query($sql);

$items = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $items[] = $row;
  }
}

// Close the database connection
$conn->close();

// Return items as JSON response
$response = array('items' => $items);
echo json_encode($response);
?>
