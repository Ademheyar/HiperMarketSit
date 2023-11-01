<?php
if (session_id() == "") session_start();
$_SESSION['previous_page'][] = "/Template/profile/View_Profile.php"; # save vorront page
 
if (isset($_POST['Shop_name'])) {
    // Update the session variable value
    $_SESSION['Shop_name'] = $_POST['Shop_name'];
    echo "The new value of Shop_name is: " . $_SESSION['Shop_name'];
}

if (!isset($ishome) or $_SESSION['on'] != 1){
    $_SESSION['on'] = 1;
    header("Location: /Home.php");
    exit; // Make sure to include exit
}
include ('Template/msg.php');
@include 'config.php';
?>
<div class="Main">
    <div class="About_disc">
        <?php
        if (isset($_SESSION['loged_user_info']) && $_SESSION['loged_user_info']['user_name'] != "") {
            ?>
            <div class="Profile_image">
                <!--<img src="<?php echo "./Users_profile_img/" . $_SESSION['loged_user_info']['user_name'] . ".jpg"; ?>" alt="">-->
                <img src="./img/no_Profile_image.jpg" alt="">
                <h1 class="user_name"><?php echo $_SESSION['loged_user_info']['user_name']." ".$_SESSION['loged_user_info']['user_gender']; ?></h1>
                <h2 class="user_about"><?php echo $_SESSION['loged_user_info']['user_name']." ".$_SESSION['loged_user_info']['user_gender'];  ?></h2>
                <h2>About</h2>
                <h2 class="user_about"><?php echo $_SESSION['loged_user_info']['user_about'];?></h2>
            </div>
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
            <button class="tablinks" onclick="openTab(event, 'product_items_list_containers1')">For You</button>
            <button class="tablinks" onclick="openTab(event, 'FitemsTab')">Favorite Items</button>
            <button class="tablinks" onclick="openTab(event, 'FshopTab')">Favorite Shops</button>
            <button class="tablinks" onclick="openTab(event, 'OrderTab')">Order</button>
            <button class="tablinks" onclick="openTab(event, 'myshoptab')">My Shop</button>
        </div>

        <div id="myshoptab" class="tabcontent">
        <?php  
        include 'Template/shop/List_my_shop.php'; ?> 
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

        <div id="product_items_list_containers1" class="product_items_list_containers1 tabcontent">
            <div class="product_items_list_box1">
                <!-- The product items will be added dynamically using JavaScript -->
            </div>
        </div>
    </main>
    <?php include ('footer.php'); ?>
</div>

<script>
    // Sample datad for demonstration
    const shopStock = [{
        name: "Product 1",
        price: "$10",
        availability: "In Stock"
    },
        {
            name: "Product 2",
            price: "$20",
            availability: "Out of Stock"
        },
        {
            name: "Product 3",
            price: "$15",
            availability: "In Stock"
        },
    ];

    // Sample data for demonstration
    const customerInfo = [{
        name: "John Doe",
        email: "john@example.com",
        phone: "123-456-7890"
    },
        {
            name: "Jane Smith",
            email: "jane@example.com",
            phone: "987-654-3210"
        },
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
    openTab("", 'product_items_list_containers1');

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