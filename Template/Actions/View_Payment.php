<?php  $Company_profile_path = "";
  if(file_exists("server/Company/Company_profile.php")) $Company_profile_path = "server/Company/Company_profile.php";
 if(file_exists("../server/Company/Company_profile.php")) $Company_profile_path = "../server/Company/Company_profile.php";
 if(file_exists("../../server/Company/Company_profile.php")) $Company_profile_path = "../../server/Company/Company_profile.php";
?>

<script>
  let paymentgiveninfo = {
                selected_method: "", // this will hold name and method
                method: "", 
                Paid:"",
                date: "",
                expirydate: "",
                updateddate: "",
                user:"",
                isPaid: true,  // Assuming all payments are marked as paid initially
                external_doc:""
            };
function Payment_start(given_method, payments_methods) {
        console.log("Payment_start view payment >>", given_method)
        
            const body = document.querySelector("body");

            const paymentFormContainer = document.createElement('div');
            paymentFormContainer.style.fontSize = "small";
            paymentFormContainer.style.width = "100%";
            paymentFormContainer.style.height = "100vh";
            paymentFormContainer.style.background = "rgba(0,0,0,.3)";
            paymentFormContainer.style.padding = "18px";
            paymentFormContainer.style.overflow = "hidden";
            paymentFormContainer.style.position = "fixed";
            paymentFormContainer.style.top = "0";
            paymentFormContainer.style.left = "0";
            paymentFormContainer.style.display = "flex";
            paymentFormContainer.style.alignItems = "center";
            paymentFormContainer.style.justifyContent = "center";
            paymentFormContainer.style.zIndex = "1000";
            body.appendChild(paymentFormContainer);

            const form = document.createElement('form');
            form.style.backgroundColor = "#fafafa";
            form.style.padding = "20px";
            form.style.borderRadius = "10px";
            form.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.1)";
            //form.style.maxWidth = "400px";
            form.style.width = "100%";
            form.style.margin = "auto";

            const paymentMethodLabel = document.createElement('label');
            paymentMethodLabel.textContent = "Payment Method:";
            paymentMethodLabel.htmlFor = "paymentMethod";
            form.appendChild(paymentMethodLabel);

            const paymentMethodSelect = document.createElement('select');
            paymentMethodSelect.id = "paymentMethod";
            paymentMethodSelect.style.width = "100%";
            paymentMethodSelect.style.marginBottom = "10px";
            paymentMethodSelect.required = true;
            //const payments_methods = ["Select_User", "Credit Card", "Debit Card", "PayPal", "Cash", "Laby", "Send by Account", "Slipe"];
            function add_tools(tools){
              tools.forEach(tool => {
                  const option = document.createElement('option');
                  option.textContent = tool[0] + " (" + tool[1] + ")";
                  option.shop_name =  tool[0];
                  option.method =  tool[1];
           
            
                  paymentMethodSelect.appendChild(option);
              });
            }
            
            function fetchPaymentToolsForAllShops() {
        console.log("fetchPaymentToolsForAllShops");
        const formData = new FormData();
        formData.append('payment_tool_action', 'get_payment_tool_for_all_shops');
const Company_profile_path = '<?php if(isset($Company_profile_path)) echo $Company_profile_path; else echo ""; ?>';
console.log("Company_profile_path: ", Company_profile_path);
        sendAjaxRequest(Company_profile_path, 'POST', formData, function(responseText) {
               var data = JSON.parse(responseText);       
               console.log("fetched data", data);
            if (data.payment_tools) {
              payments_methods = data.payment_tools;
              add_tools(payments_methods);
            } else {
                alert("Errorpayment_toolst0d1: " + data.message);
            }
        }, function(errorStatus) { console.log('Payment_start: ' + errorStatus);});
        
    }
    // Add payment buttons
    if(payments_methods.length<=0) fetchPaymentToolsForAllShops();
    else add_tools(payments_methods);
    
            form.appendChild(paymentMethodSelect);

          given_method = given_method === "" ? paymentMethodSelect.value:given_method;
        console.log("Payment_start given_method >>", given_method)
          
            const paymentDetailsContainer = document.createElement('div');
            form.appendChild(paymentDetailsContainer);

            const buttonContainer = document.createElement('div');
            buttonContainer.style.display = "flex";
            buttonContainer.style.justifyContent = "space-between";
            buttonContainer.style.flexWrap = "wrap";
            buttonContainer.style.alignContent = "space-around";
            buttonContainer.style.alignItems = "center";
            buttonContainer.style.justifyItems = "start";
            form.appendChild(buttonContainer);

            const submitButton = document.createElement('button');
            submitButton.textContent = "Submit Payment";
            submitButton.style.backgroundColor = "none";
            submitButton.style.color = "#fff";
            submitButton.style.padding = "10px 20px";
            submitButton.style.border = "none";
            submitButton.style.borderRadius = "5px";
            submitButton.style.cursor = "pointer";
           submitButton.disabled = true;
            submitButton.addEventListener('click', (e) => {
                e.preventDefault();
                paymentgiveninfo.selected_method = paymentMethodSelect;
                Start_Processing();
                alert('Payment Submitted!');
                paymentFormContainer.remove();
            });
            buttonContainer.appendChild(submitButton);

            const addpaymentButton = document.createElement('button');
            addpaymentButton.textContent = "Add Payment";
            addpaymentButton.style.backgroundColor = "#28a745";
            addpaymentButton.style.color = "#fff";
            addpaymentButton.style.padding = "10px 20px";
            addpaymentButton.style.border = "none";
            addpaymentButton.style.borderRadius = "5px";
            addpaymentButton.style.cursor = "pointer";
            addpaymentButton.addEventListener('click', (e) => {
                e.preventDefault();
                paymentgiveninfo.selected_method = paymentMethodSelect;
                savePaymentData();
                alert('added Submitted!');
                updatePaymentForm("Show", paymentDetailsContainer, submitButton);
            });
            buttonContainer.appendChild(addpaymentButton);
        
            const cancelButton = document.createElement('button');
            cancelButton.textContent = "Cancel";
            cancelButton.style.backgroundColor = "#dc3545";
            cancelButton.style.color = "#fff";
            cancelButton.style.padding = "10px 20px";
            cancelButton.style.border = "none";
            cancelButton.style.borderRadius = "5px";
            cancelButton.style.cursor = "pointer";
            cancelButton.addEventListener('click', (e) => {
                e.preventDefault();
                paymentFormContainer.remove();
            });
            buttonContainer.appendChild(cancelButton);

            const clearallpaymentButton = document.createElement('button');
            clearallpaymentButton.textContent = "Clear All Payments";
            clearallpaymentButton.style.backgroundColor = "#007bff";
            clearallpaymentButton.style.color = "#fff";
            clearallpaymentButton.style.padding = "10px 20px";
            clearallpaymentButton.style.border = "none";
            clearallpaymentButton.style.borderRadius = "5px";
            clearallpaymentButton.style.cursor = "pointer";
            clearallpaymentButton.addEventListener('click', (e) => {
                e.preventDefault();
                        // Store empty into local storage
                        localStorage.setItem('Payment_Lists', JSON.stringify([]));
                updatePaymentForm("Show", paymentDetailsContainer, submitButton);
            });
            buttonContainer.appendChild(clearallpaymentButton);
          
            const showPaymentsButton = document.createElement('button');
            showPaymentsButton.textContent = "Show Payments";
            showPaymentsButton.style.backgroundColor = "#007bff";
            showPaymentsButton.style.color = "#fff";
            showPaymentsButton.style.padding = "10px 20px";
            showPaymentsButton.style.border = "none";
            showPaymentsButton.style.borderRadius = "5px";
            showPaymentsButton.style.cursor = "pointer";
            showPaymentsButton.addEventListener('click', (e) => {
                e.preventDefault();
                updatePaymentForm("Show", paymentDetailsContainer, submitButton);
            });
            buttonContainer.appendChild(showPaymentsButton);

            paymentFormContainer.appendChild(form);

paymentMethodSelect.addEventListener('change', () => {
           const seleted_option = paymentMethodSelect.options[paymentMethodSelect.selectedIndex];
           console.log("seleted_option: ", seleted_option);
              paymentMethodSelect.shop_name = seleted_option.shop_name;
              paymentMethodSelect.method = seleted_option.method;
                updatePaymentForm(seleted_option.method, paymentDetailsContainer, submitButton);
            });
              
            updatePaymentForm(given_method, paymentDetailsContainer, submitButton);
        }

function updatePaymentForm(method, container, submitButton) {
        console.log("changeing payment >>", method)
          container.innerHTML = '';
          var activeChartIndex = localStorage.getItem('activeChartIndex');
          var isactiveChartData = localStorage.getItem('ActiveChartData');
          var activeChartData = isactiveChartData ? JSON.parse(isactiveChartData) : [];
          var iscartData = activeChartData[activeChartIndex];
          
          var cartData = iscartData ? activeChartData[activeChartIndex]: [];
          var totalprice = 0;
          cartData.forEach(item => { totalprice += item.quantity * item.price; });
          
          let tprice = 0;
          const payments = localStorage.getItem('Payment_Lists');
          const paymentList = payments ? JSON.parse(payments) : [];
    
          paymentList.forEach(payment => { tprice += parseInt(payment.Paid); });
          const paymentleft = totalprice - tprice;
          if(paymentleft <= 0 && tprice !== 0) { submitButton.disabled = false; submitButton.style.backgroundColor = "#28a745"; }
          else { submitButton.disabled = true;  submitButton.style.backgroundColor = ""; }
          if(method == "Show"){
          const paymentListContainer = document.createElement('div');
          paymentListContainer.style.backgroundColor = "#fff";
          paymentListContainer.style.padding = "20px";
          paymentListContainer.style.borderRadius = "10px";
            paymentListContainer.style.display = "grid";
          paymentListContainer.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.1)";
          paymentListContainer.style.overflow = "overlay";
          paymentListContainer.style.width = "100%";
          paymentListContainer.style.margin = "20px auto";

                    
          const tableContainer = document.createElement('div');
          tableContainer.style.backgroundColor = "#fff";
          tableContainer.style.padding = "20px";
          tableContainer.style.borderRadius = "10px";
            tableContainer.style.display = "grid";
          tableContainer.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.1)";
          tableContainer.style.overflow = "overlay";
          tableContainer.style.width = "100%";
          tableContainer.style.margin = "20px auto";
          paymentListContainer.appendChild(tableContainer);
                    
          const table = document.createElement('table');
          const thead = document.createElement('thead');
          const headerRow = document.createElement('tr');
      
          const headers = ["Payment Name", "Payment Method", "Amount", "user",  "Is Paid", "external_doc", "Created Date", "Updated Date", "Expiry Date"];
          headers.forEach(headerText => {
              const th = document.createElement('th');
              th.textContent = headerText;
              headerRow.appendChild(th);
          });
      
          thead.appendChild(headerRow);
          table.appendChild(thead);
      
          const tbody = document.createElement('tbody');
          paymentList.forEach((payment, plist_index) => {
              const row = document.createElement('tr');
      
              const nameCell = document.createElement('td');
              nameCell.textContent = payment.name;
              row.appendChild(nameCell);
                    
              const methodCell = document.createElement('td');
              methodCell.textContent = payment.method;
              row.appendChild(methodCell);
                  
              const PaidCell = document.createElement('td');
              PaidCell.textContent = payment.Paid;
              row.appendChild(PaidCell);
                  
              const user = document.createElement('td');
              user.textContent = payment.user;
              row.appendChild(user);
                  
              const isPaidCell = document.createElement('td');
              isPaidCell.textContent = payment.isPaid ? "Yes" : "No";
              row.appendChild(isPaidCell);

              const external_doc = document.createElement('td');
              external_doc.textContent = payment.external_doc;
              row.appendChild(external_doc);
                  
              const dateCell = document.createElement('td');
              dateCell.textContent = payment.date;
              row.appendChild(dateCell);
                  
              const expirydate = document.createElement('td');
              expirydate.textContent = payment.expirydate;
              row.appendChild(expirydate);
                  
              const updateddate = document.createElement('td');
              updateddate.textContent = payment.updateddate;
              row.appendChild(updateddate);
                    
              const removepaymentButton = document.createElement('button');
              removepaymentButton.textContent = "Remove";
            removepaymentButton.style.backgroundColor = "#dc3545";
            removepaymentButton.style.color = "#fff";
              removepaymentButton.style.padding = "10px 20px";
              removepaymentButton.style.border = "none";
              removepaymentButton.style.borderRadius = "5px";
              removepaymentButton.style.cursor = "pointer";
              removepaymentButton.addEventListener('click', (e) => {
                    e.preventDefault();
                        
                    let payments = localStorage.getItem('Payment_Lists');
                    payments = payments ? JSON.parse(payments) : [];
                    let plist_index0 = plist_index; 
                    alert('Going to remove payment '+plist_index0+" => "+JSON.stringify(payments));
                    // Add new payment data to the list
                    payments.splice(plist_index0, 1);
                    alert('done to remove payment! '+plist_index0+" => "+JSON.stringify(payments));
                    // Store updated payment list back into local storage
                    localStorage.setItem('Payment_Lists', JSON.stringify(payments));

                    //row.remove();
                        
                    updatePaymentForm("Show", container, submitButton);
              });
              row.appendChild(removepaymentButton);
                    
              tbody.appendChild(row);
          });
      
          table.appendChild(tbody);
          tableContainer.appendChild(table);
      
          const countTotalLabel = document.createElement('label');
          countTotalLabel.textContent = "Total Peyment Count : "+ paymentList.length;
                countTotalLabel.style.width = "100%";
          countTotalLabel.htmlFor = "cardNumber";
          paymentListContainer.appendChild(countTotalLabel);

                      
          const GrandTotalLabel = document.createElement('label');
          GrandTotalLabel.textContent = "Total Peyment Miade : "+parseInt(tprice);
                GrandTotalLabel.style.width = "100%";
          GrandTotalLabel.htmlFor = "cardNumber";
          paymentListContainer.appendChild(GrandTotalLabel);

          const LeftLabel = document.createElement('label');
          LeftLabel.textContent = "Total Peyment left : "+parseInt(paymentleft>= 0 ? paymentleft:0);
          LeftLabel.style.width = "100%";
          LeftLabel.htmlFor = "cardNumber";
          paymentListContainer.appendChild(LeftLabel);
                      
          const changeLabel = document.createElement('label');
          changeLabel.textContent = "Change : "+parseInt(paymentleft<= 0 ? paymentleft:0);
          changeLabel.style.width = "100%";
          changeLabel.htmlFor = "cardNumber";
          paymentListContainer.appendChild(changeLabel);
                      
          // Add buttons for navigation
          const buttonContainer = document.createElement('div');
          buttonContainer.style.marginTop = "20px";
          buttonContainer.style.textAlign = "center";
                      
          
          paymentListContainer.appendChild(buttonContainer);
          container.appendChild(paymentListContainer);
      }

        
            if (method === "Credit/Debit" || method === "Credit" || method === "Debit Card" || method === "Debit" || method === "Card") {
                const cardNumberLabel = document.createElement('label');
                cardNumberLabel.textContent = "Card Number:";
                cardNumberLabel.htmlFor = "cardNumber";
                container.appendChild(cardNumberLabel);

                const cardNumberInput = document.createElement('input');
                cardNumberInput.type = "text";
                cardNumberInput.id = "cardNumber";
                cardNumberInput.style.width = "100%";
                cardNumberInput.style.marginBottom = "10px";
                cardNumberInput.style.padding = "10px";
                cardNumberInput.style.border = "1px solid #11dd17";
                cardNumberInput.required = true;
                cardNumberInput.pattern = "\\d{13,16}";
                container.appendChild(cardNumberInput);

                const expiryDateLabel = document.createElement('label');
                expiryDateLabel.textContent = "Expiry Date:";
                expiryDateLabel.htmlFor = "expiryDate";
                container.appendChild(expiryDateLabel);

                const expiryDateInput = document.createElement('input');
                expiryDateInput.type = "text";
                expiryDateInput.id = "expiryDate";
                expiryDateInput.placeholder = "MM/YY";
                expiryDateInput.style.width = "100%";
                expiryDateInput.style.padding = "10px";
                expiryDateInput.style.border = "1px solid #11dd17";
                expiryDateInput.style.marginBottom = "10px";
                expiryDateInput.required = true;
                expiryDateInput.pattern = "(0[1-9]|1[0-2])\\/([0-9]{2})";
                container.appendChild(expiryDateInput);

                const cvvLabel = document.createElement('label');
                cvvLabel.textContent = "CVV:";
                cvvLabel.htmlFor = "cvv";
                container.appendChild(cvvLabel);

                const cvvInput = document.createElement('input');
                cvvInput.type = "text";
                cvvInput.id = "cvv";
                cvvInput.style.width = "100%";
                cvvInput.style.marginBottom = "10px";
                cvvInput.style.padding = "10px";
                cvvInput.style.border = "1px solid #11dd17";
                cvvInput.required = true;
                cvvInput.pattern = "\\d{3,4}";
                container.appendChild(cvvInput);

                const AmountLabel = document.createElement('label');
                AmountLabel.textContent = "Amount :";
                AmountLabel.htmlFor = "Amount";
                container.appendChild(AmountLabel);
                    
                const AmountInput = document.createElement('input');
                AmountInput.type = "text";
                AmountInput.id = "Amount";
                AmountInput.value = paymentleft;
                AmountInput.style.width = "100%";
                AmountInput.style.marginBottom = "10px";
                AmountInput.style.padding = "10px";
                AmountInput.style.border = "1px solid #11dd17";
                AmountInput.required = true;
                container.appendChild(AmountInput);
                    
                addNumberPad(container, 'cardNumber');

                paymentgiveninfo.Paid = AmountInput;
                    
            } else if (method === "Account") {
                const WoringLabel = document.createElement('label');
                WoringLabel.textContent = "Select Account Givein bellow To Transfer Account To Account. Send code To one of our Phone Number To get confirmation Number than Fill the Number in confirmation Input. For any Suport or More info You can Use same Number.";
                WoringLabel.htmlFor = "customer";
                container.appendChild(WoringLabel);

                const AmountInput = document.createElement('input');
                AmountInput.type = "text";
                AmountInput.id = "Amount";
                AmountInput.value = paymentleft;
                AmountInput.style.width = "100%";
                AmountInput.style.marginBottom = "10px";
                AmountInput.style.padding = "10px";
                AmountInput.style.border = "1px solid #11dd17";
                AmountInput.required = true;
                container.appendChild(AmountInput);
              const customerLabel = document.createElement('label');
              customerLabel.textContent = "Select Account:";
              customerLabel.htmlFor = "customer";
              container.appendChild(customerLabel);

              const AccountSelect = document.createElement('select');
              AccountSelect.id = "customer";
              AccountSelect.style.width = "100%";
              AccountSelect.style.marginBottom = "10px";
                AccountSelect.style.padding = "10px";
                AccountSelect.style.border = "1px solid #11dd17";
              AccountSelect.required = true;
              const customers = ["Account 1", "Account 2", "Account 3"];
              customers.forEach(customer => {
                  const option = document.createElement('option');
                  option.value = customer;
                  option.textContent = customer;
                  AccountSelect.appendChild(option);
              });
             container.appendChild(AccountSelect);
             
             const codeLabel = document.createElement('label');
             codeLabel.textContent = "Your Code Is: ????";
             
             container.appendChild(codeLabel);
                
             const confirmLabel = document.createElement('label');
            confirmLabel.textContent = "Input confirmation Number";
            
            container.appendChild(confirmLabel);

            const confirmInput = document.createElement('input');
            confirmInput.type = "email";
            confirmInput.id = "paypalEmail";
            confirmInput.style.width = "100%";
            confirmInput.style.marginBottom = "10px";
                confirmInput.style.padding = "10px";
                confirmInput.style.border = "1px solid #11dd17";
            confirmInput.required = true;
            container.appendChild(confirmInput);
                    
                paymentgiveninfo.Paid = AmountInput;
            }
            else if (method === "PayPal") {
                
                const AmountLabel = document.createElement('label');
                AmountLabel.textContent = "Amount :";
                AmountLabel.htmlFor = "Amount";
                container.appendChild(AmountLabel);
                    
                const AmountInput = document.createElement('input');
                AmountInput.type = "text";
                AmountInput.id = "Amount";
                AmountInput.value = paymentleft;
                AmountInput.style.width = "100%";
                AmountInput.style.marginBottom = "10px";
                AmountInput.style.padding = "10px";
                AmountInput.style.border = "1px solid #11dd17";
                AmountInput.required = true;
                container.appendChild(AmountInput);
                    
                const emailLabel = document.createElement('label');
                emailLabel.textContent = "PayPal Email:";
                emailLabel.htmlFor = "paypalEmail";
                container.appendChild(emailLabel);

                const emailInput = document.createElement('input');
                emailInput.type = "email";
                emailInput.id = "paypalEmail";
                emailInput.style.width = "100%";
                emailInput.style.marginBottom = "10px";
                emailInput.style.padding = "10px";
                emailInput.style.border = "1px solid #11dd17";
                emailInput.required = true;
                container.appendChild(emailInput);
                    
                paymentgiveninfo.Paid = AmountInput;
            }
           else if (method === "Select_User") {
                    const customerLabel = document.createElement('label');
                    customerLabel.textContent = "Select Customer:";
                    customerLabel.htmlFor = "customer";
                    container.appendChild(customerLabel);  
                          
                          const create_Search_container = document.createElement('div');
                      create_Search_container.style.height = '5%';
                          container.appendChild(create_Search_container);
                          
                  create_Search(create_Search_container, 'body .Main', "USER", "", '', "Search", 1, 1, 1, '', '');
                }
            else if (method === "Card/Cash") {

                  

                const calculatorContainer = document.createElement('div');
                calculatorContainer.className = 'calculator-input';
                container.appendChild(calculatorContainer);
                      
                const amountLabel = document.createElement('label');
                amountLabel.textContent = "Enter Amount:";
                amountLabel.htmlFor = "amount";
                calculatorContainer.appendChild(amountLabel);

                const amountInput = document.createElement('input');
                amountInput.type = "number";
                amountInput.id = "amount";
                amountInput.min = "0";
                amountInput.value = paymentleft;
                amountInput.step = "0.01";
                amountInput.style.width = "100%";
                amountInput.style.marginBottom = "10px";
                amountInput.style.padding = "10px";
                amountInput.style.border = "1px solid #11dd17";
                amountInput.required = true;
                calculatorContainer.appendChild(amountInput);


                addNumberPad(calculatorContainer, 'amount');

                    
                paymentgiveninfo.Paid = amountInput;
            }
        } 
      
function addNumberPad(container, inputId) {
            const numberPad = document.createElement('div');
            numberPad.className = 'number-pad';
            numberPad.style.display = 'flex';
            numberPad.style.flexWrap = 'wrap';
            numberPad.style.justifyContent = 'space-between';
            container.appendChild(numberPad);

            const buttons = [
                '7', '8', '9',
                '4', '5', '6',
                '1', '2', '3',
                '0', '.', 'C'
            ];
        
            buttons.forEach(symbol => {
                const button = document.createElement('button');
                button.type = "button";
                button.textContent = symbol;
                button.style.width = '30%';
                button.style.margin = '5px 0';
                button.style.padding = '15px';
                button.style.fontSize = '20px';
                button.style.cursor = 'pointer';
                button.style.backgroundColor = '#f1f1f1';
                button.style.border = 'none';
                button.style.borderRadius = '5px';
                button.addEventListener('click', () => {
                    handleNumberPadClick(symbol, inputId);
                });
                numberPad.appendChild(button);
            });
        }

function handleNumberPadClick(symbol, inputId) {
            const input = document.getElementById(inputId);
            if (symbol === 'C') {
                input.value = '';
            } else {
                input.value += symbol;
            }
        }

function savePaymentData() {
    const date = new Date().toLocaleDateString();
    paymentgiveninfo.Paid = paymentgiveninfo.Paid.value;
    paymentgiveninfo.name = paymentgiveninfo.selected_method.shop_name;
    paymentgiveninfo.method = paymentgiveninfo.selected_method.method;
        paymentgiveninfo.date = date;
        paymentgiveninfo.expirydate = date;
        paymentgiveninfo.updateddate = date;
        
                paymentgiveninfo.user ="";
                paymentgiveninfo.isPaid = true;  // Assuming all payments are marked as paid initially
                paymentgiveninfo.external_doc = "";
        
            alert('paymentgiveninfo process initiated!', paymentgiveninfo);
    // Retrieve existing payment list from local storage
    let payments = localStorage.getItem('Payment_Lists');
    payments = payments ? JSON.parse(payments) : [];

    // Add new payment data to the list
    payments.push(paymentgiveninfo);

    // Store updated payment list back into local storage
    localStorage.setItem('Payment_Lists', JSON.stringify(payments));

}

function pay() {
            alert('Payment process initiated!');
            const activeChartData = getActiveChartData();
            alert('Payment Successful!');
            //deleteAllItems();
        }

function getActiveChartData() {
            console.log("getting getActiveChartData list:");
            const activeChartData = localStorage.getItem('ActiveChartData');
            return activeChartData ? JSON.parse(activeChartData) : [];
        }

function updateActiveChartData(activeChartData) {
            localStorage.setItem('ActiveChartData', JSON.stringify(activeChartData));
        }

function deleteAllItems() {
            if (confirm('Are you sure you want to delete all items?')) {
                const activeChartData = [];
                updateActiveChartData(activeChartData);
            }
        }
    
function displayPaymentForm() {
        document.getElementById("displayPaymentFormButton").style.display = "none";
        document.getElementById("paymentFormContainer").style.display = "block";
    }
    
function cancelPaymentForm() {
        document.getElementById("displayPaymentFormButton").style.display = "block";
        document.getElementById("paymentFormContainer").style.display = "none";
      document.getElementById("approvalMessageContainer").style.display = "none";
      document.getElementById("declineMessageContainer").style.display = "none";
    }
    
function processPayment() {
        // Simulate payment processing
        var isSuccess = Math.random() < 0.5; // Randomly determine success or failure
        
        if (isSuccess) {
            document.getElementById("paymentFormContainer").style.display = "none";
            document.getElementById("approvalMessageContainer").style.display = "block";
        } else {
            document.getElementById("paymentFormContainer").style.display = "none";
            document.getElementById("declineMessageContainer").style.display = "block";
        }
    }

// Function to cancel the form and close it
function cancel_Payment_Form() {
        document.getElementById('Payment-form').style.display = 'none';
    }

</script> 