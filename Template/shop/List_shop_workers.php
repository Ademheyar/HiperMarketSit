<?php
if (session_id() == "") session_start();
if (file_exists("config.php")) include("config.php");
if (file_exists("../../config.php")) include("../../config.php");
// include 'Template/shop/shop_actions.php';

if (!isset($conn)) {
    $protocol = isset($_SERVER['HTTPS']) ? "https://" : "http://";
    $domain = $_SERVER['HTTP_HOST'];
    $currentDir = dirname($_SERVER['REQUEST_URI']);
    $redirectURL = $protocol . $domain . $currentDir;
    include("../../config.php");
    if (!isset($conn)) exit;
}
?>



<div class="new_worker_controller_bar">
<button class="btn new_worker_btn">Request worker</button>
</div>

<section>
<form action="" method="post" class="add-worker-form" enctype="multipart/form-data">
   <h3>Add Worker</h3>
   <div class="input_table">
         <input type='text'class='input-filed input-ln box' placeholder='Name'name="get_name">
      <input type='email'class='input-filed'placeholder='Email'name="get_email">
      <input type='number'class='input-filed'placeholder='Phone Number'name="get_phone_No">
      
      <h3>Or use link</h3>

         <input type='text'class='input-filed'placeholder='Worker Link'name="get_link">
      <button type='submit'class='btn' name="request_worker">Send</button>
   </div>
</form>
</section>

<script>
const shopworkers_formB = document.querySelector(".add-worker-form"); 
const shopworkers_checkButton = document.querySelector(".new_worker_controller_bar .new_worker_btn");

shopworkers_checkButton.addEventListener("click", function() {  
const shopworkers_buttonText = shopworkers_checkButton.textContent;

if (shopworkers_buttonText === "Request worker") { 
shopworkers_formB.style.display = "block"; 
shopworkers_checkButton.textContent = "Done";
} else if (shopworkers_buttonText === "Done") { 
shopworkers_formB.style.display = "none"; 
shopworkers_checkButton.textContent = "Request worker";
}});
</script>


<section class="display_shop_workers">
  <h2>Shop Workers</h2>
  <div class="user_list_shop_div_id"></div>
</section>

<script>
    const user_list_shop_div_id = document.querySelector("body .Main main .Shop_workerstabcontent .display_shop_workers .user_list_shop_div_id");
    const submitBtn = document.getElementById("submitBtn");

function fetchShopWorkersForAllShops() {
        function display_newdata(tooldata){
             const tableContainer = document.querySelector("body .Main main .Shop_workerstabcontent .display_shop_workers .user_list_shop_div_id");
             tableContainer.style.backgroundColor = "#fff";
          tableContainer.style.padding = "20px";
          tableContainer.style.borderRadius = "10px";
            tableContainer.style.display = "grid";
          tableContainer.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.1)";
          tableContainer.style.overflow = "overlay";
          tableContainer.style.width = "100%";
          tableContainer.style.margin = "20px auto";
            tableContainer.innerHTML = ''; // Clear existing table if any

            const table = document.createElement("table");
            table.className = 'table';
            
            const thead = document.createElement("thead");
            const headerRow = document.createElement("tr");

            const headers = [
                "Workers Image",  "Workers Name", 
                "Workers State", "action"];

            headers.forEach(header => {
                const th = document.createElement("th");
                th.textContent = header;
                headerRow.appendChild(th);
            });

            thead.appendChild(headerRow);
            table.appendChild(thead);

            const tbody = document.createElement("tbody");
            tooldata.forEach(worker => {
                const row = document.createElement("tr");

                const img = document.createElement("td");
                img.textContent = 'imgs';
                row.appendChild(img);

				const name = document.createElement("td");
                name.textContent = worker[1];
                row.appendChild(name);

				const state = document.createElement("td");
           		state.textContent = worker[3][0];
                row.appendChild(state);

				const action = document.createElement("td");
           	
           	const on_off = document.createElement("td");
           		on_off.textContent = worker[2]? "Enabled":"Disable";
                action.appendChild(on_off);
                
                const remove = document.createElement("td");
           		remove.textContent = "Remove";
                action.appendChild(remove);
                
                const view = document.createElement("td");
           		view.textContent = "View";
                action.appendChild(view);
           		/*
           		 <input type="hidden" name="register_user_id" value=<?php //echo $row['user_id']; ?> >
                 <input type="hidden" name="register_enabl_or_disable" value=<?php //echo $row['user_isenabled']; ?> >

           		<a href="?delete_user=1&register_user_id=<?php echo $row['_Id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to Remove this Worker?');"> <i class="fas fa-trash"></i> Remove </a>
				f ($Value[1] == '1'){ 
                <a href="?enabl_or_disable_user=1&register_enabl_or_disable=0&register_user_id=<?php echo $row['user_Id']; ?>" class="option-btn" name="enabl_or_disable_user"> Disable </a>
                 }
                 else{ 
                  <a href="?enabl_or_disable_user=1&register_enabl_or_disable=1&register_user_id=<?php echo $row['user_Id']; ?>" class="option-btn" name="enabl_or_disable_user"> Enable </a>
                 } 
                 <a href="Template/shop/Shop_Profile.php?Selected_sid=1&user_shop_id=<?php echo $row['Shop_Id']; ?>" name="Selected_sid" class="option-btn"> View </a>
                   */
           		
                row.appendChild(action);
                
                tbody.appendChild(row);
            });

            table.appendChild(tbody);
            tableContainer.appendChild(table);
        }
        
        console.log("fetchPaymentToolsForAllShops");
        const formData = new FormData();
        formData.append('Shop_Worker_action', 'get_Shop_Worker_for_all_shops');
        
        fetch('../../server/Company/Company_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("0 fetched data", data);
            if (data.allshopworkers) {
               display_newdata(data.allshopworkers);
            } else {
                alert("Errort0d1: " + data.message);
            }
        })
        .catch(error => {
            fetch('../server/Company/Company_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log("1 fetched data", data);
                if (data.allshopworkers) {
                   display_newdata(data.allshopworkers);
                } else {
                    alert("Errort0d1: " + data.message);
                }
            })
            .catch(error => {
                fetch('server/Company/Company_profile.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("2 fetched data", data);
                    if (data.allshopworkers) {
                       display_newdata(data.allshopworkers);
                    } else {
                        alert("Errort0d1: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Errort0d2: ", error);
                    alert("Errort0d2: " + error);
                });
            });
        });
    }


    // Call fetchShopWorkersForAllShops when the page loads or when needed
    fetchShopWorkersForAllShops();  


    submitBtn.addEventListener("click", function() {

        // Form Data
        const shopId = document.querySelector(".Shopcombobox").value;
        const Methodscombobox = document.getElementById('register_mname').value;
        const register_sname = document.getElementById('register_sname').value;
        const register_tname = document.getElementById('register_tname').value;
        const register_No = document.getElementById('register_No').value;
        const register_location = document.getElementById('register_location').value;
        const register_password = document.getElementById('register_password').value;
        const register_cpassword = document.getElementById('register_cpassword').value;
        const enable_payment = document.getElementById('enable_payment').checked ? '1' : '';
        const quick_payment = document.getElementById('quick_payment').checked ? '1' : '';
        const customer_required = document.getElementById('customer_required').checked ? '1' : '';
        const print_slip = document.getElementById('print_slip').checked ? '1' : '';
        const mark_as_paid = document.getElementById('mark_as_paid').checked ? '1' : '';
        const open_cash_drawer = document.getElementById('open_cash_drawer').checked ? '1' : '';

        console.log("submit clicked", shopId);
        console.log("submit clicked", Methodscombobox);
        // Validation
        if (!Methodscombobox || !shopId || !register_sname || !register_tname || !register_No || !register_location || !register_password || !register_cpassword) {
            alert("All fields are required.", Methodscombobox);
            return;
        }

        const formData = new FormData();
        formData.append('payment_tool_action', 'save_payment_tool');
        formData.append('Company_Id', shopId);
        formData.append('Methodscombobox', Methodscombobox);
        formData.append('register_sname', register_sname);
        formData.append('register_tname', register_tname);
        formData.append('register_No', register_No);
        formData.append('register_location', register_location);
        formData.append('register_password', register_password);
        formData.append('register_cpassword', register_cpassword);
        formData.append('enable_payment', enable_payment);
        formData.append('quick_payment', quick_payment);
        formData.append('customer_required', customer_required);
        formData.append('print_slip', print_slip);
        formData.append('mark_as_paid', mark_as_paid);
        formData.append('open_cash_drawer', open_cash_drawer);

        fetch('../../server/Company/Company_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("submit data", data);
            if (data.payment_tools) {
                fetchShopWorkersForAllShops();
            } else {
                alert("Errort0l0: " + data.message);
            }
        })
        .catch(error => {
            console.error("Errort0l1: ", error);
            alert("Errort0l1: " + error);
        });
    });
</script>
<style>
.add-worker-form {
    padding: 20px;
}

.btn.new_shop_btn {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.btn.new_shop_btn:hover {
    background-color: #0056b3;
}

.add-worker-form {
    background-color: #f9f9f9;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: none;
    width: 100%;
}

.add-worker-form h3 {
    margin-bottom: 20px;
}

.input-field, .check-box, .btn {
    margin: 10px 0;
    width: calc(100% - 20px);
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.checkboxes label {
    display: block;
    margin: 5px 0;
}

.btn {
    background-color: #28a745;
    color: white;
    border: none;
    cursor: pointer;
}

.btn:hover {
    background-color: #218838;
}

.fileInputWrapper {
    padding: 20px;
    margin: 20px 0;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #fafafa;
}

.display-shopPaymentTools-table {
    max-width: 100%;
    overflow-x: auto;
}

.display-shopPaymentTools-table table {
    width: 100%;
    border-collapse: collapse;
}

.display-shopPaymentTools-table th, .display-shopPaymentTools-table td {
    padding: 12px;
    text-align: center;
}

.display-shopPaymentTools-table th {
    background-color: #333;
    color: white;
}

.delete-btn, .option-btn {
    margin: 5px;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}

.delete-btn {
    background-color: #dc3545;
    color: white;
}

.option-btn {
    background-color: #007bff;
    color: white;
}

.controller_bar    background-color: green;
}

.add-worker-form{
    max-width: 90rem;
    background-color: var(--bg-color);
    border-radius: .5rem;
    padding:2rem;
    margin:0 auto;
    margin-top: 2rem;
    display: none;
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
   background-color: #3498db;
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








<div class="add_container">

<sectsectionion class="display-shops-table">
   <table>

      <tbody>
        
      </tbody>
   </table>
</section>
<section class="edit-form-container">
   <?php
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
         while($fetch_edit = mysqli_fetch_assoc($edit_query)){
   ?>

   <form action="" method="post" enctype="multipart/form-data">

      <img src="uploaded_Img/<?php echo $fetch_edit['image']; ?>" height="200" alt="">

      <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">

      <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['name']; ?>">

      <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['price']; ?>">

      <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">

      <input type="submit" value="update the prodcut" name="update_product" class="btn">

      <input type="reset" value="cancel" id="close-edit" class="option-btn">

   </form>
   <?php
            };
         };
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";

      };
   ?>
</section>
</div>