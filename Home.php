<?php

if(session_id() == "") session_start();

$user_mini_info = array("", "");

@include 'config.php';

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

   <title>products</title>
   <!-- font awesome cdn link  

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

-->

   <!-- custom css file link  -->

   <link rel="stylesheet" href="css/style.css">

   <link rel="stylesheet" href="css/view.css">

   <!--<link rel="stylesheet" href="css/Prodoct_item/Creat_Items_list0.css">-->

   <!--<link rel="stylesheet" href="css/Prodoct_item/Creat_Items_list1.css">
-->
</head>

<script src="js/Get/sendajax.js"></script>

<!--<script src="js/Chart/char.js"></script>-->
<script src="js/Prodoct_item/Creat_Items_list3.js"></script>


<script>

/*   var sec_url = 'Template/Get/Get_sections.php'; // The PHP script that fetches items from the database

   var sec_shop_name = "";

   var sec_user_name = "";

   var sec_user_id = "";

   var sec_datasent = 'by=date()';

   // Make an AJAX request to your PHP API

   sendAjaxRequest(sec_url, 'POST', sec_datasent, function(responseText) {

      console.log(responseText + '<< found sections');

      var response = JSON.parse(responseText);

      sec_user_name = "";

      sec_user_id = ""; 

      sec_shop_name = response.Shop_name;

      

      console.log(response);

      console.log(response.length + '<< sections.length');

   }, function(errorStatus) { console.log('Error: ' + errorStatus); });*/

</script>
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
    include('header.php');
    include ('Template/msg.php');
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
      include ('Template/shop/Shop_Profile.php');
   }
    else if ($_SESSION['on'] == 3){
      /*  include banner area  */
      include ('Template/shop/Shop_page.php');
   }   

   /*  include banner area  */
  include 'cart.php';  
  include 'login.php'; 
  include ('Template/manue.php');
  include ('footer.php');
?>
<!-- custom js file link  -->
</body>
<script src="js/script.js"></script>
<script src="js/view/view_item.js"></script>
</html>