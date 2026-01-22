<?php
   if (session_id() == "") session_start();

	$Company_Actions = "server/Company/Company_Actions.php";
	
	if(file_exists("server/Company/Company_Actions.php")) $Company_Actions = "server/Company/Company_Actions.php";
	if(file_exists("../server/Company/Company_Actions.php")) $Company_Actions = "../server/Company/Company_Actions.php";
	if(file_exists("../../server/Company/Company_Actions.php")) $Company_Actions = "../../server/Company/Company_Actions.php";

	$Company_profile = "server/Company/Company_profile.php";
	
	if(file_exists("server/Company/Company_profile.php")) $Company_profile = "server/Company/Company_profile.php";
	if(file_exists("../server/Company/Company_profile.php")) $Company_profile = "../server/Company/Company_profile.php";
	if(file_exists("../../server/Company/Company_profile.php")) $Company_profile = "../../server/Company/Company_profile.php";


	$Shop_Profile = "Template/shop/Shop_Profile.php";
	
	if(file_exists("Template/shop/Shop_Profile.php")) $Shop_Profile = "Template/shop/Shop_Profile.php";
	if(file_exists("../Template/shop/Shop_Profile.php")) $Shop_Profile = "../Template/shop/Shop_Profile.php";
	if(file_exists("../../Template/shop/Shop_Profile.php")) $Shop_Profile = "../../Template/shop/Shop_Profile.php";

  # include 'Template/shop/shop_actions.php';

   $user_owend_shops = [];
   if(!isset($conn)){
      $protocol = isset($_SERVER['HTTPS']);
      $doman = $_SERVER['HTTP_HOST'];
      $currontDir = dirname($_SERVER['REQUEST_URI']);
      $DIRPATHS = explode('/', $currontDir);
      $redirectURL = $protocol .$doman .$currontDir;
      //include($_SERVER['DOCUMENT_ROOT']."/".$DIRPATHS[1].'/config.php');
      include("../../config.php");
      if(!isset($conn)) exit;
  }
?>

<div class="controller_bar">
<button class="btn new_shop_btn">New</button>
</div>

<div class="add_container">
   <section>
      <form action='<?php echo $Company_Actions;?>' method="post" class="add-shop-form" enctype="multipart/form-data">

      <h3>Add Shop</h3>
         <div class="input_table">
            <input type='text'class='input-filed input-ln box' placeholder='Shop Name'value="test"name="register_sname"required>
            <input type='text'class='input-filed input-ln box_0'value="test00"placeholder='Brand Name'name="register_bname"required>
            <input type='text'class='input-filed bo'placeholder='Type'value="Shop"name="register_type"required>
            <input type='email'class='input-filed'placeholder='Email'value="test@gmail.com"name="register_email"required>
            <input type='text'class='input-filed' placeholder='Country'value="Country"name="register_country"required>
            <input type='number'class='input-filed'placeholder='Phone Number'value="0000"name="register_phone_No"required>
            <input type='text'class='input-filed'placeholder='Location'value="Location"name="register_location"required>
            <input type='password'class='input-filed'value="111"placeholder='Enter Password'name="register_password"required>
            <input type='password'class='input-filed'value="111"placeholder='Congirm Password'name="register_cpassword"required>
            <input type='checkbox' checked="true"id='user_list_shop_checkbox_id' class='check-box'><span>I agree to the terms and conditions</span></input>
            <button type='button'id='user_list_shop_btn_id'class='btn submitbtn' disabled="true" name="Create_New_Shop">Create New Shop</button>
         </div>
      </form>
   </section>
</div>

<section class="display-shops-table"></section>


<script>

	function load_table(user_shops){
	  console.log("staring  load_table : ", user_shops);
	    let item_infos = JSON.parse(user_shops);
		for (let index = 0; index < item_infos.length; index++) {
			const shop_id = item_infos[index][0];
		    console.log("shop_id : ", shop_id);
			let formData = new FormData();
			formData.append('Get_Company_By_Id', 'Get_Company_By_Id');
			formData.append('Company_Id', shop_id);
			let pagepath = window.location.pathname;
			let pathparts = pagepath.split('/').filter(Boolean);

			const beseUrl = `${window.location.protocol}//${window.location.host}//${pathparts[0]}//`;
			console.log("beseUrl ", beseUrl);
			const Company_profile = '<?php echo $Company_profile; ?>';
			console.log("Company_profile ", beseUrl + Company_profile);
	        fetch(Company_profile, {
			  method : "POST",
			  body : formData
			}).then((response) =>response.json()).then((data) => {
	            console.log("item_infos ++++++", data);

	            const tbody = table.createTBody();
	            for (let sti=0; sti < data.items.length; sti++) { 
		            const selected_shop = data.items[sti];
		            console.log("item_infos ++", selected_shop);
		            console.log("item_infos ++", selected_shop['Shop_Id']);
		            console.log("item_infos ++", shop_id);
		            if(selected_shop['Shop_Id'] == shop_id){
		                console.log("LLLLL ", item_infos[index]);
		                const tr = tbody.insertRow();
		                tr.addEventListener('click', function() {
			                let parent_tbody = tbody.parentElement;
			                if (tbody.style.backgroundColor != "lightblue") {
			                    for (let index = 0; index < parent_tbody.childNodes.length; index++) {
			                        const element = parent_tbody.childNodes[index];
			                        if(element.tagName == "TBODY") {
			                            element.style.backgroundColor = '';
		                             // hide showne edit elements
			                        }
			                     }
			                     tbody.style.backgroundColor = 'lightblue';
			                }
			                //else { TOFO MAKE EDIT SHOEW AFTER SELECTUON}
		               });
		               const Image = tr.insertCell();
		               Image.textContent = "Image here";
		               const td_shop_name = tr.insertCell();
	                   td_shop_name.textContent = selected_shop['Shop_name'];
		               const td_shop_brand = tr.insertCell();
		               td_shop_brand.textContent = selected_shop['Shop_brand_name'];
                       const td3 = tr.insertCell();
			           if(item_infos[index][3] == '10'){
						   td3.textContent = "Owener";
					   }
					   else td3.textContent = item_infos[index];
						 
						const td4 = tr.insertCell();
						var form = document.createElement('form');
						form.action = 'Template/shop/View_shop_Profile.php';
						form.method = 'post';
						form.enctype="multipart/form-data";
		            	  
		            	  
						td4.appendChild(form);
						
						const delet_btn = document.createElement('a');
						form.appendChild(delet_btn);
						delet_btn.href ="?delete_shop=1&register_shop_id="+shop_id;
						delet_btn.classList.add("delete-btn");
						delet_btn.onclick="return confirm('Are you sure you want to delete this?')";
						const delet_bi = document.createElement('i');
						
						delet_bi.textContent ="delete";
						delet_btn.appendChild(delet_bi);

						
						const enabl_or_disable_shop = document.createElement('a');
						form.appendChild(enabl_or_disable_shop);
						enabl_or_disable_shop.name="enabl_or_disable_shop";
						enabl_or_disable_shop.classList.add("option-btn");
						
						if(item_infos[index][4] == '1'){
							const view_btn = document.createElement('a');
							form.appendChild(view_btn);
							view_btn.href = '<?php echo $Shop_Profile ?>' +"?Selected_sid="+shop_id;
							view_btn.name ="Selected_shop_viewe";
							view_btn.textContent ="View";
							view_btn.classList.add("option-btn");
							/*view_btn.addEventListener('click', function() {
								let viewformData = new FormData();
								viewformData.append('Selecte_Company_By_Id', 'Get_Company_By_Id');
								viewformData.append('Company_Id', shop_id);
								
								fetch(Company_profile, {
									method : "POST",
									body : viewformData
								}).then((response) =>response.json()).then((viewdata) => {
									console.log("view viewdata", viewdata);
									window.location.href = "Template/shop/Shop_Profile.php";
									//header("Location: /Template/shop/Shop_Profile.php");
									//exit;
								}).then((error) => { console.log('Error1 fetch content : ', error);});
							});*/

							enabl_or_disable_shop.textContent ="Disable";
							enabl_or_disable_shop.href ="?enabl_or_disable_shop=1&register_enabl_or_disable=0&register_shop_id="+shop_id;
						}
	                    else {
	                      enabl_or_disable_shop.textContent ="Enable";
			            	    enabl_or_disable_shop.href ="?enabl_or_disable_shop=1&register_enabl_or_disable=1&register_shop_id="+shop_id;
	                    }
					}
	            }
			}).then((error) => { console.log('load_table Error0 fetch content : ', error);});
      }
}

	<?php
	 $user_shop_count = 0;
   if($_SESSION['loged_user_info'] && $_SESSION['loged_user_info']['user_shops'] != "") { 
      ?>
      var user_shops = '<?php echo $_SESSION['loged_user_info']['user_shops']; ?>';
      console.log("goning to load_table :");
	  load_table(user_shops);
   <?php } ?>
console.log("Done load_table :");
  const submitButton = document.querySelector(".add-shop-form .submitbtn");
  function add_New_shop(){
    console.log("add_New_shop :");
   const form = document.querySelector('.add-shop-form');
    const defaultFormData = new FormData(form); // create a new form data object with default values
    const formData = new FormData(); // create a new form data object
    formData.append("Create_New_Shop", "Create_New_Shop");
          // Merge the default form data with the image data
      for (const [key, value] of defaultFormData.entries()) {
         formData.append(key, value);
         console.log("defaultFormData => key : "+key+" value : "+ value);
      }
     // Submit the form using AJAX
     console.log("in add shop form.action :"+form.action); 
     try {
		fetch(form.action, {
		      method : "POST",
		      body : formData
		  }).then((response) =>response.json()).then((data) => { 

           console.log( '<< data', data); 
			if(data.status == 'Success'){
			  load_table(data.Success);
			}
        })
        .then((error) => { console.log('add_New_shop Error0 fetch content : ', error);});

    } catch (error) {
        console.log('Error Loading file : ', error);
    }
    
      console.log("in add shop list form :"+[...formData]);
      //clear_all();
 }

  submitButton.addEventListener("click", function() {add_New_shop(); 
    }); 




  const form = document.querySelector(".add-shop-form"); 
  
  const inputs = form.querySelectorAll("input[required]");
  function checkFormValidity() { 
    console.log("checkFormValidity ");
    let allValid = true; 
     inputs.forEach(input => { 
     if (!input.value.trim()) { allValid = false; } });
     if(!allValid) submitButton.style.backgroundColor = "gray";
     else submitButton.style.backgroundColor = "green";
     submitButton.disabled = !allValid;
     
    } 
    inputs.forEach(input => { 
      input.addEventListener("input", function() { checkFormValidity();
      }); 
    }); 
    // Initial check in case the form is pre-filled 
    checkFormValidity(); 
   
  
const user_list_shop_div_id = document.querySelector("#user_list_shop_div_id");
  var newInputWrapper = document.createElement('div');
  newInputWrapper.className = "fileInputWrapper";
  newInputWrapper.style.border = '1px solid #ccc';
  newInputWrapper.style.overflowX = 'auto';
  user_list_shop_div_id.appendChild(newInputWrapper);
  
  const table = document.createElement('table');
	newInputWrapper.appendChild(table);
	
	table.setAttribute('border', '1');
	//user_list_shop_div_id.style.display = "block";
	table.style.borderCollapse = 'collapse'; // = 'auto-fit';
	table.style.borderSpacing = '0'; // = 'auto-fit';
	table.style.borderRadius = '12px 12px 0 0'; // = 'auto-fit';
	//table.style.overflow = 'hidden'; // = 'auto-fit';
	table.style.boxShadow = '0 12px 12px rgba(32, 32, 32, .3)'; // = 'auto-fit';
	table.style.background = '#fafafa'; // = 'auto-fit';
	table.style.textAlign = 'center'; // = 'auto-fit';

	// Create table header
	const header = table.createTHead();
	const headerRow = header.insertRow();
	["Shop image", "Shop name", "Shop brand", "User Activity", "action"].forEach(headerText => {
		const th = document.createElement('th');
		th.style.padding = '12px 15px'; // = 'auto-fit';
		th.style.backgroundColor = '#333'; // = 'auto-fit';
		th.style.color = '#fff'; // = 'auto-fit';
		th.style.textAlign = 'center'; // = 'auto-fit';
		const text = document.createTextNode(headerText);
		th.appendChild(text);
		headerRow.appendChild(th);
	});
	
   
const checkButton = document.querySelector(".controller_bar .new_shop_btn");
const formB = document.querySelector(".add-shop-form"); 

checkButton.addEventListener("click", function() {  
const buttonText = checkButton.textContent;

if (buttonText === "New") { 
formB.style.display = "block"; 
checkButton.textContent = "Done";
} else if (buttonText === "Done") { 
formB.style.display = "none"; 
checkButton.textContent = "New";
}});

/*let image_file_name = [];

<tbody>


         
            $Shop_items_list = json_decode($Shop_item_info[1]);   
            $found = 0;
            $count = count($Shop_items_list);
            echo "count ".$count;
            $select_shop = [];
            if(isset($_SESSION['Shops_Table'])) $select_shop = $_SESSION['Shops_Table'];
            for ($i=0; $i < $count; $i++) { 
               $shop_s = $Shop_items_list[$i];
               
               /*if(mysqli_num_rows($found_shop) > 0){
                  while($row = mysqli_fetch_assoc($found_shop)){
                     $user_shop_count += 1;
                     $user_owend_shops[] = $row;?>
                     <tr>
                        <td><img src=<php //echo "Img/products/".str_replace(' ', '/', $row['type'])."/".str_replace(' ', '_', $row['name'])."/".$row['code'] ."/".$row['image']; ?> height="100" alt=""></td>
                        <td><php echo $row['Shop_name']; ?></td>
                        <td><php echo $row['Shop_brand_name']; ?></td>
                        <td><php echo 'Owens'; ?></td>
                        <td>
                       
                        </td>
                     </tr>
                  <php };    
               }
            }
         } */
         /*// list working shop
         if($_SESSION['loged_user_info'] && $_SESSION['loged_user_info']['User_work_shop'] != "") {
           $shops = explode("),", $_SESSION['loged_user_info']['User_work_shop']);
           foreach ($shops as $key => $Value) {
            $shop_s = explode(",", $Value);
            $shop_id = str_replace('(', '', $shop_s[0]);
             $found_shop = mysqli_query($conn, "SELECT * FROM `Shops` WHERE Shop_Id ='$shop_id'");
               if(mysqli_num_rows($found_shop) > 0){
               while($row = mysqli_fetch_assoc($found_shop)){
                $user_shop_count += 1;
                $user_owend_shops[] = $row;?>
               <tr>
                  <td><img src=<php //echo "Img/products/".str_replace(' ', '/', $row['type'])."/".str_replace(' ', '_', $row['name'])."/".$row['code'] ."/".$row['image']; ?> height="100" alt=""></td>
                  <td><php echo $row['Shop_name']; ?></td>
                  <td><php echo $row['Shop_brand_name']; ?></td>
                  <td><php echo 'Working'; ?></td>
                  <td>
                     <form action="" method="post" enctype="multipart/form-data">   

                     <a href="?delete_user=1&register_user_id=<php echo $row['_Id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to Remove this Worker?');"> <i class="fas fa-trash"></i> Remove </a>

                     <php if ($shop_s[1] == '1'){ ?>
                     <a href="?enabl_or_disable_user=1&register_enabl_or_disable=0&register_user_id=<php echo $row['user_Id']; ?>" class="option-btn" name="enabl_or_disable_user"> Disable </a>
                     <a href="Template/shop/Shop_Profile.php?Selected_sid=1&user_shop_id=<php echo $row['Shop_Id']; ?>" name="Selected_sid" class="option-btn"> View </a> 
                     <php }
                     else{ ?>
                        <a href="?enabl_or_disable_user=1&register_enabl_or_disable=1&register_user_id=<php echo $row['user_Id']; ?>" class="option-btn" name="enabl_or_disable_user"> Enable </a>
                     <php } ?>
                     </form>
                  </td>
               </tr>
         <php
            };    
            }
         }
         }
      </tbody>
      */
</script>

<style>
.controller_bar .new_shop_btn{
    background-color: green;
}

.add-shop-form{
    max-width: 90rem;
    background-color: var(--bg-color);
    border-radius: .5rem;
    padding:2rem;
    margin:0 auto;
    margin-top: 2rem;
    display: none;
}

.add-shop-form .submitbtn{
    background-color: green;
}

/* Edit and delete button styling */
.delete-btn,
.option-btn,
.edit-btn {
   color: #fff;
   padding: 5px 10px;
   border-radius: 5px;
   cursor: pointer;
   text-decoration: none;
   transition: background-color 0.3s;
}

.delete-btn {
   background-color: #e74c3c;
   margin-right: 10px;
}

.option-btn {
   background-color: #3498db;
}

.edit-btn{
   background-color: red;
   margin-right: 10px;
}

.delete-btn:hover,
.option-btn:hover,
.edit-btn {
  
   background-color: #333;
}

/* Empty table message styling */
.empty {
   margin-bottom: 20px;
   text-align: center;
   background-color: #f0f0f0;
   color: #333;
   font-size: 18px;
   padding: 15px;
   border-radius: 5px;
   
    margin-bottom: 2rem;
    text-align: center;
    background-color: var(--bg-color);
    color:var(--black);
    font-size: 2rem;
    padding:1.5rem;
}

.add-product-form h3{

    font-size: 2.5rem;

    margin-bottom: 1rem;

    color:var(--black);

    text-transform: uppercase;

    text-align: center;

 }

 

 .add-product-form .input_table{

    width: 100%;

    display: gred;

 } 



 .add-product-form .input-filed{

    text-transform: none;

    padding:1.2rem 1.4rem;

    border-radius: 2.5rem;

    color:var(--black);

    border-radius: 2.5rem; 

    background-color: var(--white);

    margin:1rem 0;

 }

 .add-product-form .input-filed{

   text-transform: inherit;

    padding: 1.1rem 3.1rem;

    font-size: 1.7rem;

    color: var(--black);

    border-radius: 2.5rem;

    background-color: var(--white);

    margin: 1rem 0;

    width: 40%;

 }



 .add-product-form .box_1{

    text-transform: inherit;

    padding:6.1rem 3.1rem;

    font-size: 1.7rem;

    color:var(--black);

    border-radius: 2.5rem;

    background-color: var(--white);

    margin:1rem 0;

    width: 100%;

 }



 .display-product-table table{

    width: 100%;

    text-align: center;

 }

 

 .display-product-table table thead th{

    padding:1.5rem;

    font-size: 2rem;

    background-color: var(--black);

    color:var(--white);

 }

 

 .display-product-table table td{

    padding:1.5rem;

    font-size: 2rem;

    color:var(--black);

 }

 

 .display-product-table table td:first-child{

    padding:0;

 }

 

 .display-product-table table tr:nth-child(even){

    background-color: var(--bg-color);

 }

/* Container styling */
.add_container {
   display: flex;
   flex-direction: column;
   align-items: center;
   padding: 20px;
}

/* Add product form styling */
.add-product-form {
   max-width: 800px;
   background-color: white;
   border-radius: 10px;
   padding: 20px;
   margin: 20px 0;
   box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.add-product-form h3 {
   font-size: 24px;
   margin-bottom: 20px;
   color: #333;
   text-transform: uppercase;
   text-align: center;
}

.input_table {
   width: 100%;
}

.input-filed {
   padding: 10px 15px;
   border-radius: 5px;
   border: 1px solid #ccc;
   margin: 10px 0;
   width: 100%;
}

.box_1 {
   padding: 20px 15px;
   font-size: 18px;
}

.qty_box {
   width: 100%;
   display: flex;
   align-items: center;
   justify-content: space-between;
}

.p_qty_class {
   width: 25%;
   margin-right: 10px;
}

.qty_btn {
   background-color: #3498db;
   color: white;
   border: none;
   padding: 5px 10px;
   border-radius: 5px;
   cursor: pointer;
}

.combox1 {
   padding: 10px;
   border-radius: 5px;
   border: 1px solid #ccc;
   margin-right: 10px;
   width: 40%;
}

/* Table styling */
.display-product-table table {
   width: 100%;
   text-align: center;
   border-collapse: collapse;
   margin-top: 20px;
}

.display-product-table table th,
.display-product-table table td {
   padding: 15px;
   font-size: 18px;
   border-bottom: 1px solid #ccc;
}

.display-product-table table th {
   background-color: #333;
   color: white;
}

.display-product-table table tr:nth-child(even) {
   background-color: #f0f0f0;
}

/* Edit form container styling */
.edit-form-container {
   display: none;
   justify-content: center;
   align-items: center;
   position: fixed;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background-color: rgba(0, 0, 0, 0.5);
   z-index: 999;
}

.edit-form-container form {
   background-color: white;
   padding: 20px;
   border-radius: 10px;
   box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

/* Image box styling */
.img_box {
   display: flex;
   align-items: center;
   margin-top: 10px;
}

.img_box img {
   height: 200px;
   margin-right: 20px;
}

/* Button styling */
.btn {
   background-color: green;
   color: white;
   border: none;
   padding: 10px 20px;
   border-radius: 5px;
   cursor: pointer;
   font-size: 18px;
   margin-top: 10px;
}


/* Table styling */
.display-product-table {
   margin-top: 20px;
}

.display-product-table table {
   width: 100%;
   text-align: center;
   border-collapse: collapse;
   margin-top: 20px;
}

.display-product-table table th,
.display-product-table table td {
   padding: 15px;
   font-size: 18px;
   border-bottom: 1px solid #ccc;
}

.display-product-table table th {
   background-color: #333;
   color: white;
}

.display-product-table table tr:nth-child(even) {
   background-color: #f0f0f0;
}

</style>