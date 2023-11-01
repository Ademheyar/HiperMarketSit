<?php

@include 'config.php';

if (isset($_POST['Create_New_Shop'])) {
    if (session_id() == "") session_start();
    $main_p = getcwd();
    $register_sname = $_POST['register_sname'];
    $register_bname = $_POST['register_bname'];
    $register_type = $_POST['register_type'];
    $register_email = $_POST['register_email'];
    $register_country = $_POST['register_country'];
    $register_phone_No = $_POST['register_phone_No'];
    $register_location = $_POST['register_location'];
    $register_password = $_POST['register_password'];
    $register_oweners_id = $_SESSION['loged_user_info']['User_id'];
    
    //$_SESSION['loged_user_info']['User_work_shop']
    // Establish your database connection here, e.g., $conn = mysqli_connect(...);

    $insert_query = "INSERT INTO `Shops`(`Shop_name`, `Shop_brand_name`, `Shop_oweners_id`, `shop_type`, `Shop_location`, `Shop_contry`, `shop_email`, `shop_phone_no`, `Shop_password`) 
                     VALUES ('$register_sname','$register_bname','$register_oweners_id','$register_type','$register_location','$register_country','$register_email','$register_phone_No','$register_password')";
  $insert_result = mysqli_query($conn, $insert_query) or die('failed to insert newd shop');
  if ($insert_result) {
    $newly_inserted_id = mysqli_insert_id($conn);
$shop_info = "(".$newly_inserted_id.", 0, 1),";
$update_query = "UPDATE users SET user_shops = CONCAT(user_shops, '".$shop_info."') WHERE User_id = ".$_SESSION['loged_user_info']['User_id'];
$upload_info_result = mysqli_query($conn, $update_query) or die('Failed to update users: ' . mysqli_error($conn));
$_SESSION['loged_user_info']['user_shops'] = $_SESSION['loged_user_info']['user_shops'].$shop_info;
  } else {
    echo "Failed to insert new item";
  }  
    // shop id, is enabled, activity
   
    
};

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
$shop_info = "(".$newly_inserted_id.", 0, 1),";
$update_query = "UPDATE users SET User_work_shop = CONCAT(User_work_shop, '".$shop_info."') WHERE User_id = ".$row['User_id'];
$upload_user_result = mysqli_query($conn, $update_query) or die('Failed to update user: ' . mysqli_error($conn));
if ($upload_user_result){
$user_info = "(".$row['User_id'].", 0, 1),";
$update_shop_query = "UPDATE Shops SET Shop_workers = CONCAT(Shop_workers, '".$user_info."') WHERE Shop_Id = ".$newly_inserted_id;
$upload_shop_result = mysqli_query($conn, $update_shop_query) or die('Failed to update shop: ' . mysqli_error($conn));
$_SESSION['Selected_Shop']['Shop_workers'] = $_SESSION['Selected_Shop']['Shop_workers'].$shop_info;
}
}
}else {
    echo "Failed to get new item";
  } 
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
    Shop_profile_img VARCHAR(255),
    Shop_banner_imgs TEXT,
    Shop_payment_r VARCHAR(255),
    Shop_balance DECIMAL(10, 2),
    Shop_payment_info TEXT,
    Shop_isenabled INT(10) Not NULL DEFAULT 0
);
*/