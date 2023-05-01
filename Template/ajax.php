
<?php 
// Initialize your database connection
@include 'config.php';


// Get the start and limit parameters from the query string
$start = isset($_GET['page']) ? (int)$_GET['page'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

// Prepare the SQL query
$sql = "SELECT * FROM products LIMIT $start, $limit";

// Execute the query
$stmt = $con->query($sql);

// Fetch the results as an array of objects
$results = $stmt->fetchAll(PDO::FETCH_OBJ);

// Return the results as JSON
echo json_encode($results);

?>