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

<div class="Action_controller_bar">
  <button class="btn new_Action_btn">New</button>
</div>

<div class="New_Action_Add_container">
   <section>
      <div class="add-Action-form">
         <h3>Add Promotion and Actions</h3>
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
  const promotion_checkButton = document.querySelector("body .Main main .Shop_Promotionstabcontent .Action_controller_bar .new_Action_btn");
  
  function show_newAction_form(){
    const formB = document.querySelector("body .Main main .Shop_Promotionstabcontent .New_Action_Add_container .add-Action-form");
    
    const buttonText = promotion_checkButton.textContent;
    if (buttonText === "New") { 
      formB.style.display = "block"; 
      promotion_checkButton.textContent = "Done";
    } else if (buttonText === "Done") { 
      formB.style.display = "none"; 
      promotion_checkButton.textContent = "New";
    }
  }
  promotion_checkButton.addEventListener("click", function() {
      show_newAction_form();
    });
</script>




<section class="display-shopPromotionsTools">
  <h2>Shop Promotions Tools</h2>
  <div class="user_list_shopPromotionsTools_div_id"></div>
</section>

<script>
    const user_list_shop_div_id = document.querySelector("body .Main main .Shop_Promotionstabcontent .display-shopPromotionsTools .user_list_shopPromotionsTools_div_id");
    const submitBtn = document.getElementById("submitBtn");

function fetchPromotionsToolsForAllShops() {
        function display_newtoolsdata(tooldata){
             const tableContainer = document.querySelector("body .Main main .Shop_Promotionstabcontent .display-shopPromotionsTools .user_list_shopPromotionsTools_div_id");
            tableContainer.innerHTML = ''; // Clear existing table if any

            const table = document.createElement("table");
            table.className = 'table';
            
            const thead = document.createElement("thead");
            const headerRow = document.createElement("tr");

            const headers = [
                "Tool Name", "Index", "Type", "Short Cut", "Access Key",
                "Enable Payment", "Quick Payment", "Customer Required",
                "Print Slip", "Mark As Paid", "Open Cash Drawer"
            ];

            headers.forEach(header => {
                const th = document.createElement("th");
                th.textContent = header;
                headerRow.appendChild(th);
            });

            thead.appendChild(headerRow);
            table.appendChild(thead);

            const tbody = document.createElement("tbody");
            tooldata.forEach(tool => {
                const row = document.createElement("tr");

                const toolValues = [
                    tool[0], tool[1], tool[2], tool[3], tool[4],
                    tool[5] ? "Yes" : "No",
                    tool[6] ? "Yes" : "No",
                    tool[7] ? "Yes" : "No",
                    tool[8] ? "Yes" : "No",
                    tool[9] ? "Yes" : "No",
                    tool[10] ? "Yes" : "No"
                ];

                toolValues.forEach(value => {
                    const td = document.createElement("td");
                    td.textContent = value;
                    row.appendChild(td);
                });

                tbody.appendChild(row);
            });

            table.appendChild(tbody);
            tableContainer.appendChild(table);
        }
        
        console.log("fetchPaymentToolsForAllShops");
        const formData = new FormData();
        formData.append('payment_tool_action', 'get_payment_tool_for_all_shops');
        
        fetch('../../server/Company/Company_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("0 fetched data", data);
            if (data.payment_tools) {
               display_newtoolsdata(data.payment_tools);
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
                if (data.payment_tools) {
                   display_newtoolsdata(data.payment_tools);
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
                    if (data.payment_tools) {
                       display_newtoolsdata(data.payment_tools);
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
                fetchPromotionsToolsForAllShops();
            } else {
                alert("Errort0l0: " + data.message);
            }
        })
        .catch(error => {
            console.error("Errort0l1: ", error);
            alert("Errort0l1: " + error);
        });
    });

    // Call fetchPromotionsToolsForAllShops when the page loads or when needed
    fetchPromotionsToolsForAllShops();  


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

.add-Action-form {
    background-color: #f9f9f9;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: none;
    width: 100%;
}

.add-Action-form h3 {
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

.display-shopPromotionsTools-table {
    max-width: 100%;
    overflow-x: auto;
}

.display-shopPromotionsTools-table table {
    width: 100%;
    border-collapse: collapse;
}

.display-shopPromotionsTools-table th, .display-shopPromotionsTools-table td {
    padding: 12px;
    text-align: center;
}

.display-shopPromotionsTools-table th {
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