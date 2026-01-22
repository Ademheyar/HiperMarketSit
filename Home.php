<?php

if(session_id() == "") session_start();

$user_mini_info = array("", "");

  if(file_exists("config.php")) include("config.php");
  if(file_exists("../../config.php")) include("../../config.php");


#$_SESSION['previous_page'] = ['Home.php']

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
$ishome = 1;

?>

<html lang="en">
<head>
   <meta charset="UTF-8">

   <meta http-equiv="X-UA-Compatible" content="IE=edge">

   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Hiper Market</title>
   <!-- font awesome cdn link  

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
-->
   <!-- custom css file link  -->

   <link rel="stylesheet" href="css/style.css">

   <link rel="stylesheet" href="css/view.css">
</head>

<script src="js/Get/sendajax.js"></script>
<script src="js/view/View_Slips.js"></script>

<?php
include ('Template/Actions/Prosess_Payment.php');
include ('Template/Actions/View_Payment.php');
include ('js/view/Message_vewer.php');
?>


<script src="js/view/View_Active_Charts.js"></script>
<script src="js/view/view_item.js"></script>
<script src="js/view/View_Document.js"></script>
<script src="js/view/View_Cart.js"></script>

 <script src="js/Prodoct_item/Creat_Items_list3.js"></script>
<script src="js\Actions\Rateing.js"></script>
<script src="js\Actions\Contacts.js"></script>
<script src="js\Actions\List.js"></script>

<!--<script src="js\Shop\Edite_shop_page.js"></script>-->
<script src="js/Chart/char.js"></script>
<script src="js\Search\Search.js"></script>

<body>
<script>
      chacke_Message();
    </script>

   
 <?php   
/*else{
      ?>
      <script>
      Show_Message(["test 1", "teat2"]);
    </script>
 <?php    
}*/
?>
<?php
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

   include('Template/header/header.php');

   if ($_SESSION['on'] == 0){
      /*  include banner area  */
      include ('Main.php');
   }
   else if ($_SESSION['on'] == 1){
      /*  include banner area  */
      include ('Template/Sell/Sell.php');
   }
   else if ($_SESSION['on'] == 2){
   }
    else if ($_SESSION['on'] == 3){
   }  
   else if ($_SESSION['on'] == 4){
      /*  include banner area  */
      include ('Template/shop/Shop_Profile.php');
   } 
   else if ($_SESSION['on'] == 5){
      /*  include banner area  */
      include ('Template/shop/Shop_page.php');
   }  
   else if ($_SESSION['on'] == 6){
      /*  include banner area  */
      include ('Template/profile/View_Profile.php');
   } 

   /*  include banner area  */
  include ('Template/message/msg.php');
  include 'Template/User/login.php'; 
  include ('Template/manue/manue.php');
  include ('Template/footer/footer.php');
?>
<!-- custom js file link  -->
</body>
   <script src="js/script.js"></script>
</html>