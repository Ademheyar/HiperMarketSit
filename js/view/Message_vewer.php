
<script>


function Show_Message(New_Message) {
        console.log("Show_Message view Message >>", Show_Message)
   
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
            paymentFormContainer.style.alignItems = "center";
            paymentFormContainer.style.justifyContent = "center";
            paymentFormContainer.style.zIndex = "1000";
            body.appendChild(paymentFormContainer);
            
paymentFormContainer.style.display = New_Message.length > 0 ? "flex" : "none";

            const form = document.createElement('form');
            form.style.backgroundColor = "#fafafa";
            form.style.padding = "20px";
            form.style.borderRadius = "10px";
            form.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.1)";
            //form.style.maxWidth = "400px";
            form.style.width = "100%";
            form.style.margin = "auto";

            const paymentMethodLabel = document.createElement('label');
            paymentMethodLabel.textContent = "There Is New Message Found :";
      
            form.appendChild(paymentMethodLabel);

            const paymentMethodSelect = document.createElement('select');
            paymentMethodSelect.id = "paymentMethod";
            paymentMethodSelect.style.width = "100%";
            paymentMethodSelect.style.marginBottom = "10px";
            paymentMethodSelect.required = true;
            
            New_Message.forEach(method => {
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
            buttonContainer.style.flexWrap = "wrap";
            buttonContainer.style.alignContent = "space-around";
            buttonContainer.style.alignItems = "center";
            buttonContainer.style.justifyItems = "start";
            form.appendChild(buttonContainer);

            const cancelButton = document.createElement('button');
            cancelButton.textContent = "Ok Show Me Leter";
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
                
            });
            buttonContainer.appendChild(clearallpaymentButton);
          
            paymentFormContainer.appendChild(form);

        }
        
function chacke_Message() {
    <?php 
  if(session_id() == "") session_start(); // Start the session
if(isset($_SESSION['msg']) && $_SESSION['msg']){
  foreach ($_SESSION['msg'] as $msg)
  echo "msgs found = ".$msg;
    ?>
      Show_Message(JSON.parse('<?php echo json_encode($_SESSION['msg']); ?>'));
 <?php   
}
?>

}
       </script> 