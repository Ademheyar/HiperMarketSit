<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Payment Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .hidden {
            display: none;
        }
        .calculator-input {
            display: flex;
            flex-direction: column;
        }
        .calculator-input input {
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
        }
        .number-pad {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .number-pad button {
            width: 30%;
            margin: 5px 0;
            padding: 15px;
            font-size: 20px;
            cursor: pointer;
            background-color: #f1f1f1;
            border: none;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <script>
      
      
        function showPaymentForm() {
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
            form.style.maxWidth = "400px";
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
            const methods = ["Credit Card", "Debit Card", "PayPal", "Cash", "Laby", "Send by Account"];
            methods.forEach(method => {
                const option = document.createElement('option');
                option.value = method;
                option.textContent = method;
                paymentMethodSelect.appendChild(option);
            });
            form.appendChild(paymentMethodSelect);

            const paymentDetailsContainer = document.createElement('div');
            form.appendChild(paymentDetailsContainer);

            const buttonContainer = document.createElement('div');
            buttonContainer.style.display = "flex";
            buttonContainer.style.justifyContent = "space-between";
            form.appendChild(buttonContainer);

            const submitButton = document.createElement('button');
            submitButton.textContent = "Submit Payment";
            submitButton.style.backgroundColor = "#28a745";
            submitButton.style.color = "#fff";
            submitButton.style.padding = "10px 20px";
            submitButton.style.border = "none";
            submitButton.style.borderRadius = "5px";
            submitButton.style.cursor = "pointer";
            submitButton.addEventListener('click', (e) => {
                e.preventDefault();
                savePaymentData(paymentMethodSelect.value);
                alert('Payment Submitted!');
                paymentFormContainer.remove();
            });
            buttonContainer.appendChild(submitButton);

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
                updatePaymentForm("Show", paymentDetailsContainer);
            });
            buttonContainer.appendChild(showPaymentsButton);

            paymentFormContainer.appendChild(form);

            paymentMethodSelect.addEventListener('change', () => {
                updatePaymentForm(paymentMethodSelect.value, paymentDetailsContainer);
            });

            updatePaymentForm(paymentMethodSelect.value, paymentDetailsContainer);
        }

        function updatePaymentForm(method, container) {
            container.innerHTML = '';
            
            if(method == "Show"){
          const payments = localStorage.getItem('Payment_Lists');
          const paymentList = payments ? JSON.parse(payments) : [];
          
          const paymentListContainer = document.createElement('div');
          paymentListContainer.style.backgroundColor = "#fff";
          paymentListContainer.style.padding = "20px";
          paymentListContainer.style.borderRadius = "10px";
          paymentListContainer.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.1)";
          paymentListContainer.style.maxWidth = "600px";
          paymentListContainer.style.width = "100%";
          paymentListContainer.style.margin = "20px auto";
      
          const table = document.createElement('table');
          const thead = document.createElement('thead');
          const headerRow = document.createElement('tr');
      
          const headers = ["Payment Method", "Date", "Is Paid"];
          headers.forEach(headerText => {
              const th = document.createElement('th');
              th.textContent = headerText;
              headerRow.appendChild(th);
          });
      
          thead.appendChild(headerRow);
          table.appendChild(thead);
      
          const tbody = document.createElement('tbody');
      
          paymentList.forEach(payment => {
              const row = document.createElement('tr');
      
              const methodCell = document.createElement('td');
              methodCell.textContent = payment.method;
              row.appendChild(methodCell);
      
              const dateCell = document.createElement('td');
              dateCell.textContent = payment.date;
              row.appendChild(dateCell);
      
              const isPaidCell = document.createElement('td');
              isPaidCell.textContent = payment.isPaid ? "Yes" : "No";
              row.appendChild(isPaidCell);
      
              tbody.appendChild(row);
          });
      
          table.appendChild(tbody);
          paymentListContainer.appendChild(table);
      
          // Add buttons for navigation
          const buttonContainer = document.createElement('div');
          buttonContainer.style.marginTop = "20px";
          buttonContainer.style.textAlign = "center";
          
          paymentListContainer.appendChild(buttonContainer);
          container.appendChild(paymentListContainer);
      }

            if (method === "Credit Card" || method === "Debit Card") {
                const cardNumberLabel = document.createElement('label');
                cardNumberLabel.textContent = "Card Number:";
                cardNumberLabel.htmlFor = "cardNumber";
                container.appendChild(cardNumberLabel);

                const cardNumberInput = document.createElement('input');
                cardNumberInput.type = "text";
                cardNumberInput.id = "cardNumber";
                cardNumberInput.style.width = "100%";
                cardNumberInput.style.marginBottom = "10px";
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
                cvvInput.required = true;
                cvvInput.pattern = "\\d{3,4}";
                container.appendChild(cvvInput);

                addNumberPad(container, 'cardNumber');
            } else if (method === "Send by Account") {
              const WoringLabel = document.createElement('label');
              WoringLabel.textContent = "Select Account Givein bellow To Transfer Account To Account. Send code To one of our Phone Number To get confirmation Number than Fill the Number in confirmation Input. For any Suport or More info You can Use same Number.";
              WoringLabel.htmlFor = "customer";
              container.appendChild(WoringLabel);

              const customerLabel = document.createElement('label');
              customerLabel.textContent = "Select Account:";
              customerLabel.htmlFor = "customer";
              container.appendChild(customerLabel);

              const AccountSelect = document.createElement('select');
              AccountSelect.id = "customer";
              AccountSelect.style.width = "100%";
              AccountSelect.style.marginBottom = "10px";
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
            confirmInput.required = true;
            container.appendChild(confirmInput);
            }
            else if (method === "PayPal") {
                const emailLabel = document.createElement('label');
                emailLabel.textContent = "PayPal Email:";
                emailLabel.htmlFor = "paypalEmail";
                container.appendChild(emailLabel);

                const emailInput = document.createElement('input');
                emailInput.type = "email";
                emailInput.id = "paypalEmail";
                emailInput.style.width = "100%";
                emailInput.style.marginBottom = "10px";
                emailInput.required = true;
                container.appendChild(emailInput);
            }
            else if (method === "Cash" || method === "Laby") {
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
                amountInput.step = "0.01";
                amountInput.style.width = "100%";
                amountInput.style.marginBottom = "10px";
                amountInput.required = true;
                calculatorContainer.appendChild(amountInput);

                if (method === "Laby") {
                    const customerLabel = document.createElement('label');
                    customerLabel.textContent = "Select Customer:";
                    customerLabel.htmlFor = "customer";
                    container.appendChild(customerLabel);

                    const customerSelect = document.createElement('select');
                    customerSelect.id = "customer";
                    customerSelect.style.width = "100%";
                    customerSelect.style.marginBottom = "10px";
                    customerSelect.required = true;
                    const customers = ["Customer 1", "Customer 2", "Customer 3"];
                    customers.forEach(customer => {
                        const option = document.createElement('option');
                        option.value = customer;
                        option.textContent = customer;
                        customerSelect.appendChild(option);
                    });
                    container.appendChild(customerSelect);
                }

                addNumberPad(calculatorContainer, 'amount');
            }
        }

        function addNumberPad(container, inputId) {
            const numberPad = document.createElement('div');
            numberPad.className = 'number-pad';
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
function savePaymentData(paymentMethod) {
    const date = new Date().toLocaleDateString();
    const paymentData = {
        method: paymentMethod,
        Paid:"",
        date: date,
        expirydate: date,
        updateddate: date,
        user:"",
        isPaid: true,  // Assuming all payments are marked as paid initially
        external_doc:""
    };

    // Retrieve existing payment list from local storage
    let payments = localStorage.getItem('Payment_Lists');
    payments = payments ? JSON.parse(payments) : [];

    // Add new payment data to the list
    payments.push(paymentData);

    // Store updated payment list back into local storage
    localStorage.setItem('Payment_Lists', JSON.stringify(payments));
}
showPaymentForm();
        
        function pay() {
            alert('Payment process initiated!');
            const activeChartData = getActiveChartData();
            alert('Payment Successful!');
            deleteAllItems();
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

        
    </script>
</body>
</html>

