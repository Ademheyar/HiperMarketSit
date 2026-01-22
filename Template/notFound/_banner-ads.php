<?php
  if (session_id() == "") session_start();
  if(file_exists("config.php")) include("config.php");
  if(file_exists("../../config.php")) include("../../config.php");
  if(!isset($conn)){
        $protocol = isset($_SERVER['HTTPS']);
        $doman = $_SERVER['HTTP_HOST'];
        $currontDir = dirname($_SERVER['REQUEST_URI']);
        $DIRPATHS = explode('/', $currontDir);
        $redirectURL = $protocol .$doman .$currontDir;
        include("../../config.php");
    }
$shop_found = 0;

if (isset($_GET['Selected_sid'])){
    $shop_id = $_GET['Selected_sid'];
    $select_shop = $conn->query("SELECT * FROM `Shops` WHERE Shop_Id=".$shop_id);
    if($select_shop->num_rows > 0){
     // exit; // Make sure
     while($row = mysqli_fetch_assoc($select_shop))            
     {
        //ToDo:chacke user can acsses this shop befor listing it 
        $_SESSION['Selected_Shop'] = $row;
        $shop_found = 1;
        break;
    }
  }         
}

if (!($_SESSION['Selected_Shop']) && $shop_found == 0){
    if ($_SESSION['previous_page']){
    header("Location: ".array_pop($_SESSION['previous_page']));
    }
    else {
        $_SESSION['on'] = 1;
        header("Location: /Home.php");
       }
    exit;
}

$selected_company_id = $_SESSION['Selected_Shop']['Shop_Id'];
  $company_items_counted = 0;
  $products_atshop_list = $conn->query("SELECT * FROM products WHERE at_shop LIKE '%$selected_company_id%'");
  $company_items = [];
  if($products_atshop_list && $products_atshop_list->num_rows > 0){
      while ($row = mysqli_fetch_array($products_atshop_list)) {
          $shops = explode(',', $row['at_shop']);
          foreach ($shops as $key => $shop) {
              if ($shop == $selected_company_id) {
                  $company_items_counted++;
                  $user_id = 0;
                  if($_SESSION['loged_user_info']['User_id']) $user_id = $_SESSION['loged_user_info']['User_id'];
                  array_push($company_items, [$user_id, $row['id'], $row['Product_created_date'], date('d-m-Y')]);
              }
          }
      }
  }
  $_SESSION['company_items_counted'] = $company_items_counted;
  $New_Shop_items = $company_items_counted.'~'.json_encode($company_items);
  $sql = "UPDATE `shops` SET `Shop_items`='$New_Shop_items' WHERE Shop_Id = '$selected_company_id'";
  $conn->query($sql);

if (!isset($ishome) or $_SESSION['on'] != 2){
    $_SESSION['on'] = 2;
    $protocol = isset($_SERVER['HTTPS']);
    $doman = $_SERVER['HTTP_HOST'];
    $currontDir = dirname($_SERVER['REQUEST_URI']);
    $redirectURL = $protocol .$doman .$currontDir;
    header("Location: ../../Home.php");
    exit; // Make sure to include exit after the header redirect
}

?>
<div class="Main">
 
</div>
<script>
  function show_product_form(){
    const formB = document.querySelector("body .Main main .shop_product_items_list_container .New_form");
    const checkButton = document.querySelector("body .Main main .shop_product_items_list_container .product_menu .new_prd_btn");
    const buttonText = checkButton.textContent;
    if (buttonText === "New") { 
      formB.style.display = "block"; 
      checkButton.textContent = "Done";
    } else if (buttonText === "Done") { 
      formB.style.display = "none"; 
      checkButton.textContent = "New";
    }
  }
   // Handle tab switching

   function openTab(evt, tabName) {

      // Get all tab content elements and hide them

      const shopprofiletabContent = document.getElementsByClassName("shopprofiletabcontent");

      for (let i = 0; i < shopprofiletabContent.length; i++) {

          shopprofiletabContent[i].style.display = "none";

      }



      // Remove 'active' class from all shopprofiletablinks

      const tabLinks = document.getElementsByClassName("shopprofiletablinks");

      for (let i = 0; i < tabLinks.length; i++) {

          tabLinks[i].classList.remove("active");

      }



      // Show the selected tab and mark the corresponding tablink as active
      document.getElementById(tabName).style.display = "block";
      document.getElementById(tabName).classList.add("active");
   }

   openTab("", 'shop_product_items_list_containers');

  </script>

<style>
    body .Main {
        overflow: hidden;
        top: 5%;
        width: 100%;
        height: 100%;
        align-items: flex-start;
        background: #f8f8ff;
    }
     /* Main Styles */
    body .Main button {
            background-color: #f2f2f2;
            border: none;
            outline: none;
            cursor: pointer;
            width: auto;
            padding: 10px 20px;
            box-shadow: var(--box-shadow);
            border: var(--border);
            border-radius: 1.5rem;
            font-size: 16px;
            transition: background-color 0.3s;
    }
  
    body .Main h1, {
        margin-top: 0;
    }

    body .Main .profile_btn { 
        display: inline-flex;
        overflow: auto;
    }
 
    body .Main .tab {
        overflow: auto;
        width: 100%;
        margin-bottom: 0px;
        display: inline-flex;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        gap: 10px;
    }

    body .Main .tab button {
        background-color: #f2f2f2;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 10px 20px;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    body .Main .tab button:hover {
        background-color: #ddd;
    }

    body .Main .tab button.active {
        background-color: #ccc;
    }
    
    body .Main .shopprofiletabcontent {
        min-height: 60rem;
        height: auto;
    background-color: #eee;
    box-shadow: var(--box-shadow);
    border: var(--border);
    border-radius: 1.5rem;
    }
    body .Main main .DocumentsTab .doc_chart_frame  {
            height: auto;
            display: flex;
            flex-wrap: wrap;
    }
    
    body .Main .Shop_Profile_Info {
        align-items: flex-start;
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        column-gap: 5.0rem;
        row-gap: 1rem;
        justify-content: center;
        align-items: center;
    }

    body .Main .Shop_Profile_Info .company_followers_div .Follow_btn {
        background-color: #3462dd;
        color: white;
        /*position: absolute;*/
        border-radius: 25%;
        padding: 1px 5px;
        font-size: 10px;
        margin-left: 60px;
        margin-top: -14px;
    }

    body .Main .Shop_Profile_Info .profile_btn .contact_container {
        position: absolute;
        margin-top: -200;
        display: none;
        overflow-y: auto;
        height: 200px;
        width: 200px;
        box-shadow: var(--box-shadow);
        border: var(--border);
    }
    
    body .Main .Shop_Profile_Info .Profile_image {
        
        width: 25%;
        text-align: center;
        top: 5px;
        border-image: round;
    }

    body .Main .Shop_Profile_Info .Profile_image img {
        width: 100%;
        top: 12rem;
        border-image: round;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
    }
    body .Main .Shop_Profile_Info .user_name {
        
        color: black;
        background: white;
    }
    
    body .Main .Shop_Profile_Info .user_about {
        text-align: left;
        color: gray;
    }
    
    body .Main .Shop_Profile_Info .profile_btn button {
            background-color: #f2f2f2;
            border: none;
            outline: none;
            cursor: pointer;
            width: auto;
            padding: 10px 20px;
            box-shadow: var(--box-shadow);
            border: var(--border);
            border-radius: 1.5rem;
            font-size: 16px;
            transition: background-color 0.3s;
        }
    body .Main .About_disc {
        align-items: flex-start;
        width: 100%;
        height: 30%;
        background: #eee;
    }
    
    body .Main .About_disc .Profile_image {
        position: absolute;
        width: 20%;
        text-align: center;
        top: 5px;
        border-image: round;
    }

    body .Main .About_disc .Profile_image img {
        width: 100%;
        top: 12rem;
        border-image: round;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
    }
    body .Main .About_disc .user_name {
        
        color: black;
        background: white;
    }
    
    body .Main .About_disc .user_about {
        text-align: left;
        color: gray;
    }

    body .Main h1, {
        margin-top: 0;
    }

    body .Main .profile_btn {
        overflow: auto;
        width: 100%;
        margin-bottom: 0px;
        display: inline-flex;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        gap: 10px;
    }
    
    body .Main .profile_btn button {
        background-color: #f2f2f2;
        border: none;
        outline: none;
        cursor: pointer;
        width: auto;
        padding: 10px 20px;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        font-size: 16px;
        transition: background-color 0.3s;
    }
    
    body .Main .tab {
        overflow: auto;
        width: 100%;
        margin-bottom: 0px;
        display: inline-flex;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        gap: 10px;
    }

    body .Main .tab button {
        background-color: #f2f2f2;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 10px 20px;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    body .Main .tab button:hover {
        background-color: #ddd;
    }

    body .Main .tab button.active {
        background-color: #ccc;
    }
    
    body .Main .viewprofiletabcontent {
        min-height: 60rem;
        height: auto;
    }
    
    body .Main table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    body .Main table th, table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    
    
    
    
    .productCard {
        width: 200px;
        padding: 10px;
        margin-right: 20px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .productCard img {
        width: 100%;
        height: auto;
        margin-bottom: 10px;
    }

    .productCard h3 {
        margin-top: 0;
    }

    .productCard p {
        margin: 0;
    }

    /* media queries  */

@media (max-width:1500px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            top: 5%;
            align-items: flex-start;
            width: 100%;
            height: 100%;
            background: #f8f8ff;
        }
    }

@media (max-width:991px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            top: 14%;
            left: 0%;
            align-items: flex-start;
            width: 100%;
            height: 100%;
            background: #f8f8ff;
        }
    }

@media (max-width:768px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            top: 16%;
            left: 0%;
            align-items: flex-start;
            width: 100%;
            height: 100%;
            background: #f8f8ff;
       }
    }

@media (max-width: 600px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            left: 0;
            align-items: flex-start;
            width: 100%;
            height: 100%;
            background: #f8f8ff;
        }
    }

@media (max-width:450px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            left: 0;
            align-items: flex-start;
            width: 100%;
            height: 100%;
            background: #f8f8ff;
        }
    }

    /* Main Styles */
    body .Main {
        overflow: auto;
        align-items: flex-start;
        background: #f8f8ff;
    }

    body .Main button {
            background-color: #f2f2f2;
            border: none;
            outline: none;
            cursor: pointer;
            width: auto;
            padding: 10px 20px;
            box-shadow: var(--box-shadow);
            border: var(--border);
            border-radius: 1.5rem;
            font-size: 16px;
            transition: background-color 0.3s;
    }
  
    body .Main main .DocumentsTab .doc_chart_frame  {
            height: auto;
            display: flex;
            flex-wrap: wrap;
    }
    
    body .Main .User_Profile_Info {
        align-items: flex-start;
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        column-gap: 5.0rem;
        row-gap: 1rem;
        justify-content: center;
        align-items: center;
    }

    body .Main .User_Profile_Info .company_followers_div .Follow_btn {
        background-color: #3462dd;
        color: white;
        /*position: absolute;*/
        border-radius: 25%;
        padding: 1px 5px;
        font-size: 10px;
        margin-left: 60px;
        margin-top: -14px;
    }

    body .Main .User_Profile_Info .profile_btn .contact_container {
        position: absolute;
        margin-top: -200;
        display: none;
        overflow-y: auto;
        height: 200px;
        width: 200px;
        box-shadow: var(--box-shadow);
        border: var(--border);
    }
    
    body .Main .User_Profile_Info .Profile_image {
        
        width: 25%;
        text-align: center;
        top: 5px;
        border-image: round;
    }

    body .Main .User_Profile_Info .Profile_image img {
        width: 100%;
        top: 12rem;
        border-image: round;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
    }
    body .Main .User_Profile_Info .user_name {
        
        color: black;
        background: white;
    }
    
    body .Main .User_Profile_Info .user_about {
        text-align: left;
        color: gray;
    }
    
    body .Main .User_Profile_Info .profile_btn button {
            background-color: #f2f2f2;
            border: none;
            outline: none;
            cursor: pointer;
            width: auto;
            padding: 10px 20px;
            box-shadow: var(--box-shadow);
            border: var(--border);
            border-radius: 1.5rem;
            font-size: 16px;
            transition: background-color 0.3s;
        }
    body .Main h1, {
        margin-top: 0;
    }

    body .Main .profile_btn { 
        display: inline-flex;
        gap: inherit;
    }
    
    
    
    body .Main .tab {
        overflow: auto;
        width: 100%;
        margin-bottom: 0px;
        display: inline-flex;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        gap: 10px;
    }

    body .Main .tab button {
        background-color: #f2f2f2;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 10px 20px;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    body .Main .tab button:hover {
        background-color: #ddd;
    }

    body .Main .tab button.active {
        background-color: #ccc;
    }
    
    body .Main .shopprofiletabcontent {
        min-height: 60rem;
        height: auto;
    background-color: #eee;
    box-shadow: var(--box-shadow);
    border: var(--border);
    border-radius: 1.5rem;
    }
    
    body .Main table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    body .Main table th, table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    
    
    
    
    .productCard {
        width: 200px;
        padding: 10px;
        margin-right: 20px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .productCard img {
        width: 100%;
        height: auto;
        margin-bottom: 10px;
    }

    .productCard h3 {
        margin-top: 0;
    }

    .productCard p {
        margin: 0;
    }

    /* media queries  */

@media (max-width:1500px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            align-items: flex-start;
            background: #f8f8ff;
        }
    }

@media (max-width:991px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            align-items: flex-start;
            background: #f8f8ff;
        }
    }

@media (max-width:768px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            align-items: flex-start;
            background: #f8f8ff;
       }
    }

@media (max-width: 600px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            align-items: flex-start;
            /*position: absolute;*/
            background: #f8f8ff;
        }
    }

@media (max-width:450px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            align-items: flex-start;
            background: #f8f8ff;
        }
    }
</style>




<!-- Banner Ads  -->
<section id="banner_adds">
    <div class="banner_adds_container">
        <img src="./Img/banner/banner1-cr-500x150.jpg" alt="banner1" class="img-fluid">
        <img src="./Img/banner/banner2-cr-500x150.jpg" alt="banner1" class="img-fluid">
    </div>
</section>
<!-- !Banner Ads  -->
<!-- Banner Ads  -->
<section id="banner_adds">
    <div class="banner_adds_container">
        <img src="./Img/banner/banner1-cr-500x150.jpg" alt="banner1" class="img-fluid">
        <img src="./Img/banner/banner2-cr-500x150.jpg" alt="banner1" class="img-fluid">
    </div>
</section>
<!-- !Banner Ads  -->
<!-- Banner Ads  -->
<section id="banner_adds">
    <div class="banner_adds_container">
        <img src="./Img/banner/banner1-cr-500x150.jpg" alt="banner1" class="img-fluid">
        <img src="./Img/banner/banner2-cr-500x150.jpg" alt="banner1" class="img-fluid">
    </div>
</section>
<!-- !Banner Ads  -->
<!-- Banner Ads  -->
<section id="banner_adds">
    <div class="banner_adds_container">
        <img src="./Img/banner/banner1-cr-500x150.jpg" alt="banner1" class="img-fluid">
        <img src="./Img/banner/banner2-cr-500x150.jpg" alt="banner1" class="img-fluid">
    </div>
</section>
<!-- !Banner Ads  -->
