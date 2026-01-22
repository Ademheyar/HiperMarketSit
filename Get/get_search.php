
<?php
  if(file_exists("config.php")) include("config.php");
  if(file_exists("../../config.php")) include("../../config.php");
// PHP code
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Retrieve the offset and limit from the AJAX request
$Type = $_POST['Type'];
$query = $_POST['query'];
$limit = $_POST['limit'];

// Access and process each item's values
$values = ['id', 'name', 'code', 'type', 'barcode', 'at_shop', 'quantity', 'cost', 'tax', 'price', 'include_tax', 'price_change', 'more_info', 'images', 'description', 'service', 'default_quantity', 'active'];
$shops_columens = ['Shop_Id', 'Shop_name', 'Shop_brand_name', 'shop_type', 'Shop_oweners_id', 'Shop_linke', 'shop_email', 'shop_phone_no', 'Shop_location', 'Shop_about', 'Shop_rate', 'Shop_likes', 'Shop_followers', 'Shop_items', 'Shop_workers', 'Shop_password', 'Shop_contry', 'Shop_settings', 'Shop_profile_img', 'Shop_banner_imgs', 'Shop_payment_r', 'Shop_balance', 'Shop_payment_info', 'Shop_isenable'];

foreach (array_merge($values, $shops_columens) as $value) {
  if(strtolower($Type) == $value || $value == $Type) $Type = $value;
}

$result = $conn->query("SELECT * FROM products WHERE $Type LIKE '%$query%' LIMIT $limit");

if(in_array($Type, $values)){
  $result = $conn->query("SELECT * FROM products WHERE $Type LIKE '%$query%' LIMIT $limit");
}
else if(in_array($Type, $shops_columens)){
  $result = $conn->query("SELECT * FROM shops WHERE $Type LIKE '%$query%' LIMIT $limit");
}

$length = $result->num_rows;

$items = array(); // Create an empty array to hold the items
$a = "";

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    
    $isInvalid = false;
    $item = array();
    $item1 = array();
    if (empty($row[$Type])){
      $item1[$Type] = "";
    }
    else {
      //$item1[$Type] = $row[$value];
      array_push($items, $row[$Type]);
    }

    if ($isInvalid) {
      // Handle the error, log it, or take appropriate action
      // For example, you can skip this row by using the `continue` statement
      continue;
    }

    // Add the item to the items array
    //$items[] = $item;
  }
}
// Create the response array
$response = array(
  'items' => $items, // Include the items array
  'a' => $a
);

// Encode the response array as JSON
$jsonResponse = json_encode($response);

// Close the database connection
$conn->close();

// Echo the JSON response
echo $jsonResponse;
?>