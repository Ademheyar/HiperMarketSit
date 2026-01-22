<?php
if (session_id() == "") session_start();
if(file_exists("config.php")) include("config.php");
  if(file_exists("../../config.php")) include("../../config.php"); // Your database connection script

// Enable error reporting for development
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
    echo json_encode(['status' => 'Exception', 'message' => 'An unexpected error occurred.'.$error_message]);
    exit();
}

set_exception_handler('customExceptionHandler');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['Create_New_Shop'])) {
          $register_sname = $_POST['register_sname'];

          $register_bname = $_POST['register_bname'];
          $register_type = $_POST['register_type'];
          $register_email = $_POST['register_email'];
          $Shop_contact = json_encode(["Phone Number : ".$_POST['register_phone_No']]);
          $register_location = json_encode(["Location : ".$_POST['register_location'], "Contry : ".$_POST['register_country']]);
          $register_password = $_POST['register_password'];
          $register_oweners_id = $_SESSION['loged_user_info']['User_id'];
          $Company_Started_Date = date('d-m-Y');
          $shop_page = json_encode([["BANNERS",0,"100%","50%",0,"BANNERS",""],["COLLECTIONS",0,"100%","25%",0,"COLLECTIONS",""],["Shop Sell",1,"","",0,"ITEMS",""],["New Arrival",1,"","",0,"ITEMS",""],["Special",1,"","",0,"ITEMS",""],["Collection",1,"","",0,"ITEMS",""],["Products",1,"100%","70%",1,"ITEMS",""]]);
         
          $Shop_rate = json_encode([]);
          $Shop_items = json_encode([]);
          $Shop_followers = json_encode([]);
          $Shop_workers = json_encode([]);
          $Shop_Payment_Tools = json_encode([]);
          $Shop_about = "New Shop No Bio";
          //$_SESSION['loged_user_info']['User_work_shop']
          // Establish your database connection here, e.g., $conn = mysqli_connect(...);
      
          $insert_query = "INSERT INTO `shops`(`Shop_name`, `Shop_brand_name`, `Shop_oweners_id`, `shop_type`, `Shop_location`, `shop_email`, `Shop_contact`, `Shop_password`, `Shop_Page`, `Shop_rate`, `Shop_items`, `Shop_followers`, `Shop_workers`,  `Shop_Payment_Tools`, `Shop_about`, `Company_Started_Date`) 
                  VALUES ('$register_sname','$register_bname','$register_oweners_id','$register_type','$register_location','$register_email','$Shop_contact','$register_password', '$shop_page', '$Shop_rate', '$Shop_items', '$Shop_followers', '$Shop_workers', '$Shop_Payment_Tools', '$Shop_about', '$Company_Started_Date')";


        $insert_result = mysqli_query($conn, $insert_query);
        if ($insert_result) {
          $newly_inserted_id = mysqli_insert_id($conn);
          $shop_info = [$newly_inserted_id, $register_sname, $register_bname, "10", "1"];    
          $user_shops = json_decode($_SESSION['loged_user_info']['User_work_shop']) ?? [];
          $user_shops[] = $shop_info;
          $update_query = "UPDATE users SET User_work_shop ='".json_encode($user_shops)."' WHERE User_id = ".$_SESSION['loged_user_info']['User_id'];

          $upload_info_result = mysqli_query($conn, $update_query);
          $_SESSION['loged_user_info']['user_shops'] = json_encode($user_shops);
          $_SESSION['loged_user_info']['User_work_shop'] = json_encode($user_shops);
          
          if($upload_info_result) echo json_encode(['status' => 'Success', 'Success' => json_encode($user_shops), 'message' => 'New shop added successfully!']);
          else echo json_encode(['status' => 'Error', 'insert_result' => $insert_result, 'message' => 'Document update Failed! '.$conn->error]);
        } 
        else echo json_encode(['status' => 'Error', $insert_query => $insert_result, 'message' => "Failed ".$conn->error]);
          // shop id, is enabled, activity
      }
      
      if (isset($_POST['request_worker'])) {
          if (session_id() == "") session_start();
          $main_p = getcwd();
          $get_name = $_POST['get_name'];
          $get_email = $_POST['get_email'];
          $get_phone_no = $_POST['get_phone_No'];
          $get_link = $_POST['get_link'];
          if($get_link != ""){
            
          } else {
            $sql = "SELECT * FROM users WHERE user_name='".$get_name."' AND user_email='".$get_email."' AND user_phone_No='".$get_phone_no."'";
            // Execute the query
           $result = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
              $newly_inserted_id = $_SESSION['Selected_Shop']['Shop_Id'];
              $shop_info = "";
              if ($row['User_work_shop'] != "") {
                $work_shop_infos = explode("~", $row['User_work_shop']);
                echo($work_shop_infos[1]); 
                $work_shop_l = json_decode($work_shop_infos[1]);
                $work_shop_l[] = [$newly_inserted_id, 0, [0]];
                $shop_info = count($work_shop_l)."~".json_encode($work_shop_l);
              }
              else $shop_info = "1~[[$newly_inserted_id, 0, [0]]]";
      
              $update_query = "UPDATE users SET User_work_shop = '".$shop_info."' WHERE User_id = ".$row['User_id'];
              $upload_user_result = mysqli_query($conn, $update_query) or die('Failed to update user: ' . mysqli_error($conn));
      
              if ($upload_user_result){
                $workers_s = "";
                if ($_SESSION['Selected_Shop']['Shop_workers'] != "") {
                  $workers_infos = explode("~", $_SESSION['Selected_Shop']['Shop_workers']);
                  echo($workers_infos[1]); 
                  $workers_l = json_decode($workers_infos[1]);
                  $workers_l[] = [$row['User_id'], 1, [0]];
                  $workers_s = count($workers_l)."~".json_encode($workers_l);
                }
                else $workers_s = "1~[[".$row['User_id'].", 1, [0]]]";
      
                $update_shop_query = "UPDATE Shops SET Shop_workers ='".$workers_s."' WHERE Shop_Id = ".$newly_inserted_id;
                $upload_shop_result = mysqli_query($conn, $update_shop_query) or die('Failed to update shop: ' . mysqli_error($conn));
                $_SESSION['Selected_Shop']['Shop_workers'] = $workers_s;
              }
            }
          }else echo "Failed to get new item";
        }
      };
      
      if(isset($_GET['delete_shop']) && isset($_GET['register_shop_id'])){
          $delete_id = $_GET['register_shop_id']; 
          $delete_query = mysqli_query($conn, "DELETE FROM `Shops` WHERE Shop_Id =" . $delete_id) or die('query failed ' . $delete_id);
          if($delete_query){
              $message[] = 'Shop has been deleted';
          }else{
              $message[] = 'Shop could not be deleted';
          }
      }
      
      if(isset($_GET['enabl_or_disable_shop']) && isset($_GET['register_enabl_or_disable']) && isset($_GET['register_shop_id'])){
            $enabl_or_disable = $_GET['register_enabl_or_disable']; 
            $shop_id = $_GET['register_shop_id']; 
            $update_query = mysqli_query($conn, "UPDATE `Shops` SET `Shop_isenabled`=".$enabl_or_disable." WHERE Shop_Id =".$shop_id) or die('query failed');
            if($delete_query){
               $message[] = 'Shop has been Enabled';
            }else{
               #header('location:admin.php');
               $message[] = 'Shop could not be Disabled';
            }
      }
      
      /*UPDATE `Shops` SET `Shop_name`=[value-2],`Shop_brand_name`=[value-3],`shop_type`=[value-4],`Shop_oweners_id`=[value-5],`Shop_linke`=[value-6],`shop_email`=[value-7],`shop_phone_no`=[value-8],`Shop_location`=[value-9],`Shop_about`=[value-10],`Shop_rate`=[value-11],`Shop_likes`=[value-12],`Shop_followers`=[value-13],`Shop_items`=[value-14],`Shop_workers`=[value-15],`Shop_password`=[value-16],`Shop_contry`=[value-17],`Shop_settings`=[value-18],`Shop_profile_img`=[value-19],`Shop_banner_imgs`=[value-20],`Shop_payment_r`=[value-21],`Shop_balance`=[value-22],`Shop_payment_info`=[value-23] WHERE shop_id = $delete_id ";
      
      
      CREATE TABLE Shops (
          shop_id INT AUTO_INCREMENT PRIMARY KEY,
          Shop_name VARCHAR(255),
          Shop_brand_name VARCHAR(255),
          shop_type VARCHAR(255),
          Shop_oweners_id TEXT,
          Shop_linke VARCHAR(255),
          shop_email VARCHAR(255),
          shop_phone_no VARCHAR(200),
          Shop_location VARCHAR(255),
          Shop_about TEXT,
          Shop_rate DECIMAL(5, 2),
          Shop_likes INT,
          Shop_followers INT,
          Shop_items INT,
          Shop_workers INT,
          Shop_password VARCHAR(255),
          Shop_contry VARCHAR(255),
          Shop_settings TEXT,
          Shop_Page TEXT,
          Shop_profile_img VARCHAR(255),
          Shop_banner_imgs TEXT,
          Shop_payment_r VARCHAR(255),
          Shop_balance DECIMAL(10, 2),
          Shop_payment_info TEXT,
          Shop_isenabled INT(10) Not NULL DEFAULT 0
      );
      */

    } else {
        echo json_encode(['status' => 'MethodNotAllowed', 'message' => 'Only POST method is allowed.']);
    }
} catch (Exception $e) {
    customExceptionHandler($e);
} 
?>