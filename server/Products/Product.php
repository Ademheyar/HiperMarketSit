<?php
session_start();
// Your database connection script

// Enable error reporting for development

  if(file_exists("config.php")) include("config.php");
  if(file_exists("../config.php")) include("../config.php");
  if(file_exists("../../config.php")) include("../../config.php");
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
    if (session_id() == "") session_start();
    $message = [];
    $result = [];

    if(isset($_POST['Search_Same_Query'])){
      $query = $_POST['Search_Query_value'];
      $search_what = $_POST['search_what'];

        for($s = 0; $s < count($_SESSION['User_Shops']); $s++){
          $Shop = $_SESSION['User_Shops'][$s];
          $Company_Id = $Shop['Shop_Id'];
          $Company_result = $conn->query("SELECT * FROM shops WHERE Shop_Id='$Company_Id'");
          if ($Company_result->num_rows > 0) {
            while ($row = $Company_result->fetch_assoc()) {
              //`$list_clumens = array_keys($row);
              $Shop_items = $row['Shop_items'];
              $Shop_item_info = explode("~", $Shop_items);
              
              $Shop_items_list = json_decode($Shop_item_info[1]); 
              $count = count($Shop_items_list);
              for ($i=0; $i < $count; $i++) {
                $Product_Id = $Shop_items_list[$i][1];
                if ($Company_result->num_rows > 0) {
                  $ITEM_result = $conn->query("SELECT * FROM products WHERE id='$Product_Id'");
                  $item_found = 0;
                  while ($ITEM_ROW = $ITEM_result->fetch_assoc()) {
                    if($search_what === "") $result[] = $ITEM_ROW;
                    else if ($search_what === "ID" && $ITEM_ROW['id'] === $query) $result[] = $ITEM_ROW;
                  }
                }
              }
            }
          }
      }
    }

    else if(isset($_POST['Search_Like_Query'])){
      $query = $_POST['Search_Query_value'];
      $search_what = $_POST['search_what'];
      if(($search_what == "" || $search_what == "USER")){
          $User_result = $conn->query("SELECT * FROM users");
          $user_found = 0;
          while ($USER_ROW = $User_result->fetch_assoc()) {
            $User_colums = array_keys($USER_ROW);
            for ($j=0; $j < count($User_colums); $j++) { 
              $hedertext = $User_colums[$j];
              if(strpos(strtolower($USER_ROW[$hedertext]), strtolower($query))) { $user_found = 1; break; }
            }
            if($user_found) $result[] = ["USER", $USER_ROW];
          }
      }

      if(($search_what == "" || $search_what == "ITEM") && isset($_SESSION['User_Shops']))
      {
        //$result = ["122"];
        //$result = $_SESSION['User_Shops_info'];
        //$result = json_decode($_SESSION['User_Shops_info']);
        //$result = $_SESSION['User_Shops'];
        for($s = 0; $s < count($_SESSION['User_Shops']); $s++){
          $Shop = $_SESSION['User_Shops'][$s];
          $Company_Id = $Shop['Shop_Id'];
          $Company_result = $conn->query("SELECT * FROM shops WHERE Shop_Id='$Company_Id'");
          if ($Company_result->num_rows > 0) {
            while ($row = $Company_result->fetch_assoc()) {
              //`$list_clumens = array_keys($row);
              $Shop_items = $row['Shop_items'];
              $Shop_item_info = explode("~", $Shop_items);
              
              $Shop_items_list = json_decode($Shop_item_info[1]); 
              $count = count($Shop_items_list);
              for ($i=0; $i < $count; $i++) {
                $Product_Id = $Shop_items_list[$i][1];
                if ($Company_result->num_rows > 0) {
                  $ITEM_result = $conn->query("SELECT * FROM products WHERE id='$Product_Id'");
                  $item_found = 0;
                  while ($ITEM_ROW = $ITEM_result->fetch_assoc()) {
                    $ITEM_colums = array_keys($ITEM_ROW);
                    for ($j=0; $j < count($ITEM_colums); $j++) { 
                      $hedertext = $ITEM_colums[$j];
                      if(strpos(strtolower($ITEM_ROW[$hedertext]), strtolower($query))) { $item_found = 1; break; }
                    }
                    if($item_found) $result[] = ["ITEM", $ITEM_ROW];
                  }
                }
              }
            }
          }
        }
      }
    }

    else if(isset($_POST['add'])){
        $message[] =  "Going to do add";
        $main_p = getcwd();
        $main_ps = "{$main_p}/Img/Items/";
        // Create the new path
        if (!is_dir($main_ps)) {
            mkdir($main_ps, 0777, true);
        }
        $jsonimage_names = $_POST['dataobject'];
        $namesobject = 0;
        if ($jsonimage_names) $namesobject = json_decode($jsonimage_names);
        
        $new_names = "";
        $rename_images = ""; 
        $delet_image = ""; 
        if ($namesobject) {
            $new_names = $namesobject->names;
            $rename_images = $namesobject->rename_images; 
            $delet_image = $namesobject->delet_image; 
        }
        
        
        $update_p_id = -1;
        if(isset($_POST['p_id'])) $update_p_id = $_POST['p_id'];
        
        
        $p_name = "";
        if(isset($_POST['new_p_name'])) $p_name = $new_p_name = $_POST['new_p_name'];
        
        $p_code = "";
        if(isset($_POST['new_p_code'])) $p_code = $new_p_code = str_replace('#', '', str_replace(' ', '_', $_POST['new_p_code']));
        
        $p_type = "";
        if(isset($_POST['new_p_type'])) $p_type = $new_p_type = $_POST['new_p_type'];
        
        $p_barcode = "";
        if(isset($_POST['p_barcode'])) $p_barcode = $_POST['p_barcode'];
        //$p_shop = ""; TODO: what if it is update
        $p_qty = intval(0); //TODO: how what to fill this 
        
        $p_price_cost = 0;
        if(isset($_POST['p_price_cost'])) $p_price_cost = intval($_POST['p_price_cost']);
        
        $p_markup = 0;
        if(isset($_POST['p_markup'])) $p_markup = intval($_POST['p_markup']);
        
        $p_sale_price = 0;
        if(isset($_POST['p_price_sale'])) $p_sale_price = $_POST['p_price_sale'];
        
        $p_include_tax = 0;
        if(isset($_POST['p_include_tax'])) $p_include_tax = intval(isset($_POST['p_include_tax']));
        
        $p_change_allowed = 0;
        if(isset($_POST['p_change_allowed'])) $p_change_allowed = intval(isset($_POST['p_change_allowed']));
        
        $p_info = "";
        if(isset($_POST['p_more_info'])) $p_info = $_POST['p_more_info'];
        $message[] = json_decode($p_info, true);
        
        $p_img_names = "";
        if(isset($_POST['p_img_names'])) $p_img_names = $_FILES['p_image']['IMG_NAME'];// $_POST['p_img_names'];
        
        $p_disc = "";
        if(isset($_POST['p_disc'])) $p_disc = $_POST['p_disc'];
        
        $p_Service = 0;
        if(isset($_POST['p_Service'])) $p_Service = intval(isset($_POST['p_Service']));
        
        $p_Def_qty = 0;
        if(isset($_POST['p_Def_qty'])) $p_Def_qty = intval(isset($_POST['p_Def_qty']));
        
        $p_active = 1;
        if(isset($_POST['p_active'])) $p_active = intval(isset($_POST['p_active']));

       //'$p_include_tax' p_Def_qty 
       //$update_query = mysqli_query($conn, "UPDATE `products`(name, code, type, barcode, cost, tax, price, include_tax, price_change, image, more_info, Service, Default_Quantity, Active) VALUES('$p_name', '$p_code', '$p_type', '$p_barcode', '$p_price_cost', '$p_markup' , '$p_sale_price', '$p_include_tax', '$p_change_allowed', '$p_image', '$p_info', '$p_Service', '$p_Def_qty', '$p_active')") or die('query failed');
       
       if (isset($_POST['product_do']) && $_POST['product_do'] == 'Update product') {
          // Check if any fields have changed
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             // Validate the data
             
             if (empty($p_name)) echo "Please fill in all required fields.";
             else {
                // Connect to the database
                if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
                else{
                   // Insert the new product into the database
                   //$sql = "UPDATE `products` SET `name`='$p_name', `code`='$p_code', `type`='$p_type', `barcode`='$p_barcode', `at_shop`='$p_shop', `quantity`=$p_qty, `cost`=$p_price_cost, `tax`=$p_markup, `price`=$p_sale_price, `include_tax`=$p_include_tax, `price_change`=$p_change_allowed, 
                   $sql = "UPDATE `products` SET `name`='$p_name', `code`='$p_code', `type`='$p_type', `barcode`='$p_barcode', `quantity`=$p_qty, `cost`=$p_price_cost, `tax`=$p_markup, `price`=$p_sale_price, `include_tax`=$p_include_tax, `price_change`=$p_change_allowed, 
                   `more_info`='$p_info', `images`='$p_img_names', `Description`='$p_disc', `Service`=$p_Service, `Default_Quantity`=$p_Def_qty, `Active`=$p_active";
                   $sql .= " WHERE id = '$update_p_id'";
                   $result = $conn->query($sql);
                   if ($result === TRUE) $message[] =  "New product added successfully.";
                   else $message[] =  "Error: " . $sql . "<br>" . $conn->error;
                   //$conn->close();
                }
             }
          }
          
       }
       else if (isset($_POST['product_do']) && $_POST['product_do'] == 'Add product') {
          // Insert the product and display a success message
          // Check if the form has been submitted
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             // Validate the data
             
             if (empty($p_name)) echo "Please fill in all required fields.";
             else {
                // Connect to the database
                if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
                else{
                  $Date = date('d-m-Y');
                  if(isset($_SESSION['User_Shops'])) {
                    for($key = 0; $key < count($_SESSION['User_Shops']); $key++){
                      $Shop = $_SESSION['User_Shops'][$key];
                      $new_p_shop_id = $Shop['Shop_Id'];
                      $Shop_items = json_decode($Shop['Shop_items']);
                    if(isset($_SESSION['selected_company_id']) && $_SESSION['selected_company_id'] != -1 && $key != $_SESSION['selected_company_id']) continue;
                    
                   // Insert the new product into the database
                   $sql = "INSERT INTO `products`(`name`, `code`, `type`, `barcode`, `at_shop`, `quantity`, `cost`, `tax`, `price`, `include_tax`, `price_change`, `more_info`, `images`, `Description`, `Service`, `Default_Quantity`, `Active`) VALUES 
                   ('$p_name','$p_code', '$p_type', '$p_barcode', '$new_p_shop_id', $p_qty, $p_price_cost, $p_markup, $p_sale_price, $p_include_tax, $p_change_allowed, '$p_info', '$p_img_names', '$p_disc', $p_Service, $p_Def_qty, $p_active)";
                   
                   $result = $conn->query($sql);
                   if ($result === TRUE) {
                     $Shop_items[] = ["", '$result->mysql_insert_id()', $Date, $Date];
                     echo json_encode(['key' => $key, 'sql' => $sql, 'selected_company_id' => $_SESSION['selected_company_id'], 'message' => 'An unexpected error occurred.']);
                exit();
                     $update_query = "UPDATE shops SET Shop_items = '".json_encode($Shop_items)."' WHERE Shop_Id = ".$row['User_id'];
                     $upload_user_result = mysqli_query($conn, $update_query);
                    if ($upload_user_result){
                            $message[] =  "New product added to ".$new_p_shop." shop successfully.";
                    } 
                      
                      /*$newly_added_item = mysqli_fetch_assoc($result);
                      $update_p_id = $newly_added_item['id'];*/
                   }
                   else $message[] =  "Error: " . $sql . "<br>" . $conn->error;
                   //$conn->close();
                      
                  
                      
                  }
                }
             }
             }
          }
       } 

        $message[] =  "main_ps : ".$main_ps;
       /*

       
    
       //$insert_query = mysqli_query($conn, "INSERT INTO `products`(name, code, type, barcode, cost, tax, price, include_tax, price_change, images, more_info, Description, Service, Default_Quantity, Active) VALUES('$p_name', '$p_code', '$p_type', '$p_barcode', '$p_price_cost', '$p_markup' , '$p_sale_price', '$p_include_tax', '$p_change_allowed', '$p_img_names', '$p_info', '$p_disc', '$p_Service', '$p_Def_qty', '$p_active')") or die('query failed');
       if(isset($_FILES['p_image']))
       {
          $image = $_FILES['p_image'];
          for ($i=0; $i < count($image['tmp_name']); $i++) { 
             if (isset($image['tmp_name'][$i]) && !empty($image['tmp_name'][$i])) {
                $filename = basename($image['name'][$i]);
                $new_filename = "";
                for ($j=0; $j < count($new_names); $j++) { 
                   if ($new_names[$j][0] == $image['name'][$i] && $new_names[$j][2] == 0) {
                      $new_names[$j][2] = 1;
                      $new_filename = $new_names[$j][1];
                      break;
                   }
                }
                $newFilePath = $main_ps.$new_filename;
                $tmpName = $image['tmp_name'][$i];
                // Generate unique filename and move file to upload directory
                if($tmpName != ""){
                   if(move_uploaded_file($tmpName, $newFilePath)){
                      $message[] = "File uploaded successfully: ".$newFilePath;
                   }  
                }
             }
          }
       }
    
       foreach($rename_images as $rename_info){
          $old_name = $rename_info[0];
          $new_name = $rename_info[1];
    
          rename($main_ps.$old_name, $main_ps.$new_name);
       }
       foreach($delet_image as $delete_img_info){
          if(file_exists($main_ps.$delete_img_info)){
             unlink($main_ps.$delete_img_info);
          }
       }
    }
    
    else if(isset($_POST['delete-btn'])){
       $delete_id = $_POST['p_id'];;
       $delete_query = mysqli_query($conn, "DELETE FROM `products` WHERE id = $delete_id ") or die('query failed');
       if($delete_query){
          $message[] = 'product has been deleted';
       }else{
          $message[] = 'product could not be deleted';
       };*/
    }

    //$values = ['id', 'name', 'code', 'type', 'barcode', 'at_shop', 'quantity', 'cost', 'tax', 'price', 'include_tax', 'price_change', 'more_info', 'images', 'description', 'service', 'default_quantity', 'active'];
    //$shops_columens = ['Shop_Id', 'Shop_name', 'Shop_brand_name', 'shop_type', 'Shop_oweners_id', 'Shop_linke', 'shop_email', 'shop_phone_no', 'Shop_location', 'Shop_about', 'Shop_rate', 'Shop_likes', 'Shop_followers', 'Shop_items', 'Shop_workers', 'Shop_password', 'Shop_contry', 'Shop_settings', 'Shop_Page', 'Shop_profile_img', 'Shop_banner_imgs', 'Shop_payment_r', 'Shop_balance', 'Shop_payment_info', 'Shop_isenable'];
    //[`document_id`, `document_barcode`, `documents_extension_barcode`, `user_id`, `customer_id`, `document_type`, `item`, `qty`, `price`, `discount`, `tax`, `payments`, `document_created_date`, `document_expire_date`, `document_updated_date`]
    // Create the response array

    $response = array(
    'message' => $message,
    'result' => $result
    );

    // Encode the response array as JSON
    $jsonResponse = json_encode($response);

    // Close the database connection
    $conn->close();

    // Echo the JSON response
    echo $jsonResponse;
?>