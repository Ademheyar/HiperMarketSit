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
if(session_id() == "") { session_start(); } 

$message = "";
$image_path = "";
$New_Shop_rate="";

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
  "image_path" => $image_path,
  "Shop_rate" => $New_Shop_rate
);

// Encode the response array as JSON
$jsonResponse = json_encode($response);

// Close the database connection
$conn->close();

// Echo the JSON response
echo $jsonResponse;
?>
