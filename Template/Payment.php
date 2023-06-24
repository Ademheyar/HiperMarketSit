<!DOCTYPE html>
<html>
<head>
    <title>Payment Gateway</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        
        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            text-align: center;
        }
        
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="number"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 5px;
            margin-bottom: 15px;
        }
        
        .button-container {
            text-align: center;
        }
        
        .button-container button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        
        .button-container button:hover {
            background-color: #45a049;
        }
        
        .success-message {
            text-align: center;
            font-size: 24px;
            color: #4CAF50;
            margin-top: 20px;
        }
        
        .error-message {
            text-align: center;
            font-size: 24px;
            color: #e53935;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Gateway</h1>
        <div class="button-container">
            <button id="displayPaymentFormButton" onclick="displayPaymentForm()">Make Payment</button>
        </div>
        <div id="paymentFormContainer" style="display: none;">
            <form id="paymentForm" action="#" method="POST">
                <label for="cardNumber">Card Number:</label>
                <input type="text" id="cardNumber" name="cardNumber" required>

                <label for="expirationDate">Expiration Date:</label>
                <input type="text" id="expirationDate" name="expirationDate" required>

                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" required>

                <label for="billingAddress">Billing Address:</label>
                <textarea id="billingAddress" name="billingAddress" required></textarea>

                <div class="button-container">
                    <button type="button" onclick="processPayment()">Process Payment</button>
                    <button type="button" onclick="cancelPaymentForm()">Cancel</button>
                </div>
            </form>
        </div>
        <div id="approvalMessageContainer" style="display: none;">
            <div class="success-message">
                <p>Your payment has been approved. Thank you!</p>
            </div>
        </div>
        <div id="declineMessageContainer" style="display: none;">
            <div class="error-message">
                <p>We're sorry, but your payment was declined. Please try again.</p>
            </div>
        </div>
    </div>

    <script>
        function displayPaymentForm() {
            document.getElementById("displayPaymentFormButton").style.display = "none";
            document.getElementById("paymentFormContainer").style.display = "block";
        }
        
        function cancelPaymentForm() {
            document.getElementById("displayPaymentFormButton").style.display = "block";
            document.getElementById("paymentFormContainer").style.display = "none";
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
    </script>
</body>
</html>
