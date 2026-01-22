// Function to display the payment form
function showPaymentForm() {
    // Main container for the form
    const paymentFormContainer = document.createElement('div');
    paymentFormContainer.style.fontSize = "small";
    paymentFormContainer.style.width = "100%";
    paymentFormContainer.style.height = "auto";
    paymentFormContainer.style.background = "rgba(0,0,0,.3)";
    paymentFormContainer.style.padding = "18px";
    paymentFormContainer.style.overflow = "hidden";
    paymentFormContainer.style.position = "absolute";
    paymentFormContainer.style.zIndex = "1000";  // Ensure the form is on top of other elements
    document.body.appendChild(paymentFormContainer);

    // Form elements
    const form = document.createElement('form');
    form.style.backgroundColor = "#fafafa";
    form.style.padding = "20px";
    form.style.borderRadius = "10px";
    form.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.1)";
    form.style.maxWidth = "400px";
    form.style.margin = "auto";

    // Payment Method
    const paymentMethodLabel = document.createElement('label');
    paymentMethodLabel.textContent = "Payment Method:";
    form.appendChild(paymentMethodLabel);

    const paymentMethodSelect = document.createElement('select');
    paymentMethodSelect.style.width = "100%";
    paymentMethodSelect.style.marginBottom = "10px";
    paymentMethodSelect.required = true;
    const methods = ["Credit Card", "Debit Card", "PayPal", "Other"];
    methods.forEach(method => {
        const option = document.createElement('option');
        option.value = method;
        option.textContent = method;
        paymentMethodSelect.appendChild(option);
    });
    form.appendChild(paymentMethodSelect);

    // Card Number
    const cardNumberLabel = document.createElement('label');
    cardNumberLabel.textContent = "Card Number:";
    form.appendChild(cardNumberLabel);

    const cardNumberInput = document.createElement('input');
    cardNumberInput.type = "text";
    cardNumberInput.style.width = "100%";
    cardNumberInput.style.marginBottom = "10px";
    cardNumberInput.required = true;
    form.appendChild(cardNumberInput);

    // Expiry Date
    const expiryDateLabel = document.createElement('label');
    expiryDateLabel.textContent = "Expiry Date:";
    form.appendChild(expiryDateLabel);

    const expiryDateInput = document.createElement('input');
    expiryDateInput.type = "text";
    expiryDateInput.placeholder = "MM/YY";
    expiryDateInput.style.width = "100%";
    expiryDateInput.style.marginBottom = "10px";
    expiryDateInput.required = true;
    form.appendChild(expiryDateInput);

    // CVV
    const cvvLabel = document.createElement('label');
    cvvLabel.textContent = "CVV:";
    form.appendChild(cvvLabel);

    const cvvInput = document.createElement('input');
    cvvInput.type = "text";
    cvvInput.style.width = "100%";
    cvvInput.style.marginBottom = "10px";
    cvvInput.required = true;
    form.appendChild(cvvInput);

    // Button Container
    const buttonContainer = document.createElement('div');
    buttonContainer.style.display = "flex";
    buttonContainer.style.justifyContent = "space-between";
    form.appendChild(buttonContainer);

    // Submit Button
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
        alert('Payment process initiated!');
        pay();
        paymentFormContainer.remove();
    });
    buttonContainer.appendChild(submitButton);

    // Cancel Button
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

    // Append form to container
    paymentFormContainer.appendChild(form);
}

// Function for payment process
function pay() {
    // Add your payment process logic here
    alert('Payment process initiated!');
    var activeChartData = get_Active_ChartData();
    // Perform payment process here
    alert('Payment Successful!');
    deleteAllItems();
}

// Function to get the cart data from cookies/localStorage
function get_Active_ChartData() {
    console.log("getting get_ActiveChartData list:");
    var activeChartData = localStorage.getItem('ActiveChartData');
    return activeChartData ? JSON.parse(activeChartData) : [];
}

// Function to update the cart data in cookies/localStorage
function updateactiveChartData(activeChartData) {
    localStorage.setItem('ActiveChartData', JSON.stringify(activeChartData));
}

// Function to delete all items from the cart
function deleteAllItems() {
    if (confirm('Are you sure you want to delete all items?')) {
        // Remove all items
        var activeChartData = [];
        updateactiveChartData(activeChartData);
    }
}

showPaymentForm();