
<?php
@include 'config.php';
// PHP code
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Retrieve the offset and limit from the AJAX request
$offset = $_POST['offset'];
$limit = $_POST['limit'];
$firstset = $_POST['firstset'];
$lastset = $_POST['lastset'];

$result = $conn->query("SELECT * FROM products");
$length = $result->num_rows;

if($offset == 0)
{
  // Fetch items from the database based on the firstset and limit
  if ($firstset == 0) {
    $firstset = $length - $limit;
  }
  else $firstset -= $limit;
  $sql = "SELECT * FROM products ORDER BY id LIMIT $firstset, $limit";
  $result = $conn->query($sql);
}
else if($offset == 1)
{
  // Fetch items from the database based on the lastset and limit
  if ($lastset >= $length) {
    $lastset = 0;
  }
  else $lastset += $limit;
  # TODO GET TOTAL ITEAM AND IF ITEM REACHED TO THE LAST LIST START FROM BOTTOM AND RESPOND THAT IT STARTS FROM FIRST ITEM
  $sql = "SELECT * FROM products ORDER BY id LIMIT $lastset, $limit";
  $result = $conn->query($sql);
}
$items = array(); // Create an empty array to hold the items
$a = "";

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    // Access and process each item's values
    $items[] = $row;
  }
}
// Create the response array
$response = array(
  'items' => $items, // Include the items array
  'firstset' => $firstset,
  'lastset' => $lastset,
  'a' => $a
);

// Encode the response array as JSON
$jsonResponse = json_encode($response);

// Close the database connection
$conn->close();

// Echo the JSON response
echo $jsonResponse;
?>