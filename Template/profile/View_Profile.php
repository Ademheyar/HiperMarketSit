<?php
if (session_id() == "") session_start();
$_SESSION['previous_page'][] = "/Template/profile/View_Profile.php"; # save vorront page
 
if (isset($_POST['user_name'])) {
    // Update the session variable value
    $_SESSION['user_name'] = $_POST['user_name'];
    echo "The new value of user_name is: " . $_SESSION['user_name'];
}
  if(file_exists("config.php")) include("config.php");
  if(file_exists("../../config.php")) include("../../config.php");

  
  if(file_exists("Template/msg.php")) include("Template/msg.php");
  if(file_exists("../../Template/msg.php")) include("../../Template/msg.php");

    /*$selected_company_id = $_SESSION['loged_user_info']['Shop_Id'];
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
  $conn->query($sql);*/

if (session_id() == "") session_start();
$shop_found = 0;

if (!isset($ishome) or $_SESSION['on'] != 6){
    $_SESSION['on'] = 6;
    $protocol = isset($_SERVER['HTTPS']);
    $doman = $_SERVER['HTTP_HOST'];
    $currontDir = dirname($_SERVER['REQUEST_URI']);
    $redirectURL = $protocol .$doman .$currontDir;
    $DIRPATHS = explode('/', $currontDir);
    //header("Location: ".$_SERVER['DOCUMENT_ROOT']."/".$DIRPATHS[1]."/"."Home.php");
    header("Location: ../../Home.php");
    exit; // Make sure to include exit
}

//$_SESSION['on'] = 0;
?>
<div class="Main">
    <div class="User_Profile_Info">
        <?php
        if (isset($_SESSION['loged_user_info']) && $_SESSION['loged_user_info']['user_name'] != "") {
            ?>
            <div class="Profile_image">
                <?php
                    $imgp = "Img/Company/".$_SESSION['loged_user_info']['User_id']."/".$_SESSION['loged_user_info']['User_id']."_Logo.jpg";
                    if(!file_exists($imgp)) $imgp = "./Img/no_Profile_image.jpg";
                    
                ?>
                <img src="<?php echo $imgp; ?>" alt="">
                <h1 class="user_name"><?php echo $_SESSION['loged_user_info']['user_name']." ".$_SESSION['loged_user_info']['user_gender']; ?></h1>
                <h2 class="Shop_brund_name"><?php echo $_SESSION['loged_user_info']['user_name']." ".$_SESSION['loged_user_info']['user_gender'];  ?></h2>
            </div>
            <Script>
                const img = document.querySelector('body .Main .User_Profile_Info .Profile_image img');
                const user_name = document.querySelector('body .Main .User_Profile_Info .Profile_image .user_name');
                const Shop_brund_name = document.querySelector('body .Main .User_Profile_Info .Profile_image .Shop_brund_name');
                img.onclick = (function () { 
                    const replay = confirm("Do you what to change Company Logo?");
                    if (replay) {
                        var newInput = document.createElement('input');
                        newInput.type = 'file';
                        newInput.name = 'Change_Company_logo_Image[]';
                        newInput.className="Change_Company_logo_Image";
                        newInput.accept="image/png, image/jpg, image/jpeg";
                        newInput.multiple=true;
                        newInput.addEventListener('change', function(event) {
                            const file = event.target.files[0];
                            if(file){
                                let formData = new FormData();
                                formData.append('Change_Company_logo_Image', 'Change_Company_logo_Image');
                                formData.append('Company_Id', "<?php echo $_SESSION['loged_user_info']['User_id']; ?>");
                                formData.append('Company_logo_Image', file);
                                console.log('going fetchAjaxRequest formData', formData);
                                fetchAjaxRequest('server/Company/Company_profile.php', "POST", formData, 
                                function (data){
                                    if (data.image_path && !data.image_path == "") {
                                        const cacheBuster = new Date().getTime();
                                        img.src = `${data.image_path}?cb=${cacheBuster}`;
                                        img.value = data.image_path;
                                        alert("good");
                                    }
                                    else alert("faled");
                                }, function (error) { alert("error" + error); } );
                            }
                            else alert("selcte img");
                        });
                        //newInputWrapper.appendChild(newInput);
                        // Automatically trigger
                        newInput.click();  
                    }
                });
            </Script>
            <div style="
                        display: flex;
                        flex-wrap: wrap;
                        flex-direction: row;
                        gap: 2.2rem;
                    ">
                <div class="company_rate_div">
                    <script>
                        function rate_company(rated) {
                            let formData = new FormData();
                            formData.append('Rate_Company', 'Rate_Company');
                            formData.append('Company_Id', "<?php echo $_SESSION['loged_user_info']['User_id']; ?>");
                            formData.append('User_Id', "<?php echo $_SESSION['loged_user_info']['User_id']; ?>");
                            
                            formData.append('User_rated', rated+1);
                            fetchAjaxRequest('server/Company/Company_profile.php', "POST", formData, 
                            function (data){
                                console.log('fetchAjaxRequest data', data);
                                
                            }, function (error) { alert("error " + error); } );
                            console.log('going torate_company rated', rated);
                        }
                        const rateing_container = document.querySelector('body .Main .User_Profile_Info .company_rate_div');
                        create_ratting(rateing_container, 5, rate_company);
                    </script> 
                </div>
                <div class="company_followers_div">
                <script>
                    function followe_company() {
                        let formData = new FormData();
                        formData.append('Followe_Company', 'Followe_Company');
                        formData.append('Company_Id', "<?php echo $_SESSION['loged_user_info']['User_id']; ?>");
                        formData.append('User_Id', "<?php echo $_SESSION['loged_user_info']['User_id']; ?>");
                        
                        formData.append('User_Followe', '1');
                        fetchAjaxRequest('server/Company/Company_profile.php', "POST", formData, 
                        function (data){
                            console.log('fetchAjaxRequest data', data);
                            
                        }, function (error) { alert("error " + error); } );
                    }
                    </script> 
                    <input type="button" class="Follow_btn"value="+" onclick="followe_company();"></input>
                    <h1 class="user_name"><?php echo "";//explode('~', $_SESSION['loged_user_info']['Shop_followers'])[0]; ?></h1>
                    <h1 class="user_name">Followers</h1>
                </div>
                <div>
                    <h1 class="user_name"><?php echo "";//explode('~', $_SESSION['loged_user_info']['Shop_workers'])[0]; ?></h1>
                    <h1 class="user_name">WORKERS</h1>
                </div>
            </div>
            <div class="About_disc" style="width: 50%;">
                <h2>About</h2>
                <?php $user_about_str = $_SESSION['loged_user_info']['user_about']; if(strlen($user_about_str)>100){?>
                    <p class="Shopabout_Str_start"><?php echo substr($user_about_str, 0, 100);?></p>
                    <p class="Shopabout_Str_end" style="display: none;"><?php echo substr($user_about_str, 100);?></p>
                    <input type="button" class="Read_more_Shopabout"value="...Show More" ></input>
                    <Script>
                        const Shopabout_Str_start = document.querySelector('body .Main .User_Profile_Info .About_disc .Shopabout_Str_start');
                        const Shopabout_Str_end = document.querySelector('body .Main .User_Profile_Info .About_disc .Shopabout_Str_end');
                        const Read_more_Shopabout = document.querySelector('body .Main .User_Profile_Info .About_disc .Read_more_Shopabout');
                        Read_more_Shopabout.onclick = (function () { 
                            if (this.value == '...Show More') {        
                                this.parentNode.querySelector('.Shopabout_Str_end').style.display = 'block';
                                this.value = 'Show Less';
                            } else{
                                this.parentNode.querySelector('.Shopabout_Str_end').style.display = 'none';
                                this.value = '...Show More';
                            }
                        });
                    </Script>
                <?php } else {?> <p class="Shopabout"><?php echo $user_about_str;?></p> <?php }?>
            </div>
        <?php } ?>
        
        <div class="profile_btn">
            <button class="shopprofiletablinks">Message</button>
            <!--<button class="shopprofiletablinks">Shear</button>-->
            <button class="viewprofiletablinks">Shear</button>
            <button class="viewprofiletablinks">Edit</button>
            <div class="contact_div">
                <div class="contact_container">

                </div>
            </div> 
            <script> 
                function Show_contacts() {
                    const contact_container = document.querySelector('body .Main .User_Profile_Info .profile_btn .contact_container');
                        console.log('going followe_company', contact_container);
                    if(contact_container.style.display == "block"){
                        console.log('going block');
                        while (contact_container.firstChild) contact_container.removeChild(contact_container.firstChild);
                        contact_container.style.display = "none";
                    }
                    else{
                        console.log('going none');
                        contact_container.style.display = "block";
                        create_contacts(contact_container, '<?php echo isset($_SESSION['loged_user_info']['user_contact']) ? $_SESSION['loged_user_info']['user_contact']: ""; ?>');
                    }
                    console.log('going followe_company', contact_container.style.display);
                }
            </script>
            <button class="shopprofiletablinks" onclick="Show_contacts();"; >Contact</button>
            <a href="Template/User/Logout.php" class="viewprofiletablinks">Log Out</a>
        </div>
        
    </div>
    <main>
        <div class="tab">
            <button class="viewprofiletablinks" onclick="View_Profile_openTab(event, 'product_items_list_containers1')">For You</button>
            <button class="viewprofiletablinks" onclick="View_Profile_openTab(event, 'FitemsTab')">Favorite Items</button>
            <button class="viewprofiletablinks" onclick="View_Profile_openTab(event, 'FshopTab')">Favorite Shops</button>
            <button class="viewprofiletablinks" onclick="View_Profile_openTab(event, 'OrderTab')">Order</button>
            <a href="Template/shop/Shop_Profile.php" class="viewprofiletablinks">MY Shops</a>
        </div>

        <div id="FitemsTab" class="viewprofiletabcontent">
            <h2>Favorite Items</h2>

        </div>

        <div id="FshopTab" class="viewprofiletabcontent">
            <h2>Favorite Shop</h2>

        </div>

        <div id="OrderTab" class="viewprofiletabcontent">
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

        <div id="customerInfoTab" class="viewprofiletabcontent">
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

        <div id="product_items_list_containers1" class="product_items_list_containers1 viewprofiletabcontent">
            <div class="product_items_list_box1">
                <!-- The product items will be added dynamically using JavaScript -->
            </div>
        </div>
    </main>
    <?php //include ('footer.php'); ?>
</div>

<script>
    // Handle tab switching
    function View_Profile_openTab(evt, tabName) {
        // Get all tab content elements and hide them
        const viewprofiletabContent = document.getElementsByClassName("viewprofiletabcontent");
        for (let i = 0; i < viewprofiletabContent.length; i++) {
            viewprofiletabContent[i].style.display = "none";
        }

        // Remove 'active' class from all viewprofiletablinks
        const viewprofiletabLinks = document.getElementsByClassName("viewprofiletablinks");
        for (let i = 0; i < viewprofiletabLinks.length; i++) {
            viewprofiletabLinks[i].classList.remove("active");
        }

        // Show the selected tab and mark the corresponding tablink as active
        document.getElementById(tabName).style.display = "block";
        document.getElementById(tabName).classList.add("active");
    }
    View_Profile_openTab("", 'product_items_list_containers1');
</script>
<style>
    /* Main Styles */
    body .Main {
        overflow: auto;
        top: 5%;
        width: 100%;
        height: 100%;
        align-items: flex-start;
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