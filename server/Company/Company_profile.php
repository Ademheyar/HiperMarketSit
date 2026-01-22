<?php

if(file_exists("config.php")) include("config.php");
if(file_exists("Template/Actions/List.php")) include("Template/Actions/List.php");

if(file_exists("../config.php")) include("../config.php");
if(file_exists("../Template/Actions/List.php")) include("../Template/Actions/List.php");

if(file_exists("../../config.php")) include("../../config.php");
if(file_exists("../../Template/Actions/List.php")) include("../../Template/Actions/List.php");

if(file_exists("../../../config.php")) include("../../../config.php");
if(file_exists("../../../Template/Actions/List.php")) include("../../../Template/Actions/List.php");

// PHP code
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Custom error handler to log errors
function customErrorHandler($errno, $errstr, $errfile, $errline) {
$error_message = "Error: [$errno] $errstr - $errfile:$errline";
// Log error to a file
error_log($error_message, 3, 'errors.log');
// Display error message to user
echo json_encode(['error_message' => $error_message, 'status' => 'Error', 'message' => 'An error occurred.']);
exit();
}

set_error_handler('customErrorHandler');
// Custom exception handler

function customExceptionHandler($exception) {
$error_message = "Exception: " . $exception->getMessage();
// Log exception to a file
error_log($error_message, 3, 'errors.log');
// Display exception message to user
echo json_encode(['status' => 'Exception', 'message' => 'An unexpected error occurred.']);
    exit();
}
set_exception_handler('customExceptionHandler');

    // PHP code
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if(session_id() == "") { session_start(); } 


$message = "";
$image_path = "";
$New_Shop_rate = "";
$items = array();
$result = [];
$allshopPaymentTools = array();
$allshopworkers = array();

//header('Content-Type: application/json');

if (!isset($conn)) {
    echo json_encode(['success' => false, 'message' => 'Database connection not established.']);
    exit;
}

if(isset($_POST['Shop_Worker_action'])) {
  $action = $_POST['Shop_Worker_action'];

  if ($action === 'save_Shop_Worker') {
      $shopname = $_POST['Company_Id'];
      
      $Company_Id = '';
      if (empty($Company_Id)) {
        if (isset($_SESSION['loged_user_info']['User_work_shop'])) {
            $user_shops = json_decode($_SESSION['loged_user_info']['User_work_shop'], true);
            foreach ($user_shops as $shop) {
              if($shopname == $shop[1])
              {
                $Company_Id = $shop[0];
              }
            }
        }
      }
      if (!empty($Company_Id)) {
          $stmt = $conn->prepare("SELECT * FROM shops WHERE Shop_Id = ?");
          $stmt->bind_param('i', $Company_Id);
          $stmt->execute();
          $result = $stmt->get_result();
  
          if ($result->num_rows > 0) {
              $shop = $result->fetch_assoc();
              $shopPaymentTools = json_decode($shop['Shop_Payment_Tools'], true) ?? [];
              $Methodscombobox = $_POST['Methodscombobox'] ?? 'Cash';
              $shopName = $_POST['register_sname'] ?? '';
              $toolName = $_POST['register_tname'] ?? '';
              $index = $_POST['register_No'] ?? '';
              $type = $_POST['register_location'] ?? '';
              $shortCut = $_POST['register_password'] ?? '';
              $accessKey = $_POST['register_cpassword'] ?? '';
  
              $enablePayment = isset($_POST['enable_payment']) &&  $_POST['enable_payment'] ? true : false;
              $quickPayment = isset($_POST['quick_payment']) &&  $_POST['quick_payment'] ? true : false;
              $customerRequired = isset($_POST['customer_required']) &&  $_POST['customer_required'] ? true : false;
              $printSlip = isset($_POST['print_slip']) &&  $_POST['print_slip'] ? true : false;
              $markAsPaid = isset($_POST['mark_as_paid']) &&  $_POST['mark_as_paid'] ? true : false;
              $openCashDrawer = isset($_POST['open_cash_drawer']) &&  $_POST['open_cash_drawer'] ? true : false;
  
              if (empty($Methodscombobox) ||empty($shopName) || empty($toolName) || empty($index) || empty($type) || empty($shortCut) || empty($accessKey)) {
                  $message = 'All fields are required.';
              } else {
                  $paymentTools = [
                      $toolName,
                      $Methodscombobox,
                      $index,
                       $type,
                      $shortCut,
                      $accessKey,
                     $enablePayment,
                      $quickPayment,
                      $customerRequired,
                      $printSlip,
                      $markAsPaid,
                       $openCashDrawer
                  ];
  
                  $shopPaymentTools[] = $paymentTools;
  
                  $updatedPaymentToolsJson = json_encode($shopPaymentTools);
  
                  $updateStmt = $conn->prepare("UPDATE shops SET Shop_Payment_Tools = ? WHERE Shop_Id = ?");
                  $updateStmt->bind_param('si', $updatedPaymentToolsJson, $Company_Id);
                  $updateStmt->execute();
                  $allshopPaymentTools = $shopPaymentTools;
  
                  if ($updateStmt->affected_rows > 0) {
                      $message = 'Shop updated successfully.';
                  } else {
                      $message = 'Failed to update the shop.';
                  }
                  $updateStmt->close();
              }
          }
          $stmt->close();
      }
  } elseif ($action === 'get_Shop_Worker_for_all_shops') {
      if (isset($_SESSION['loged_user_info']['User_work_shop'])) {
          $user_shops = json_decode($_SESSION['loged_user_info']['User_work_shop'], true);
          $shops = array_column($user_shops, 0);
  
          foreach ($shops as $shopId) {
              if (empty($shopId)) continue;
  
              $stmt = $conn->prepare("SELECT * FROM shops WHERE Shop_Id = ?");
              $stmt->bind_param('i', $shopId);
              $stmt->execute();
              $result = $stmt->get_result();
  
              if ($result->num_rows > 0) {
                  $shop = $result->fetch_assoc();
                  $shopWorkers = json_decode($shop['Shop_workers'], true) ?? [];
                  $allshopworkers = array_merge($allshopworkers, $shopWorkers);
              }
          }
      }
  }
}

         /*if (isset($_SESSION['Selected_Shop']) && $_SESSION['Selected_Shop']['Shop_workers'] != "") {
           $workers_infos = explode("~", $_SESSION['Selected_Shop']['Shop_workers']);
           echo($workers_infos[1]); 
           $workers_s = json_decode($workers_infos[1]);
           for($r=0; $r < count($workers_s); $r++) {
               $Value = $workers_s[$r];
               $w_id = $Value[0];
               $select_worker = mysqli_query($conn, "SELECT * FROM `users` WHERE User_id ='$w_id'");
               if(mysqli_num_rows($select_worker) > 0){
                  while($row = mysqli_fetch_assoc($select_worker)){?>
                  </tr>
               <?php };    
               }else{
               echo "<div class='empty'>no product added</div>";
            };
           }
         }?>*/

if(isset($_POST['payment_tool_action'])) {
  $action = $_POST['payment_tool_action'];

  if ($action === 'save_payment_tool') {
      $shopname = $_POST['Company_Id'];
      
      $Company_Id = '';
      if (empty($Company_Id)) {
        if (isset($_SESSION['loged_user_info']['User_work_shop'])) {
            $user_shops = json_decode($_SESSION['loged_user_info']['User_work_shop'], true);
            foreach ($user_shops as $shop) {
              if($shopname == $shop[1])
              {
                $Company_Id = $shop[0];
              }
            }
        }
      }
      if (!empty($Company_Id)) {
          $stmt = $conn->prepare("SELECT * FROM shops WHERE Shop_Id = ?");
          $stmt->bind_param('i', $Company_Id);
          $stmt->execute();
          $result = $stmt->get_result();
  
          if ($result->num_rows > 0) {
              $shop = $result->fetch_assoc();
              $shopPaymentTools = json_decode($shop['Shop_Payment_Tools'], true) ?? [];
              $Methodscombobox = $_POST['Methodscombobox'] ?? 'Cash';
              $shopName = $_POST['register_sname'] ?? '';
              $toolName = $_POST['register_tname'] ?? '';
              $index = $_POST['register_No'] ?? '';
              $type = $_POST['register_location'] ?? '';
              $shortCut = $_POST['register_password'] ?? '';
              $accessKey = $_POST['register_cpassword'] ?? '';
  
              $enablePayment = isset($_POST['enable_payment']) &&  $_POST['enable_payment'] ? true : false;
              $quickPayment = isset($_POST['quick_payment']) &&  $_POST['quick_payment'] ? true : false;
              $customerRequired = isset($_POST['customer_required']) &&  $_POST['customer_required'] ? true : false;
              $printSlip = isset($_POST['print_slip']) &&  $_POST['print_slip'] ? true : false;
              $markAsPaid = isset($_POST['mark_as_paid']) &&  $_POST['mark_as_paid'] ? true : false;
              $openCashDrawer = isset($_POST['open_cash_drawer']) &&  $_POST['open_cash_drawer'] ? true : false;
  
              if (empty($Methodscombobox) ||empty($shopName) || empty($toolName) || empty($index) || empty($type) || empty($shortCut) || empty($accessKey)) {
                  $message = 'All fields are required.';
              } else {
                  $paymentTools = [
                      $toolName,
                      $Methodscombobox,
                      $index,
                       $type,
                      $shortCut,
                      $accessKey,
                     $enablePayment,
                      $quickPayment,
                      $customerRequired,
                      $printSlip,
                      $markAsPaid,
                       $openCashDrawer
                  ];
  
                  $shopPaymentTools[] = $paymentTools;
  
                  $updatedPaymentToolsJson = json_encode($shopPaymentTools);
  
                  $updateStmt = $conn->prepare("UPDATE shops SET Shop_Payment_Tools = ? WHERE Shop_Id = ?");
                  $updateStmt->bind_param('si', $updatedPaymentToolsJson, $Company_Id);
                  $updateStmt->execute();
                  $allshopPaymentTools = $shopPaymentTools;
  
                  if ($updateStmt->affected_rows > 0) {
                      $message = 'Shop updated successfully.';
                  } else {
                      $message = 'Failed to update the shop.';
                  }
                  $updateStmt->close();
              }
          }
          $stmt->close();
      }
  } elseif ($action === 'get_payment_tool_for_all_shops') {
      if (isset($_SESSION['loged_user_info']['User_work_shop'])) {
          $user_shops = json_decode($_SESSION['loged_user_info']['User_work_shop'], true);
          $shops = array_column($user_shops, 0);
  
          foreach ($shops as $shopId) {
              if (empty($shopId)) continue;
  
              $stmt = $conn->prepare("SELECT * FROM shops WHERE Shop_Id = ?");
              $stmt->bind_param('i', $shopId);
              $stmt->execute();
              $result = $stmt->get_result();
  
              if ($result->num_rows > 0) {
                  $shop = $result->fetch_assoc();
                  $shopPaymentTools = json_decode($shop['Shop_Payment_Tools'], true) ?? [];
                  $allshopPaymentTools = array_merge($allshopPaymentTools, $shopPaymentTools);
              }
          }
      }
  }
}

if(isset($_POST['Change_Company_logo_Image'])){
   $message = $message." in Change_Company_logo_Image";
   $main_p = dirname(dirname(getcwd())); // ../../ to go back to main path from server/company
   $Company_Id = $_POST['Company_Id'];
   $main_ps = "{$main_p}/Img/Company/{$Company_Id}/";
   $img_name = "{$Company_Id}_Logo.jpg";
   $message = $message ." main_ps ".$main_ps;


   // Create the new path
   if (!is_dir($main_ps)) {
        mkdir($main_ps, 0777, true);
    }

   //$insert_query = mysqli_query($conn, "INSERT INTO `products`(name, code, type, barcode, cost, tax, price, include_tax, price_change, images, more_info, Description, Service, Default_Quantity, Active) VALUES('$p_name', '$p_code', '$p_type', '$p_barcode', '$p_price_cost', '$p_markup' , '$p_sale_price', '$p_include_tax', '$p_change_allowed', '$p_img_names', '$p_info', '$p_disc', '$p_Service', '$p_Def_qty', '$p_active')") or die('query failed');
   if(isset($_FILES['Company_logo_Image']))
   {
      $image = $_FILES['Company_logo_Image'];
      $message = $message ." Company_logo_Image ";
      if (isset($image['tmp_name']) && !empty($image['tmp_name'])) {
         $message = $message ." has tmp_name ";
         $filename = basename($image['name']);
         $newFilePath = $main_ps.$img_name;
         $image_path = "Img/Company/{$Company_Id}/{$img_name}";
         $tmpName = $image['tmp_name'];
         $message = $message ." tmpName ".$tmpName;
         $message = $message ." newFilePath ".$newFilePath;
         // Generate unique filename and move file to upload directory
         if($tmpName != ""){
            if(move_uploaded_file($tmpName, $newFilePath)){
               $message .= "File uploaded successfully: ".$newFilePath;
            }  
         }
      }
      //for ($i=0; $i < count($image['tmp_name']); $i++) { 
         
      //}
   }
}
else if(isset($_POST['Selecte_Company_By_Id'])){
   $message = $message." in Selecte_Company_By_Id";
   $Company_Id = $_POST['Company_Id'];
   $message = $message ." Company_Id ".$Company_Id;

   $result = $conn->query("SELECT * FROM shops WHERE Shop_Id='$Company_Id'");
   
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         $_SESSION['Selected_Shop'] = $row;
         $message = $message ." seccsesfully added  ".$Company_Id;
      }
   }
}
else if(isset($_POST['Get_Company_By_Id'])){
   $message = $message." in Get_Company_By_Id";
   $Company_Id = $_POST['Company_Id'];
   $message = $message ." Company_Id ".$Company_Id;

   $result = $conn->query("SELECT * FROM shops WHERE Shop_Id='$Company_Id'");
   
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         $list_clumens = array_keys($row);
         if($row)
         {
           $item = array();
           $item["Shop_Id"] = $row['Shop_Id'];
           //$item[] = $row['code'];
           $item["Shop_brand_name"] = $row['Shop_brand_name'];
           $item["Shop_name"] = $row['Shop_name'];
           $items[] = $item;
         }
      }
   }
}
else if(isset($_POST['Company_Items'])){
   $message = $message." in Company_Items";
   $main_p = dirname(dirname(getcwd())); // ../../ to go back to main path from server/company
   $Company_Id = $_POST['Company_Id'];
   $User_Id = $_POST['User_Id'];

   $Product_Id = $_POST['Product_Id'];
   $message = $message ." Company_Id ".$Company_Id;

   $result = $conn->query("SELECT * FROM shops WHERE Shop_Id='$Company_Id'");
   if ($result->num_rows > 0) {
      //$fetch = $result->fetch_assoc();
      $message = $message ." User_Id ".$User_Id;
      $message = $message ." Product_Id ".$Product_Id;
      
      while ($row = $result->fetch_assoc()) {
         //`$list_clumens = array_keys($row);
         $Shop_items = $row['Shop_items'];
         $message = $message ." Shop_items ".$Shop_items;
         $Shop_item_info = explode("~", $Shop_items);
         
         $Shop_items_list = json_decode($Shop_item_info[1]);   
         //$Shop_items_list = loadList($Shop_item_info[1]);
         $message = $message ." Shop_raters ".json_encode($Shop_items_list);
         $found = 0;
         $count = count($Shop_items_list);
         for ($i=0; $i < count; $i++) { 
            if($Shop_items_list[$i][1] == $Product_Id){
               $found = 1;
               $Shop_items_list[$i][0] = $User_Id;
               $Shop_items_list[$i][2] = date('d-m-Y');
            }
         }
         if($found == 0) {
            $message = $message ." raternot found creating new one ";
            array_push($Shop_items_list, [$User_Id,  $Product_Id, date('d-m-Y'), date('d-m-Y')]);
            $count++;
         }
         $message = $message ." Shop_items_list ".json_encode($Shop_items_list);
         $New_Shop_items = $count.'~'.json_encode($Shop_items_list);
         $message = $message ." New_Shop_items ".$New_Shop_items;
         $sql = "UPDATE `shops` SET `Shop_items`='$New_Shop_items' WHERE Shop_Id = '$Company_Id'";
         if ($conn->query($sql) === TRUE) $message .= "New product added successfully.";
         else $message .= "Error: " . $sql . "<br>" . $conn->error;
         if($_SESSION['Selected_Shop']['Shop_items']) $_SESSION['Selected_Shop']['Shop_items'] = $New_Shop_items;
         //$conn->close();
      }
   }
}
else if(isset($_POST['Company_workers'])){
   $message = $message." in Company_workers";
   $main_p = dirname(dirname(getcwd())); // ../../ to go back to main path from server/company
   $Company_Id = $_POST['Company_Id'];
   $User_Id = $_POST['User_Id'];

   $Product_Id = $_POST['Product_Id'];
   $message = $message ." Company_Id ".$Company_Id;

   $result = $conn->query("SELECT * FROM shops WHERE Shop_Id='$Company_Id'");
   if ($result->num_rows > 0) {
      //$fetch = $result->fetch_assoc();
      $message = $message ." User_Id ".$User_Id;
      $message = $message ." Product_Id ".$Product_Id;
      
      while ($row = $result->fetch_assoc()) {
         //`$list_clumens = array_keys($row);
         $Shop_workers = $row['Shop_workers'];
         $message = $message ." Shop_workers ".$Shop_workers;
         $Shop_item_info = explode("~", $Shop_workers);
         
         $Shop_workers_list = json_decode($Shop_item_info[1]);   
         $message = $message ." Shop_raters ".json_encode($Shop_raters);
         //$Shop_raters = loadList($Shop_item_info[1]);
         $found = 0;
         $sum_of_all_rated = count($Shop_workers_list);
         for ($i=0; $i < count($Shop_workers_list); $i++) { 
            if($Shop_workers_list[$i][1] == $Product_Id){
               $found = 1;
               $Shop_workers_list[$i][0] = $User_Id;
               $Shop_workers_list[$i][2] = date('d-m-Y');
            }
         }
         if($found == 0) {
            $message = $message ." raternot found creating new one ";
            array_push($Shop_workers_list, [$User_Id,  $Product_Id, date('d-m-Y')]);
            $sum_of_all_rated++;
         }
         
         $count = $_SESSION['Users_length'];
         $average = $sum_of_all_rated / $count;
         $rating_value = number_format($average, 1);
         $message = $message ." Shop_workers_list ".json_encode($Shop_workers_list);
         $New_Shop_workers = $rating_value.'~'.json_encode($Shop_workers_list);
         $message = $message ." New_Shop_workers ".$New_Shop_workers;
         if($_SESSION['Selected_Shop']['Shop_workers']) $_SESSION['Selected_Shop']['Shop_workers'] = $New_Shop_items;
         $sql = "UPDATE `shops` SET `Shop_items`='$New_Shop_items' WHERE Shop_Id = '$Company_Id'";
         if ($conn->query($sql) === TRUE) $message .= "New product added successfully.";
         else $message .= "Error: " . $sql . "<br>" . $conn->error;
         //$conn->close();
      }
   }
}
else if(isset($_POST['Followe_Company'])){
   $message = $message." in Followe_Company";
   $main_p = dirname(dirname(getcwd())); // ../../ to go back to main path from server/company
   $Company_Id = $_POST['Company_Id'];
   $User_Id = $_POST['User_Id'];

   $is_User_Follow = $_POST['User_Followe'];
   $message = $message ." Company_Id ".$Company_Id;

   $result = $conn->query("SELECT * FROM shops WHERE Shop_Id='$Company_Id'");
   if ($result->num_rows > 0) {
      //$fetch = $result->fetch_assoc();
      $message = $message ." User_Id ".$User_Id;
      $message = $message ." is_User_Follow ".$is_User_Follow;
      
      while ($row = $result->fetch_assoc()) {
         //`$list_clumens = array_keys($row);
         $Shop_follower_infos = $row['Shop_followers'];
         $message = $message ." Shop_follower ".$Shop_follower_infos;
         $Shop_follower_info = explode("~", $Shop_follower_infos);
         
         $Shop_followerrs = json_decode($Shop_follower_info[1]);   
         $message = $message ." Shop_followerrs ".json_encode($Shop_followerrs);
         //$Shop_followerrs = loadList($Shop_follower_info[1]);
         $found = 0;
         $count = count($Shop_followerrs);
         for ($i=0; $i < $count; $i++) { 
            if($Shop_followerrs[$i][0] == $User_Id){
               $found = 1;
               $Shop_followerrs[$i][1] = $is_User_Follow;
               $Shop_followerrs[$i][2] = date('d-m-Y');
            }
         }
         if($found == 0) {
            $message = $message ." raternot found creating new one ";
            array_push($Shop_followerrs, [$User_Id,  $is_User_Follow, date('d-m-Y')]);
            $count++;
         }
         $message = $message ." Shop_followerrs ".json_encode($Shop_followerrs);
         $New_Shop_follower = $count.'~'.json_encode($Shop_followerrs);
         $message = $message ." New_Shop_follower ".$New_Shop_follower;
         $sql = "UPDATE `shops` SET `Shop_followers`='$New_Shop_follower' WHERE Shop_Id = '$Company_Id'";
         if ($conn->query($sql) === TRUE) $message .= "New product added successfully.";
         else $message .= "Error: " . $sql . "<br>" . $conn->error;

         if($_SESSION['Selected_Shop']['Shop_followers']) $_SESSION['Selected_Shop']['Shop_followers'] = $New_Shop_follower;
      }
   }
}
else if(isset($_POST['Rate_Company'])){
   $message = $message." in Rate_Company";
   $main_p = dirname(dirname(getcwd())); // ../../ to go back to main path from server/company
   $Company_Id = $_POST['Company_Id'];
   $User_Id = $_POST['User_Id'];

   $User_rated = $_POST['User_rated'];
   $message = $message ." Company_Id ".$Company_Id;

   $result = $conn->query("SELECT * FROM shops WHERE Shop_Id='$Company_Id'");
   if ($result->num_rows > 0) {
      //$fetch = $result->fetch_assoc();
      $message = $message ." User_Id ".$User_Id;
      $message = $message ." User_rated ".$User_rated;
      
      while ($row = $result->fetch_assoc()) {
         //`$list_clumens = array_keys($row);
         $Shop_rate = $row['Shop_rate'];
         $message = $message ." Shop_rate ".$Shop_rate;
         $Shop_rate_info = explode("~", $Shop_rate);
         
         $Shop_raters = json_decode($Shop_rate_info[1]);   
         $message = $message ." Shop_raters ".json_encode($Shop_raters);
         //$Shop_raters = loadList($Shop_rate_info[1]);
         $found = 0;
         $sum_of_all_rated = 0;
         for ($i=0; $i < count($Shop_raters); $i++) { 
            if($Shop_raters[$i][0] == $User_Id){
               $found = 1;
               $Shop_raters[$i][1] = $User_rated;
               $Shop_raters[$i][2] = date('d-m-Y');
            }
            $sum_of_all_rated += $Shop_raters[$i][1];
         }
         if($found == 0) {
            $message = $message ." raternot found creating new one ";
            array_push($Shop_raters, [$User_Id,  $User_rated, date('d-m-Y')]);
            $sum_of_all_rated += $User_rated;
         }
         $count = $_SESSION['Users_length'];
         $average = $sum_of_all_rated / $count;
         $rating_value = number_format($average, 1);
         $message = $message ." Shop_raters ".json_encode($Shop_raters);
         $New_Shop_rate = $rating_value.'~'.json_encode($Shop_raters);
         $message = $message ." New_Shop_rate ".$New_Shop_rate;
         $sql = "UPDATE `shops` SET `Shop_rate`='$New_Shop_rate' WHERE Shop_Id = '$Company_Id'";
         if ($conn->query($sql) === TRUE) $message .= "New product added successfully.";
         else $message .= "Error: " . $sql . "<br>" . $conn->error;
         if($_SESSION['Selected_Shop']['Shop_rate']) $_SESSION['Selected_Shop']['Shop_rate'] = $New_Shop_rate;
         //$conn->close();
      }
   }
}

//$values = ['id', 'name', 'code', 'type', 'barcode', 'at_shop', 'quantity', 'cost', 'tax', 'price', 'include_tax', 'price_change', 'more_info', 'images', 'description', 'service', 'default_quantity', 'active'];
//$shops_columens = ['Shop_Id', 'Shop_name', 'Shop_brand_name', 'shop_type', 'Shop_oweners_id', 'Shop_linke', 'shop_email', 'shop_phone_no', 'Shop_location', 'Shop_about', 'Shop_rate', 'Shop_likes', 'Shop_followers', 'Shop_items', 'Shop_workers', 'Shop_password', 'Shop_contry', 'Shop_settings', 'Shop_Page', 'Shop_profile_img', 'Shop_banner_imgs', 'Shop_payment_r', 'Shop_balance', 'Shop_payment_info', 'Shop_isenable'];
// Create the response array
$response = array(
  'message' => $message,
  'items' => $items,
  'result' => $result,
  'image_path' => $image_path,
  'Shop_rate' => $New_Shop_rate,
  'payment_tools' => $allshopPaymentTools,
  'allshopworkers' => $allshopworkers
);

// Encode the response array as JSON
$jsonResponse = json_encode($response);

// Close the database connection
$conn->close();

// Echo the JSON response
echo $jsonResponse;
?>
