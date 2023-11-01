<?php
@include 'config.php';
if (session_id() == "") session_start();
$shop_found = 0;

if (isset($_GET['Selected_sid'])){
    //exit; // Make sure
    if(!$conn){
      $conn = mysqli_connect('0.0.0.0:3306','root','root','Shop') or die('connection failed');
    }
    $shop_id = $_GET['user_shop_id'];
    $select_shop = mysqli_query($conn, "SELECT * FROM `Shops`");
    if(mysqli_num_rows($select_shop) > 0){
     while($row = mysqli_fetch_assoc($select_shop))                
     {
//ToDo:chacke user can acsses this shop befor listing it 
if($row['Shop_Id'] == $shop_id){
$_SESSION['Selected_Shop'] = $row;
$shop_found = 1;
break;
}
    }
  }         
}

if (!($_SESSION['Selected_Shop']) && $shop_found == 0){
    if ($_SESSION['previous_page']){
           #$_SESSION['on'] = 2;
    header("Location: ".array_pop($_SESSION['previous_page']));
    exit; // Make sure
    }
    else {
        $_SESSION['on'] = 1;
        //header("Location: /Home.php");
       }
    exit;
}

if (!isset($ishome) or $_SESSION['on'] != 2){
    $_SESSION['on'] = 2;
    header("Location: /Home.php");
    exit; // Make sure to include exit after the header redirect
}
include ('Template/msg.php');
//$_SESSION['on'] = 0;
?>
<div class="Main">
    <div class="About_disc">
        <?php
        if (isset($_SESSION['Selected_Shop']) && $_SESSION['Selected_Shop']['Shop_name'] != "") {
            ?>
            <div class="Profile_image">
                <!--<img src="<?php echo "./Users_profile_img/" . $_SESSION['Selected_Shop']['Shop_name'] . ".jpg"; ?>" alt="">-->
                <img src="./img/no_Profile_image.jpg" alt="">
                <h1 class="Shop_name"><?php echo $_SESSION['Selected_Shop']['Shop_name']." ".$_SESSION['Selected_Shop']['shop_type']; ?></h1>
                <h2 class="user_about"><?php echo $_SESSION['Selected_Shop']['Shop_name']." ".$_SESSION['Selected_Shop']['shop_type'];  ?></h2>
                <h2>About</h2>
                <h2 class="Shop_about"><?php echo $_SESSION['Selected_Shop']['Shop_about'];?></h2>
            </div>
            <!--
Shop_Id
Shop_name
Shop_brand_name
shop_type
Shop_oweners_id
Shop_linke
shop_email
shop_phone_no
Shop_location
Shop_about
Shop_rate
Shop_likes
Shop_followers
Shop_items
Shop_workers
Shop_password
Shop_contry
Shop_settings
Shop_profile_img
Shop_banner_imgs
Shop_payment_r
Shop_balance
Shop_payment_info
Shop_isenabled            
      -->      
        <?php } ?>
    </div>
    <div class="profile_btn">
        <button class="tablinks">Message</button>
        <button class="tablinks">Shear</button>
        <button class="tablinks">Edit</button>
        <button class="tablinks">Contact</button>
        <a href="Logout.php" class="tablinks">Log Out</a>
    </div>

    <main>
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'shop_product_items_list_containers')">Shop Products</button>
            <button class="tablinks" onclick="openTab(event, 'DocumentsTab')">Documents</button>
            <button class="tablinks" onclick="openTab(event, 'FshopTab')">History</button>
            <button class="tablinks" onclick="openTab(event, 'OrderTab')">Orders</button>
            <button class="tablinks" onclick="openTab(event, 'shopworkerstab')">Shop Workers</button>
        </div>
        
        
        <div id="shop_product_items_list_containers" class="shop_product_items_list_container tabcontent">
          <div class='product_menu'>
            <button class="tablinks new_prd_btn" onclick="show_product_form()">New</button>
          </div>
          <div class='New_form' style="display:none;">
            <?php include 'Template/shop/Add_Products.php'; ?> 
          </div>
          <div class="list_prd_frame">
              <script>
                
                const shop_list_container = document.querySelector('body .Main main .shop_product_items_list_container .list_prd_frame');
                create_list(shop_list_container, 'shoplist', 'shoplistbox', 'Products', 1,1);
              </script>
          </div>
        </div>
        <div id="DocumentsTab" class="DocumentsTab tabcontent">
            <h2>Documents</h2>
            <div class="doc_chart_frame">
              
            </div>
            <script src="js/Get/sendajax.js"></script>
            <script src="js/Chart/char.js"></script>
             <?php include 'Template/Chart/Call_Chart.php'; ?> 
             <script>
             const shop_chart_container = document.querySelector('body .Main main .DocumentsTab .doc_chart_frame');
               read_chart_htmtable(shop_chart_container)
             </script>
        </div>

        <div id="shopworkerstab" class="tabcontent">
        <?php // Include the product_form.php content 
        include 'Template/shop/List_shop_workers.php'; ?> 

        </div>
        
        <div id="FitemsTab" class="tabcontent">
            <h2>Favorite Items</h2>

        </div>

        <div id="FshopTab" class="tabcontent">
            <h2>Favorite Shop</h2>

        </div>
        <!--<a class="Home_text">
                                                                                                <span class="icon">
                                                                                                    <img src="img/person-outline.svg" class="person-outline" alt="">
                                                                                                </span>
                                                                                                <span class="text"><?//php echo $_SESSION['loged_user_name']; ?></span>
                                                                                            </a>-->

        <div id="OrderTab" class="tabcontent">
            <h2>Shop Stock</h2>
            <table id="OrderTable">
                <thead>
                    <tr>
                        <th>Orderd Name</th>
                        <th>Price</th>
                        <th>Availability</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Populate table rows dynamically using JavaScript -->
                </tbody>
            </table>
        </div>

        <div id="customerInfoTab" class="tabcontent">
            <h2>Customer Information</h2>
            <table id="customerInfoTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Populate table rows dynamically using JavaScript -->
                </tbody>
            </table>
        </div>
    </main>
    <?php include ('footer.php'); ?>
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
    // Sample data for demonstration

   const shopStock = [

   { name: "Product 1", price: "$10", availability: "In Stock" },

   { name: "Product 2", price: "$20", availability: "Out of Stock" },

   { name: "Product 3", price: "$15", availability: "In Stock" },

   ];



    // Sample data for demonstration

   const customerInfo = [

   { name: "John Doe", email: "john@example.com", phone: "123-456-7890" },

   { name: "Jane Smith", email: "jane@example.com", phone: "987-654-3210" },

   ];



   // Handle tab switching

   function openTab(evt, tabName) {

      // Get all tab content elements and hide them

      const tabContent = document.getElementsByClassName("tabcontent");

      for (let i = 0; i < tabContent.length; i++) {

          tabContent[i].style.display = "none";

      }



      // Remove 'active' class from all tablinks

      const tabLinks = document.getElementsByClassName("tablinks");

      for (let i = 0; i < tabLinks.length; i++) {

          tabLinks[i].classList.remove("active");

      }



      // Show the selected tab and mark the corresponding tablink as active
      document.getElementById(tabName).style.display = "block";
      document.getElementById(tabName).classList.add("active");
   }

   openTab("", 'shop_product_items_list_containers');



   // Populate shop stock table

   const stockTable = document.getElementById("shopStockTable").getElementsByTagName("tbody")[0];

   shopStock.forEach(product => {

   const row = stockTable.insertRow();

   row.innerHTML = `<td>${product.name}</td><td>${product.price}</td><td>${product.availability}</td>`;

   });



   // Populate customer information table

   const customerTable = document.getElementById("customerInfoTable").getElementsByTagName("tbody")[0];

   customerInfo.forEach(customer => {

   const row = customerTable.insertRow();

   row.innerHTML = `<td>${customer.name}</td><td>${customer.email}</td><td>${customer.phone}</td>`;

   });
  </script>

<style>
    /* Main Styles */
    body .Main {
        overflow: auto;
        position: relative;
        top: 5%;
        width: 100%;
        height: 100%;
        align-items: flex-start;
        position: absolute;
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
        background-color: green;
        height: auto;
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
    
    body .Main .tabcontent {
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
            position: relative;
            top: 5%;
            align-items: flex-start;
            position: absolute;
            width: 100%;
            height: 100%;
            background: #f8f8ff;
        }
    }

@media (max-width:991px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            position: relative;
            top: 5%;
            left: 0%;
            align-items: flex-start;
            position: absolute;
            width: 100%;
            height: 100%;
            background: #f8f8ff;
        }
    }

@media (max-width:768px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            position: relative;
            top: 16%;
            left: 0%;
            align-items: flex-start;
            position: absolute;
            width: 100%;
            height: 100%;
            background: #f8f8ff;
       }
    }

@media (max-width: 600px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            position: relative;

            left: 0;
            align-items: flex-start;
            position: absolute;
            width: 100%;
            height: 100%;
            background: #f8f8ff;
        }
    }

@media (max-width:450px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            position: relative;

            left: 0;
            align-items: flex-start;
            position: absolute;
            width: 100%;
            height: 100%;
            background: #f8f8ff;
        }
    }
</style>