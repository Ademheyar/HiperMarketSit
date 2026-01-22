<?php
  if (session_id() == "") session_start();
  if(file_exists("config.php")) include("config.php");
  if(file_exists("../config.php")) include("../config.php");
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
// chacke if $shop_count is orday selecte or have value
$_SESSION['selected_company_id'] = -1;

if(isset($_SESSION['loged_user_info']['User_work_shop'])) {
    $user_shops = json_decode($_SESSION['loged_user_info']['User_work_shop'], true);
    $_SESSION['User_Shops'] = [];
    foreach ($user_shops as $shop) {
        $Company_Id = $shop[0];
        $select_shop = $conn->query("SELECT * FROM `shops` WHERE Shop_Id='$Company_Id'");
        if($select_shop->num_rows > 0){
         // exit; // Make sure
         while($row = mysqli_fetch_assoc($select_shop))   
         {
            //ToDo:chacke user can acsses this shop befor listing it 
            $_SESSION['User_Shops'][] = $row;
            $shop_found = 1;
            
            break;
        }
    }
    else $_SESSION['msg'][] = "can't Find User Shop In database.";
  }
  
  if($shop_found == 0) {
    $_SESSION['msg'][] = "User dose't Own shop or to work.";
    if(file_exists("Template/shop/Null_shop.php")) header("Location: Template/shop/Null_shop.php");
  if(file_exists("../Template/shop/Null_shop.php")) header("Location: ../Template/shop/Null_shop.php");
 if(file_exists("../../Template/shop/Null_shop.php")) header("Location: ../../Template/shop/Null_shop.php");
    exit;
  }
}
else $_SESSION['msg'][] = "There is Problame with User Shop Linke Lists.";
    
if (!($_SESSION['User_Shops']) && $shop_found == 0){
    if ($_SESSION['previous_page']){
    header("Location: ".array_pop($_SESSION['previous_page']));
    }
    else {
      $_SESSION['msg'][] = "user work shop not found";
        $_SESSION['on'] = 6;
        header("Location: /Home.php");
       }
    exit;
}

  $selected_company_id = $_SESSION['User_Shops'][0]['Shop_Id'];
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

if (!isset($ishome) or $_SESSION['on'] != 4){
    $_SESSION['on'] = 4;
    $protocol = isset($_SERVER['HTTPS']);
    $doman = $_SERVER['HTTP_HOST'];
    $currontDir = dirname($_SERVER['REQUEST_URI']);
    $redirectURL = $protocol .$doman .$currontDir;
    header("Location: ../../Home.php");
    exit; // Make sure to include exit after the header redirect
}


#Load Selected shope setting
#count(json_decode($_SESSION['User_Shops'][0]['Shop_items']))
$_SESSION['company_items_counted'] = $company_items_counted;




?>
<div class="Main">
    <div class="Shop_Profile_Info">
    
        <?php if(count($_SESSION['User_Shops']) && ($_SESSION['selected_company_id'] >= 0 || count($_SESSION['User_Shops']) == 1)){ 
            if (! $_SESSION['selected_company_id'] >= 0) $_SESSION['selected_company_id'] = 0;
            if (isset($_SESSION['User_Shops'][$_SESSION['selected_company_id']]) && $_SESSION['User_Shops'][$_SESSION['selected_company_id']]['Shop_name'] != "") {?>
                <div class="Profile_image">
                    <!--<img src="<?php echo "./Users_profile_Img/" . $_SESSION['User_Shops'][$_SESSION['selected_company_id']]['Shop_name'] . ".jpg"; ?>" alt="">-->
                    <img src="Img/Company/<?php echo $_SESSION['User_Shops'][$_SESSION['selected_company_id']]['Shop_Id']; ?>/<?php echo $_SESSION['User_Shops'][$_SESSION['selected_company_id']]['Shop_Id']; ?>_Logo.jpg"; alt="">
                    <h1 class="Shop_name"><?php echo $_SESSION['User_Shops'][$_SESSION['selected_company_id']]['Shop_name']." ".$_SESSION['User_Shops'][$_SESSION['selected_company_id']]['shop_type']; ?></h1>
                    <h2 class="Shop_brund_name"><?php echo $_SESSION['User_Shops'][$_SESSION['selected_company_id']]['Shop_name']." ".$_SESSION['User_Shops'][$_SESSION['selected_company_id']]['shop_type'];  ?></h2>
                </div>
                <Script>
                    const img = document.querySelector('body .Main .Shop_Profile_Info .Profile_image img');
                    const Shop_name = document.querySelector('body .Main .Shop_Profile_Info .Profile_image .Shop_name');
                    const Shop_brund_name = document.querySelector('body .Main .Shop_Profile_Info .Profile_image .Shop_brund_name');
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
                                    formData.append('Company_Id', "<?php echo $_SESSION['User_Shops'][0]['Shop_Id']; ?>");
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
               </script>
        <?php } 
        } else if (count($_SESSION['User_Shops'])){
            $shop_count = 0;?>
            <div class="MultProfile_image">
                <?php foreach ($_SESSION['User_Shops'] as $unselected_shop) {
                    if (isset($_SESSION['User_Shops'][$shop_count]) && $_SESSION['User_Shops'][$shop_count]['Shop_name'] != "") {?>
                        <img style="position: absolute; height: 90%;width: 150px;top:0;left:<?php echo $shop_count*2; ?>"  src="Img/Company/<?php echo $_SESSION['User_Shops'][$shop_count]['Shop_Id']; ?>/<?php echo $_SESSION['User_Shops'][$shop_count]['Shop_Id']; ?>_Logo.jpg"; alt="">        
                <?php } 
                    $shop_count +=1;
                } ?>
            </div>
            <Script>
                        const img = document.querySelector('body .Main .Shop_Profile_Info .Profile_image img');
                        const Shop_name = document.querySelector('body .Main .Shop_Profile_Info .Profile_image .Shop_name');
                        const Shop_brund_name = document.querySelector('body .Main .Shop_Profile_Info .Profile_image .Shop_brund_name');
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
                                        formData.append('Company_Id', "<?php echo $_SESSION['User_Shops'][0]['Shop_Id']; ?>");
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
                   </script>
            <?php } ?>
                   
        <div style="display: flex;\
                        flex-wrap: wrap;\
                        flex-direction: row;\
                        gap: 2.2rem;">
                <div class="company_rate_div">
                    <script>
                        function rate_company(rated) {
                            let formData = new FormData();
                            formData.append('Rate_Company', 'Rate_Company');
                            formData.append('Company_Id', "<?php echo $_SESSION['User_Shops'][0]['Shop_Id']; ?>");
                            formData.append('User_Id', "<?php echo $_SESSION['loged_user_info']['User_id']; ?>");
                            
                            formData.append('User_rated', rated+1);
                            fetchAjaxRequest('server/Company/Company_profile.php', "POST", formData, 
                            function (data){
                                console.log('fetchAjaxRequest data', data);
                                
                            }, function (error) { alert("error " + error); } );
                            console.log('going torate_company rated', rated);
                        }
                        const rateing_container = document.querySelector('body .Main .Shop_Profile_Info .company_rate_div');
                        create_ratting(rateing_container, '<?php echo count(json_decode($_SESSION['User_Shops'][0]['Shop_rate'])); ?>', rate_company);
                    </script> 
                    <h1 class="Shop_name">Since <?php echo explode('-', $_SESSION['User_Shops'][0]['Company_Started_Date'])[2]; ?></h1> 
                </div>
                <div>
                    <h1 class="Shop_name"><?php echo $company_items_counted; ?></h1>
                    <h1 class="Shop_name">Items</h1>
                </div>
                <div class="company_followers_div">
                <script>
                    function followe_company() {
                        let formData = new FormData();
                        formData.append('Followe_Company', 'Followe_Company');
                        formData.append('Company_Id', "<?php echo $_SESSION['User_Shops'][0]['Shop_Id']; ?>");
                        formData.append('User_Id', "<?php echo $_SESSION['loged_user_info']['User_id']; ?>");
                        
                        formData.append('User_Followe', '1');
                        fetchAjaxRequest('server/Company/Company_profile.php', "POST", formData, 
                        function (data){
                            console.log('fetchAjaxRequest data', data);
                            
                        }, function (error) { alert("error " + error); } );
                    }
                    </script> 
                    <input type="button" class="Follow_btn"value="+" onclick="followe_company();"></input>
                    <h1 class="Shop_name"><?php echo count(json_decode($_SESSION['User_Shops'][0]['Shop_followers'])); ?></h1>
                    <h1 class="Shop_name">Followers</h1>
                </div>
                <div>
                    <h1 class="Shop_name"><?php echo count(json_decode($_SESSION['User_Shops'][0]['Shop_workers'])); ?></h1>
                    <h1 class="Shop_name">WORKERS</h1>
                </div>
            </div>
            <div class="About_disc" style="width: 50%;">
                <h2>About</h2>
                <?php $shop_about_str = $_SESSION['User_Shops'][0]['Shop_about']; if(strlen($shop_about_str)>100){?>
                    <p class="Shopabout_Str_start"><?php echo substr($shop_about_str, 0, 100);?></p>
                    <p class="Shopabout_Str_end" style="display: none;"><?php echo substr($shop_about_str, 100);?></p>
                    <input type="button" class="Read_more_Shopabout"value="...Show More" ></input>
                <?php } else {?> <p class="Shopabout"><?php echo $shop_about_str;?></p> <?php }?>
                <Script>
                    const Shopabout_Str_start = document.querySelector('body .Main .Shop_Profile_Info .About_disc .Shopabout_Str_start');
                    const Shopabout_Str_end = document.querySelector('body .Main .Shop_Profile_Info .About_disc .Shopabout_Str_end');
                    const Read_more_Shopabout = document.querySelector('body .Main .Shop_Profile_Info .About_disc .Read_more_Shopabout');
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
            </div>

        <div class="profile_btn">
            <button class="shopprofiletablinks">Message</button>
            <!--<button class="shopprofiletablinks">Shear</button>-->
            
            <div class="contact_div">
                <div class="contact_container">

                </div>
            </div> 
            <script> 
                function Show_contacts() {
                    const contact_container = document.querySelector('body .Main .Shop_Profile_Info .profile_btn .contact_container');
                        console.log('going followe_company', contact_container);
                    if(contact_container.style.display == "block"){
                        console.log('going block');
                        while (contact_container.firstChild) contact_container.removeChild(contact_container.firstChild);
                        contact_container.style.display = "none";
                    }
                    else{
                        console.log('going none');
                        contact_container.style.display = "block";
                        create_contacts(contact_container, '<?php echo $_SESSION['User_Shops'][0]['Shop_contact']; ?>');
                    }
                    console.log('going followe_company', contact_container.style.display);
                }
            </script>
            <button class="shopprofiletablinks" onclick="Show_contacts();"; >Contact</button>
            <a href="Template/shop/Shop_page.php" class="shopprofiletablinks">Page</a>
            <a href="Logout.php" class="shopprofiletablinks">Log Out</a>
        </div>
        
    </div>

    <main>
        <div class="tab">
            <button class="shopprofiletablinks" onclick="openTab(event, 'shop_product_items_list_containers')">Shop Products</button>
            <button class="shopprofiletablinks" onclick="openTab(event, 'DocumentsTab')">Documents</button>
            <!--
            Shop_Payment_Tools
            
            <button class="shopprofiletablinks" onclick="openTab(event, 'FshopTab')">History</button>-->
            <!--<button class="shopprofiletablinks" onclick="openTab(event, 'OrderTab')">Orders</button>-->
            <button class="shopprofiletablinks" onclick="openTab(event, 'shopworkerstab')">Shop Workers</button>
            
            <button class="PaymentToolstablinks" onclick="openTab(event, 'PaymentToolstab')">Payment Tools</button>
            <button class="Actionstablinks" onclick="openTab(event, 'Actionstab')">Actions</button>
            <button class="Permationstablinks" onclick="openTab(event, 'Permationstab')">Permations</button>
            <button class="viewprofiletablinks" onclick="openTab(event, 'user_list_shop_div_id')">Meange Shops</button>
        </div>
        
        <div id="shop_product_items_list_containers" class="shop_product_items_list_container shopprofiletabcontent">
          <div class='product_menu'>
                <button class="shopprofiletablinks new_prd_btn" onclick="show_product_form()">Add New</button>
                <button class="shopprofiletablinks mul_new_prd_btn" onclick="show_Multy_product_form()">Multy Add New</button>
              </div>
              <div class='New_form' style="display:none;">
                <?php include 'Template/shop/Add_Products.php'; ?> 
              </div>
              <div class='Multy_New_form' style="display:none;">
                <?php include 'Template/shop/Multy_Add_Products.php'; ?> 
              </div>
              <div class="list_prd_frame">
                  <script>
                    const shop_list_container = document.querySelector('body .Main main .shop_product_items_list_container .list_prd_frame');
                    create_list(shop_list_container, 'ITEMS', 1, "", "", "V-BOX-EDITLIST", "SHOP_ITEMS", "", 0, '<?php echo $_SESSION['User_Shops'][0]['Shop_Id']; ?>');
                  </script>
              </div>
        </div>
        
        <div id="DocumentsTab" class="DocumentsTab shopprofiletabcontent">
            
        </div>
        
        <div id="user_list_shop_div_id" class="viewprofiletabcontent shopprofiletabcontent">
        
        </div>


        <div id="shopworkerstab" class="Shop_workerstabcontent shopprofiletabcontent">
        </div>

        <div id="PaymentToolstab" class="Shop_Payment_Toolstabcontent shopprofiletabcontent">      
        </div>

        <div id="Actionstab" class="Shop_Promotionstabcontent shopprofiletabcontent">
        
        </div>

        <div id="Permationstab" class="Shop_Permationstabcontent shopprofiletabcontent">  
        
        </div>

        <div id="OrderTab" class="shopprofiletabcontent">
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

        <div id="customerInfoTab" class="shopprofiletabcontent">
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
</div>
<script>
  function show_product_form(){
    const formB = document.querySelector("body .Main main .shop_product_items_list_container .New_form");
    const checkButton = document.querySelector("body .Main main .shop_product_items_list_container .product_menu .new_prd_btn");
    const buttonText = checkButton.textContent;
    if (buttonText === "Add New") { 
      formB.style.display = "block"; 
      checkButton.textContent = "Done";
    } else if (buttonText === "Done") { 
      formB.style.display = "none"; 
      checkButton.textContent = "Add New";
    }
  }
  function show_Multy_product_form(){
    const formB = document.querySelector("body .Main main .shop_product_items_list_container .Multy_New_form");
    const checkButton = document.querySelector("body .Main main .shop_product_items_list_container .product_menu .mul_new_prd_btn");
    const buttonText = checkButton.textContent;
    if (buttonText === "Multy Add New") { 
      formB.style.display = "block"; 
      checkButton.textContent = "Done";
    } else if (buttonText === "Done") { 
      formB.style.display = "none"; 
      checkButton.textContent = "Multy Add New";
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
        const selectedtab = document.getElementById(tabName);
        selectedtab.style.display = "block";
        selectedtab.classList.add("active");

        // Check if the selected tab's innerHTML is empty
        if (selectedtab.innerHTML.trim() === "") { // Use a single '=' to set and '===' to compare
            let url = '';
            switch(tabName){
                //case 'shop_product_items_list_containers':
                    //selectedtab.innerHTML = ``;
                    //break;
            
                case 'DocumentsTab':
                    url = 'Template/Documents/Documents.php';
                    break;
            
                case 'shopworkerstab':
                    url = 'Template/shop/List_shop_workers.php'; 
                    break;
            
                case 'PaymentToolstab':
                    url = 'Template/shop/Shop_Payment_Tools.php'; 
                    break;
            
                case 'Actionstab':
                    url = 'Template/shop/Shop_Promotions.php'; 
                    break;
            
                case 'Permationstab':
                    url = 'Template/shop/Shop_Permations.php'; 
                    break;
            
                case 'user_list_shop_div_id':
                    url = 'Template/shop/List_my_shop.php'; 
                    break;
            }
            if(url !== ''){
                try {
                    fetch(url).then((response) => {
                        if(response.ok) return response.text();
                        else console.log('Network response was not ok');
                        
                    }).then((data) => { 
                        selectedtab.innerHTML = data;

                        const scripts = selectedtab.getElementsByTagName('script');
                        for(let script of scripts){
                            console.log('Loading file script.innerHTML : ', script);
                            eval(script.innerHTML);
                        }
                        selectedtab.datasetloaded = 'true';
                    })
                    .then((error) => { console.log('Error fetch content : ', error);});
                } catch (error) {
                    console.log('Error Loading file : ', error);
                }
            }
        }
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

    body .Main .Shop_Profile_Info .MultProfile_image {
        width: 25%;
        height: 125px;
        text-align: center;
        top: 5px;
        border-image: round;
        /* display: flex; */
        position: relative;
    }

    body .Main .Shop_Profile_Info .MultProfile_image img {
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