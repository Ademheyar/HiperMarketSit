
<?php
  if(file_exists("config.php")) include("config.php");
  if(file_exists("../config.php")) include("../config.php");
  if(file_exists("../../config.php")) include("../../config.php");

// PHP code
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Retrieve the offset and limit from the AJAX request
$list_what = $_POST['list_what'];
$offset = $_POST['offset'];
$limit = $_POST['limit'];
$firstset = $_POST['firstset'];
$lastset = $_POST['lastset'];
$Company_Id = $_POST['Company_Id'];

$withtype = $_POST['withtype'];
$query = "";
$a = "";
$sql = "";
$items = array(); // Create an empty array to hold the items
$list_clumens = array(); // Create an empty array to hold the items



# TYPES
// TOP_SALED
// TOP_SALED_ITEMS
// TOP_USERS
// TOP_SALED_TYPES
// TOTAL_SUM
// TOTAL_COUNTED

$Top_saled = 0; // TOP SOLDE DOCUMENT WILL DISPLAYED
$Top_saled_items = 0; // TOP ITEM SOLDE WILL BE DISPLAYED
$TOP_USERS = 0; // TOP USERS How Buy WILL BE DISPLAYED
$TOP_SALED_TYPES = 0; // TOP_SALED_TYPES WILL BE DISPLAYED
$TOTAL_SUM = 0;
$TOTAL_COUNTED = 0;
$Created_Date = 0;
$Expire_Date = 0;
$Updated_Date = 0;
$FromDate ="";
$ToDate = "";
if($withtype != ""){
  $searchs = explode(";", ($withtype.";"));
  if($list_what === "ITEMS" || $list_what === "BANNERS" || $list_what === "COLLECTIONS" || $list_what === "DOCUMENTS")
  {
    $date_query = "";
    foreach($searchs as $search){
      if($search == "") continue;
      if($search == "TOP_SALED_ITEMS") { $Top_saled_items = 1; continue; }
      if($search == "TOP_SALED") { $Top_saled = 1;  continue; }
      if($search == "TOP_USERS") { $TOP_USERS = 1;  continue; }
      if($search == "TOP_SALED_TYPES") { $TOP_SALED_TYPES = 1;  continue; }
      if($search == "TOTAL_SUM") { $TOTAL_SUM = 1;  continue; }
      if($search == "TOTAL_COUNTED") { $TOTAL_COUNTED = 1;  continue; }
      
      if(strpos($search, ":")){
        list($key, $value) = explode(":", $search);
        if($key == "Created Date"){
          $Created_Date=1;
          if ($FromDate != "" && $ToDate != "") {
            if($Created_Date== 1) $Created_Date = 0;
            if($date_query != "") $date_query .= " OR document_created_date BETWEEN '$FromDate' AND '$ToDate'";
            else $date_query .= "document_created_date BETWEEN '$FromDate' AND '$ToDate'";
          }
        }
        else if($key == "Expire Date"){
          $Expire_Date=1;
          if ($FromDate != "" && $ToDate != "") {
            if($Expire_Date== 1) $Expire_Date = 0;
            if($date_query != "") $date_query .= " OR document_expire_date BETWEEN '$FromDate' AND '$ToDate'";
            else $date_query .= "document_expire_date BETWEEN '$FromDate' AND '$ToDate'";
          }
        }
        else if($key == "Updated Date"){
          $Updated_Date=1;
          if ($FromDate != "" && $ToDate != "") {
            if($Updated_Date== 1) $Updated_Date = 0;
            if($date_query != "") $date_query .= " OR document_updated_date BETWEEN '$FromDate' AND '$ToDate'";
            else $date_query .= "document_updated_date BETWEEN '$FromDate' AND '$ToDate'";
          }
        }
        else if($key == "From" || $key == "To") {
          if($key == "From") $FromDate = $value;
          else if($key == "To") $ToDate = $value;
          
          if ($FromDate != "" && $ToDate != "") {
            if($Created_Date== 1) {
              $Created_Date = 0;
              if($date_query != "") $date_query .= " OR document_created_date BETWEEN '$FromDate' AND '$ToDate'";
              else $date_query .= "document_created_date BETWEEN '$FromDate' AND '$ToDate'";
            }
            if($Expire_Date== 1) {
              $Expire_Date = 0;
              if($date_query != "") $date_query .= " OR document_expire_date BETWEEN '$FromDate' AND '$ToDate'";
              else $date_query .= "document_expire_date BETWEEN '$FromDate' AND '$ToDate'";
            }
            if($Updated_Date== 1) {
              $Updated_Date = 0;
              if($date_query != "") $date_query .= " OR document_updated_date BETWEEN '$FromDate' AND '$ToDate'";
              else $date_query .= "document_updated_date BETWEEN '$FromDate' AND '$ToDate'";
            }
          }
        }
        else{
          if($query != "") $query .= " AND  $key LIKE '%$value%'";
          else $query .= "WHERE $key LIKE '%$value%'";
        }
      }
    }
    if($date_query != "") {
      if($query != "") $query .= " AND  $date_query";
      else $query .= "WHERE $date_query";
    }
  }

  if($list_what === "SHOPS"){
    foreach($searchs as  $search){
      if($search == "") continue;
      list($key, $value) = explode(":", $search);
      if($query != "") $query .= "AND  $key LIKE '%$value%'";
      else $query .= "WHERE $key LIKE '%$value%'";
    }
  }
}

$result  = $conn->query("SELECT * FROM shops ORDER BY Shop_Id");

if($list_what === "ITEMS")  $result = $conn->query("SELECT * FROM products ORDER BY id");
if($list_what === "BANNERS") $result = $conn->query("SELECT * FROM products ORDER BY id");
if($list_what === "COLLECTIONS") $result = $conn->query("SELECT * FROM products ORDER BY id");
//if($list_what === "SHOPS" || $list_what === "SHOP_ITEMS") 
if($list_what === "DOCUMENTS") $result = $conn->query("SELECT * FROM documents ORDER BY document_id");

if ($result && $result->num_rows > 0) {
  
  $length = $result->num_rows;
  $in = 0; // To loop ones if there is no resulet in all list
  
  if($offset == 0 )
  {
    // Fetch items from the database based on the firstset and limit
    while (1) {
      if ($firstset == 0 || $firstset - $limit < 0) {
        if($firstset - $limit < 0)
          $firstset = 0;
        else  $firstset = $length - $limit;

        if($in == 1) break;
        else $in = 1;
        $a .= " firtseted";
      }
      else $firstset -= $limit;
      if($list_what === "BANNERS") $sql = "SELECT * FROM products $query ORDER BY id LIMIT $limit OFFSET $firstset";
      if($list_what === "ITEMS") $sql = "SELECT * FROM products $query ORDER BY id LIMIT $limit OFFSET $firstset";
      if($list_what === "COLLECTIONS") $sql = "SELECT * FROM products $query ORDER BY id LIMIT $limit OFFSET $firstset";
      if($list_what === "SHOPS") $sql = "SELECT * FROM shops $query ORDER BY Shop_Id LIMIT $limit OFFSET $firstset";
      if($list_what === "DOCUMENTS") $sql = "SELECT * FROM documents $query ORDER BY document_id LIMIT $limit OFFSET $firstset";
      if($list_what === "SHOP_ITEMS") $sql = "SELECT * FROM shops WHERE Shop_Id='$Company_Id'";
      $result = $conn->query($sql);
      $l = $result->num_rows;
      $a .= " first = ".$firstset." limt = ".$limit." l = ".$l;
      if($l) break;
    }
  }
  else if($offset == 1)
  {
    while (1) {
      // Fetch items from the database based on the lastset and limit
      if ($lastset >= $length || $lastset + $limit > $length) {
        $lastset = 0;
        if($in == 1) break;
        else $in = 1;
        $a .= " Lastseted";
      }
      else $lastset += $limit;
      if($list_what === "BANNERS") $sql = "SELECT * FROM products $query ORDER BY id LIMIT $lastset, $limit";
      if($list_what === "ITEMS") $sql = "SELECT * FROM products $query ORDER BY id LIMIT $lastset, $limit";
      if($list_what === "COLLECTIONS") $sql = "SELECT * FROM products $query ORDER BY id LIMIT $lastset, $limit";
      if($list_what === "SHOPS") $sql = "SELECT * FROM shops $query ORDER BY Shop_Id LIMIT $lastset, $limit";
      if($list_what === "SHOP_ITEMS") $sql = "SELECT * FROM shops WHERE Shop_Id='$Company_Id'";
      if($list_what === "DOCUMENTS") $sql = "SELECT * FROM documents $query ORDER BY document_id LIMIT $lastset, $limit";
      # TODO GET TOTAL ITEAM AND IF ITEM REACHED TO THE LAST LIST START FROM BOTTOM AND RESPOND THAT IT STARTS FROM FIRST ITEM
      $result = $conn->query($sql);
      $l = $result->num_rows;
      $a .= " lastset = ".$lastset." limt = ".$limit." l = ".$l;
      if($l) break;
    }
  }
  
  if ($result->num_rows > 0) {
    $T_SUM = 0;
    while ($row = $result->fetch_assoc()) {
      $list_clumens = array_keys($row);
      $isInvalid = false;
      $item = array();
      // $query LIMIT , 
      //json_encode($Shop_items_list)
      if($list_what === "SHOP_ITEMS")
      {
        $company_items_info = $row['Shop_items'];
        $company_items_list = json_decode($company_items_info);
        $i=0;
        $added = 0;
        $minus = 0;
        $li =  $limit;
        while($li % 2 != 0) $li--;
        $i = $lastset-($li/2);
        if($i < 0) {
          if (count($company_items_list) != 0) $i = count($company_items_list)-1;
          else $i = 0;
        }
        if($i >= count($company_items_list)) $i = 0;
        for (;$i < count($company_items_list);) {  
          $item = [];   
          if (count($items) == $limit) break;
          $item_query = "WHERE id=".$company_items_list[$i][1];
          if($query != "") $item_query = $query."AND id=".$company_items_list[$i][1];
          $sql = "SELECT * FROM products $item_query";
          $itemfound = $conn->query($sql);
          if ($itemfound->num_rows > 0) {
            while ($fitem = $itemfound->fetch_assoc()) {
              $list_clumens = array_keys($fitem);
              $item = $fitem;
            }      
          }
          // Add the item to the items array
          if($item != []) $items[] = $item;
          if($offset == 0) $i++;
          else if($offset == 1) $i--;
          if(count($items) <= $limit && $i < 0) $i = count($company_items_list)-1;
          if(count($items) <= $limit && $i >= count($company_items_list)) $i = 0;
        }
        $item = []; 
        if($offset == 0) $i++;
        else if($offset == 1) $i--;
        $lastset = $i;
      }
      if($list_what === "DOCUMENTS"){
        if($TOP_USERS){
          //$item[$document_barcode] = $row[$value];
          //TODO CHACKE USER IS NOT REPITED AND COUNT USER SALL DOCUUMENTS
          $item["document_barcode"] = $row["document_barcode"];
          $item["customer_id"] = $row["customer_id"];

          $list_clumens = ["document_barcode", "customer_id"];
        }
        if($TOP_SALED_TYPES){
          //$item[$document_barcode] = $row[$value];
          //TODO CHACKE USER IS NOT REPITED AND COUNT USER SALL DOCUUMENTS
          $item["document_barcode"] = $row["document_barcode"];

          $list_clumens = ["document_barcode", "Type"];
        }

        if($TOTAL_SUM){
          //$item[$document_barcode] = $row[$value];
          //TODO CHACKE USER IS NOT REPITED AND COUNT USER SALL DOCUUMENTS
          $T_SUM += $row["price"];
          $list_clumens = [];
        }

        if($TOTAL_COUNTED){
          //$item[$document_barcode] = $row[$value];
          //TODO CHACKE USER IS NOT REPITED AND COUNT USER SALL DOCUUMENTS
          $list_clumens = [];
        }

        if (!$TOP_USERS && !$TOP_SALED_TYPES && !$TOTAL_SUM && !$TOTAL_COUNTED) $item = $row;
      }
      if ($list_what === "ITEMS") {
          foreach ($list_clumens as $clumen) {
              if ($clumen === "at_shop") {
                  $item_shop_ids = explode(',', $row[$clumen].','); // Split the string into an array of IDs
                  $item_shops = [];
      
                  foreach ($item_shop_ids as $shop_id) {
                      $shop_id = trim($shop_id); // Remove any whitespace
                      if($shop_id === "") continue;
                      $item_shop_result = $conn->query("SELECT * FROM shops WHERE Shop_Id='$shop_id'");
      
                      if ($item_shop_result && $item_shop_result->num_rows > 0) {
                          $item_shops[] = $item_shop_result->fetch_assoc(); // Add the shop data to the array
                      }
                  }
      
                  $item[$clumen] = $item_shops; // Store the array of shop data
              } else {
                  $item[$clumen] = $row[$clumen];
              }
          }
      }
      if($list_what === "BANNERS" || $list_what === "COLLECTIONS" || $list_what === "SHOPS")
      {
          $item = $row;
      }
      // Add the item to the items array
      if($item != []) $items[] = $item;
    }
    if($list_what === "DOCUMENTS"){
      if($Top_saled){
        function sortBy($a, $b){
          return $b['price'] - $a['price']; // From Greater TO Less
          //return $a['price'] - $b['price']; // From Less TO Greater
        }
        usort($items, 'sortBy');
        $list_clumens = ["document_barcode", "price"];
      }
      if($TOTAL_SUM){
        //$item[$document_barcode] = $row[$value];
        //TODO CHACKE USER IS NOT REPITED AND COUNT USER SALL DOCUUMENTS
        $item = [];
        $item["TOTAL_SUM"] = $T_SUM;
        $items[] = $item;
        $list_clumens[] = "TOTAL_SUM";
      }

      if($TOTAL_COUNTED){
        //$item[$document_barcode] = $row[$value];
        //TODO CHACKE USER IS NOT REPITED AND COUNT USER SALL DOCUUMENTS
        $item = [];
        $item["TOTAL_COUNTED"] = $result->num_rows;
        $items[] = $item;
        $list_clumens[] = "TOTAL_COUNTED";
      }
    }
  }
}
//$values = ['id', 'name', 'code', 'type', 'barcode', 'at_shop', 'quantity', 'cost', 'tax', 'price', 'include_tax', 'price_change', 'more_info', 'images', 'description', 'service', 'default_quantity', 'active'];
//$shops_columens = ['Shop_Id', 'Shop_name', 'Shop_brand_name', 'shop_type', 'Shop_oweners_id', 'Shop_linke', 'shop_email', 'shop_phone_no', 'Shop_location', 'Shop_about', 'Shop_rate', 'Shop_likes', 'Shop_followers', 'Shop_items', 'Shop_workers', 'Shop_password', 'Shop_contry', 'Shop_settings', 'Shop_Page', 'Shop_profile_img', 'Shop_banner_imgs', 'Shop_payment_r', 'Shop_balance', 'Shop_payment_info', 'Shop_isenable'];
//[`document_id`, `document_barcode`, `documents_extension_barcode`, `user_id`, `customer_id`, `document_type`, `item`, `qty`, `price`, `discount`, `tax`, `payments`, `document_created_date`, `document_expire_date`, `document_updated_date`]
// Create the response array
$response = array(
  'list_clumens' => $list_clumens,
  'items' => $items, // Include the items array
  'firstset' => $firstset,
  'lastset' => $lastset,
  'a' =>  $a,
  'list_what' => $list_what,
  'sql' =>  $sql
);

// Encode the response array as JSON
$jsonResponse = json_encode($response);
//$jsonResponse = str_replace('"', '|',  $jsonResponse);
// Close the database connection
$conn->close();

// Echo the JSON response
echo $jsonResponse;
?>