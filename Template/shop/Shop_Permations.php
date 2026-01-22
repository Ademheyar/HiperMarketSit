<?php
if (session_id() == "") session_start();
if (file_exists("config.php")) include("config.php");
if (file_exists("../../config.php")) include("../../config.php");
#include 'Template/shop/shop_actions.php';

if (!isset($conn)) {
    $protocol = isset($_SERVER['HTTPS']) ? "https://" : "http://";
    $domain = $_SERVER['HTTP_HOST'];
    $currentDir = dirname($_SERVER['REQUEST_URI']);
    $redirectURL = $protocol . $domain . $currentDir;
    include("../../config.php");
    if (!isset($conn)) exit;
}
?>

<div class="Permation_controller_bar">
  <button class="btn new_Permation_btn">New</button>
</div>

<div class="New_Permation_Add_container">
   <section>
      <div class="add-Permation-form">
         <h3>Add Promotion and Permations</h3>
         <div class="input_table">
            <!-- Combo Box for Shop Name -->
            <select class='input-field combobox' id="register_sname" required>
                <option value="">Select Shop Name</option>
                <?php
                if (isset($_SESSION['loged_user_info']['User_work_shop'])) {
                    $user_shops = json_decode($_SESSION['loged_user_info']['User_work_shop'], true);
                    foreach ($user_shops as $shop) {
                        echo '<option value="' . $shop[1] . '">' . $shop[1] . '</option>';
                    }
                }
                ?>
            </select>
            <input type='text' class='input-field input-ln box' placeholder='Tool Name' id="register_tname" required>
            <input type='number' class='input-field' placeholder='Index' id="register_No" required>
            <input type='text' class='input-field' placeholder='Type' id="register_location" required>
            <input type='text' class='input-field' placeholder='Short Cut' id="register_password" required>
            <input type='number' class='input-field' placeholder='Access Key' id="register_cpassword" required>
            
            <div class="checkboxes">
              <label><input type='checkbox' class='check-box' id="enable_payment"> Enable Promotions</label>
              <label><input type='checkbox' class='check-box' id="quick_payment"> Quick Promotions</label>
              <label><input type='checkbox' class='check-box' id="customer_required"> Customer Required</label>
              <label><input type='checkbox' class='check-box' id="print_slip"> Print Slip</label>
              <label><input type='checkbox' class='check-box' id="mark_as_paid"> Mark As Paid</label>
              <label><input type='checkbox' class='check-box' id="open_cash_drawer"> Open Cash Drawer</label>
            </div>
            
            <button type='button' class='btn' id="submitBtn">Create New Tool</button>
         </div>
      </div>
   </section>
</div>

<script>
  const permations_checkButton = document.querySelector("body .Main main .Shop_Permationstabcontent .Permation_controller_bar .new_Permation_btn");
  
  function show_newPermation_form(){
    const formB = document.querySelector("body .Main main .Shop_Permationstabcontent .New_Permation_Add_container .add-Permation-form");
    
    const buttonText = permations_checkButton.textContent;
    if (buttonText === "New") { 
      formB.style.display = "block"; 
      permations_checkButton.textContent = "Done";
    } else if (buttonText === "Done") { 
      formB.style.display = "none"; 
      permations_checkButton.textContent = "New";
    }
  }
  permations_checkButton.addEventListener("click", function() {
      show_newPermation_form();
    });
</script>

<section class="display-shopPermations">
  <h2>Shop Permations Tools</h2>
  <div class="user_list_shopPermations_div_id"></div>
</section>

<script>
    const user_list_shop_div_id = document.querySelector("body .Main main .Shop_Permationstabcontent .display-shopPermations .user_list_shopPermations_div_id");
    const submitBtn = document.getElementById("submitBtn");

function fetchPermationsForAllShops() {
        function display_newdata(tooldata){
             const tableContainer = document.querySelector("body .Main main .Shop_Permationstabcontent .display-shopPermations .user_list_shopPermations_div_id");
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


    // Call fetchPermationsForAllShops when the page loads or when needed
    fetchPermationsForAllShops();  
    
    submitBtn.addEventListener("click", function() {

        // Form Data
        const shopId = document.querySelector(".combobox").value;
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
        // Validation
        if (!shopId || !register_sname || !register_tname || !register_No || !register_location || !register_password || !register_cpassword) {
            alert("All fields are required.");
            return;
        }

        const formData = new FormData();
        formData.append('payment_tool_action', 'save_payment_tool');
        formData.append('Company_Id', shopId);
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
                fetchPaymentToolsForAllShops();
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
.controller_bar {
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

.add-Permation-form {
    background-color: #f9f9f9;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: none;
    width: 100%;
}

.add-Permation-form h3 {
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
</style>