<?php

@include 'config.php';

if(isset($_POST['request_worker'])){
if (session_id() == "") session_start();
   $main_p = getcwd();
   $name = $_POST['get_name'];
   $email = $_POST['get_email'];
   $phone_No = $_POST['get_phone_No'];  
   $link = $_POST['get_link'];

   $insert_query = mysqli_query($conn, "INSERT INTO `Shops`(`Shop_name`, `Shop_brand_name`, `Shop_oweners_id`, `shop_type`, `Shop_location`, `Shop_contry`, `shop_email`, `shop_phone_no`, `Shop_password`) VALUES ('$register_sname','$register_bname','register_oweners_id','$register_type','$register_email','$register_country','$register_phone_No','$register_location','$register_password')") or die('failed to insert new shop');
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
*/