<?php

  if(file_exists("config.php")) include("config.php");
  if(file_exists("Template/Actions/List.php")) include("Template/Actions/List.php");

  if(file_exists("../config.php")) include("../config.php");
  if(file_exists("../Template/Actions/List.php")) include("../Template/Actions/List.php");

  if(file_exists("../../config.php")) include("../../config.php");
  if(file_exists("../../Template/Actions/List.php")) include("../../Template/Actions/List.php");

  if(file_exists("../../../config.php")) include("../../../config.php");
  if(file_exists("../../../Template/Actions/List.php")) include("../../../Template/Actions/List.php");

  if(file_exists("../../../../config.php")) include("../../../../config.php");
  if(file_exists("../../../../Template/Actions/List.php")) include("../../../../Template/Actions/List.php");
// PHP code
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(session_id() == "") { session_start(); } 

$message = "";
$image_path = "";
$New_Shop_rate="";
$Shop_Page_list = [];
$TEST = [];
$TEST0 = [];
$TEST1 = "";
if(isset($_POST['Add_New_Page_Info'])){
   $message = $message." in Add_New_Page_Info";
   $btns = ["ITEMS", "BANNERS", "SHOPS", "COLLECTIONS"];
   $Company_Id = $_SESSION['Selected_Shop']['Shop_Id'];
   $Index = $_POST['Index'];
   $Add_Item_of = $_POST['Add_Item_of'];

   $result = $conn->query("SELECT * FROM shops WHERE Shop_Id='$Company_Id'");
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         //`$list_clumens = array_keys($row);
         $Shop_Page = $row['Shop_Page'];
         $message = $message ." Add_Item_of ".$Add_Item_of;
         $message = $message ." Shop_Page ".$Shop_Page;
         $Shop_Page_list = json_decode($Shop_Page); 
         $message = $message ." Index ".$Index;
         if($Shop_Page_list){
            $nl = [[$Add_Item_of, 0,'70%', '', 0, $Add_Item_of, '']];
            array_splice($Shop_Page_list, (int)$Index, 0, $nl);
            $New_Shop_Page = json_encode($Shop_Page_list);
            $message = $message ." New_Shop_Page ".$New_Shop_Page;
            
            $sql = "UPDATE `shops` SET `Shop_Page`='$New_Shop_Page' WHERE Shop_Id = '$Company_Id'";
            if ($conn->query($sql) === TRUE) $message .= "New product added successfully.";
            else $message .= "Error: " . $sql . "<br>" . $conn->error;
            if($_SESSION['Selected_Shop']['Shop_Page']) $_SESSION['Selected_Shop']['Shop_Page'] = $New_Shop_Page;
           
         }
      }
   }
}
else if(isset($_POST['Remove_Page_Info'])){
   $message = $message." in Remove_Page_Info";
   $btns = ["ITEMS", "BANNERS", "SHOPS", "COLLECTIONS"];
   $Company_Id = $_SESSION['Selected_Shop']['Shop_Id'];
   $Index = $_POST['Index'];
   $Add_Item_of = $_POST['Add_Item_of'];

   $result = $conn->query("SELECT * FROM shops WHERE Shop_Id='$Company_Id'");
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         //`$list_clumens = array_keys($row);
         $Shop_Page = $row['Shop_Page'];
         $message = $message ." Add_Item_of ".$Add_Item_of;
         $message = $message ." Shop_Page ".$Shop_Page;
         $Shop_Page_list = json_decode($Shop_Page); 
         $message = $message ." Index ".$Index;
         if($Shop_Page_list){
            $nl = [[$Add_Item_of, 0,'70%', '', 0, $Add_Item_of, '']];
            array_splice($Shop_Page_list, (int)$Index, 1);
            $New_Shop_Page = json_encode($Shop_Page_list);
            $message = $message ." New_Shop_Page ".$New_Shop_Page;
            
            $sql = "UPDATE `shops` SET `Shop_Page`='$New_Shop_Page' WHERE Shop_Id = '$Company_Id'";
            if ($conn->query($sql) === TRUE) $message .= "New product added successfully.";
            else $message .= "Error: " . $sql . "<br>" . $conn->error;
            if($_SESSION['Selected_Shop']['Shop_Page']) $_SESSION['Selected_Shop']['Shop_Page'] = $New_Shop_Page;
           
         }
      }
   }
}
else if(isset($_POST['move_Page_Info'])){
   $message = $message." in move_Page_Info";
   $btns = ["ITEMS", "BANNERS", "SHOPS", "COLLECTIONS"];
   $Company_Id = $_SESSION['Selected_Shop']['Shop_Id'];
   $Index = $_POST['Index'];
   $Add_Item_of = $_POST['Add_Item_of'];

   $result = $conn->query("SELECT * FROM shops WHERE Shop_Id='$Company_Id'");
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         //`$list_clumens = array_keys($row);
         $Shop_Page = $row['Shop_Page'];
         $message = $message ." Add_Item_of ".$Add_Item_of;
         $message = $message ." Shop_Page ".$Shop_Page;
         $Shop_Page_list = json_decode($Shop_Page); 
         $message = $message ." Index ".$Index;
         if($Shop_Page_list){
            $nl = [$Shop_Page_list[(int)$Index]];
            array_splice($Shop_Page_list, (int)$Index, 1);
            if($Add_Item_of == "Move Up") array_splice($Shop_Page_list, (int)$Index-1, 0, $nl);
            else if($Add_Item_of == "Move Down") array_splice($Shop_Page_list, (int)$Index+1, 0, $nl);
            $New_Shop_Page = json_encode($Shop_Page_list);
            $message = $message ." New_Shop_Page ".$New_Shop_Page;
            
            $sql = "UPDATE `shops` SET `Shop_Page`='$New_Shop_Page' WHERE Shop_Id = '$Company_Id'";
            if ($conn->query($sql) === TRUE) $message .= "New product added successfully.";
            else $message .= "Error: " . $sql . "<br>" . $conn->error;
            if($_SESSION['Selected_Shop']['Shop_Page']) $_SESSION['Selected_Shop']['Shop_Page'] = $New_Shop_Page;
           
         }
      }
   }
}
else if(isset($_POST['Save_Page_Info'])){
   $message = $message." in Save_Page_Info";
   $btns = ["ITEMS", "BANNERS", "SHOPS", "COLLECTIONS"];
   $Company_Id = $_SESSION['Selected_Shop']['Shop_Id'];
   $Index = $_POST['Index'];
   $Add_Item_of = $_POST['Add_Item_of'];
   $jsonsetteing_data = $_POST['setteing_data'];

   $setteing_data = json_decode($jsonsetteing_data);

   $result = $conn->query("SELECT * FROM shops WHERE Shop_Id='$Company_Id'");
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         //`$list_clumens = array_keys($row);
         $Shop_Page = $row['Shop_Page'];
         $TEST0 = $setteing_data->data;
         $message = $message ." Add_Item_of ".$Add_Item_of;
         $message = $message ." Shop_Page ".$Shop_Page;
         $Shop_Page_list = json_decode($Shop_Page); 
         $message = $message ." Index ".$Index;
         if($Shop_Page_list){
            $nl = [$setteing_data->data];
            array_splice($Shop_Page_list, (int)$Index, 1);
            array_splice($Shop_Page_list, (int)$Index, 0, $nl);
            $New_Shop_Page = json_encode($Shop_Page_list);
            $message = $message ." New_Shop_Page ".$New_Shop_Page;
            
            $sql = "UPDATE `shops` SET `Shop_Page`='$New_Shop_Page' WHERE Shop_Id = '$Company_Id'";
            if ($conn->query($sql) === TRUE) $message .= "New product added successfully.";
            else $message .= "Error: " . $sql . "<br>" . $conn->error;
            if($_SESSION['Selected_Shop']['Shop_Page']) $_SESSION['Selected_Shop']['Shop_Page'] = $New_Shop_Page;
           
         }
      }
   }
}

//$values = ['id', 'name', 'code', 'type', 'barcode', 'at_shop', 'quantity', 'cost', 'tax', 'price', 'include_tax', 'price_change', 'more_info', 'images', 'description', 'service', 'default_quantity', 'active'];
//$shops_columens = ['Shop_Id', 'Shop_name', 'Shop_brand_name', 'shop_type', 'Shop_oweners_id', 'Shop_linke', 'shop_email', 'shop_phone_no', 'Shop_location', 'Shop_about', 'Shop_rate', 'Shop_likes', 'Shop_followers', 'Shop_items', 'Shop_workers', 'Shop_password', 'Shop_contry', 'Shop_settings', 'Shop_Page', 'Shop_profile_img', 'Shop_banner_imgs', 'Shop_payment_r', 'Shop_balance', 'Shop_payment_info', 'Shop_isenable'];
// Create the response array
$response = array(
  'message' => $message,
  "image_path" => $image_path,
  "Shop_rate" => $New_Shop_rate,
  "Shop_Page_list" => $Shop_Page_list,
  "TEST" => $TEST,
  "TEST0" => $TEST0,
  "TEST1" => $TEST1
);

// Encode the response array as JSON
$jsonResponse = json_encode($response);

// Close the database connection
$conn->close();

// Echo the JSON response
echo $jsonResponse;
?>
