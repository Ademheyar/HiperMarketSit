<?php
if(session_id() == "") session_start();
$user_mini_info = array("", "");
@include 'config.php';

if(isset($_POST['add_to_cart'])){
	if(session_id() == "") session_start();
    $info = array();
    if(isset($_POST['product_size'])){
        $info[0] = array();
        $info[0][0] = $_POST['product_size'];
        $info[0][1] = $_POST['product_color'];
    }
    $_SESSION['car'][$_SESSION['car_length']] = [$_POST['product_name'], $_POST['product_code'], $_POST['product_type'], $_POST['product_image'], $_POST['product_price'], $_POST['product_info'], $info];
    $_SESSION['car_length']++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
-->

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/view.css">
   <link rel="stylesheet" href="css/Prodoct_item/Creat_Items_list0.css">
   <link rel="stylesheet" href="css/Prodoct_item/Creat_Items_list1.css">
</head>
<body>
<?php
   if(session_id() == "") session_start(); // Start the session

   if (isset($_POST['Shop_name'])) {
      // Update the session variable value
      $_SESSION['Shop_name'] = $_POST['Shop_name'];
      echo "The new value of Shop_name is: " . $_SESSION['Shop_name'];
   }
   
   if (isset($_POST['on'])) {
      // Update the session variable value
      $_SESSION['on'] = $_POST['on'];
      echo "The new value of on is: " . $_SESSION['on'];
   }

   if(isset($message)){
      foreach($message as $message){
         echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
      };
   };
   include('header.php');
   if ($_SESSION['on'] == 0){
      /*  include banner area  */
      include ('Main.php');
   }
   else if ($_SESSION['on'] == 1){
      /*  include banner area  */
      include ('Template/profile/View_Profile.php');
   }
   else if ($_SESSION['on'] == 2){
      /*  include banner area  */
      include ('Template/shop/View_shop_Profile.php');
   }
    
   /*  include banner area  */
   
   include ('footer.php');
    
?>
</section>

</div>
<!-- !start #footer -->
<script src="js/script.js"> </script>
<script src="js/view/view_item.js"></script>
<!-- 
-->
<!-- custom js file link  -->
</body>
</html>