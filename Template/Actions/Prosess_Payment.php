<?php

  $Prosess_Payment_path = "";
  if(file_exists("server/Documents/Prosess_Payment.php")) $Prosess_Payment_path = "server/Documents/Prosess_Payment.php";
 if(file_exists("../server/Documents/Prosess_Payment.php")) $Prosess_Payment_path = "../server/Documents/Prosess_Payment.php";
 if(file_exists("../../server/Documents/Prosess_Payment.php")) $Prosess_Payment_path = "../../server/Documents/Prosess_Payment.php";

    $doc_slip_path = "";
  if(file_exists("server/Documents/Slip.php")) $doc_slip_path = "server/Documents/Slip.php";
 if(file_exists("../server/Documents/Slip.php")) $doc_slip_path = "../server/Documents/Slip.php";
 if(file_exists("../../server/Documents/Slip.php")) $doc_slip_path = "../../server/Documents/Slip.php";
 ?>

<script>
function Start_Processing() {
        console.log("Start_Processing >>");
     var activeChartIndex = localStorage.getItem('activeChartIndex');
        var isactiveChartData = localStorage.getItem('ActiveChartData');
        var activeChartData = isactiveChartData ? JSON.parse(isactiveChartData) : [];
        var iscartData = activeChartData[activeChartIndex];
          
        var cartData = iscartData ? activeChartData[activeChartIndex]: [];
        var totalprice = 0;
        
        for (let i = 0; i < cartData.length; i++) {
            var item = cartData[i];
            totalprice = item.quantity * item.price;
        }
        
        let tprice = 0;
        const payments = localStorage.getItem('Payment_Lists');
        const paymentList = payments ? JSON.parse(payments) : [];
 
       var SelectedUsers = localStorage.getItem('SelectedUsers');
      SelectedUsers = !SelectedUsers ? [] : JSON.parse(SelectedUsers);
        
        paymentList.forEach(payment => { tprice += parseInt(payment.Paid); });
        const paymentleft = totalprice - tprice;
        
        const formData = new FormData();
    
             console.log("SelectedUsers -: ", SelectedUsers[0].user);
    const moreInfosList_add_custemer = document.createElement("li");
    var customerid= "";
    if(SelectedUsers.length) customerid= SelectedUsers[0].user.User_id;
         var dataobject = { activeChartIndex : activeChartIndex, paymentList : paymentList, list_items : cartData, customer_id:customerid};
        formData.append('dataobject', JSON.stringify(dataobject));

        formData.append('payment_tool_action', 'get_payment_tool_for_all_shops');


        const Prosess_Payment_path = '<?php if(isset($Prosess_Payment_path)) echo $Prosess_Payment_path; else echo ""; ?>';
        console.log("Prosess_Payment_path: ", Prosess_Payment_path);
                              
        fetch(Prosess_Payment_path, {
            method: 'POST',
            body: formData
        })
        .then(response => {console.log("response: "+response); 
        return response.json(); })
        .then(data => {
            console.log("fetched data", data);
            if (data.status === "Success") {
              alert("Good: " + data.doc_);
             const slip_path = '<?php if(isset($doc_slip_path)) echo $doc_slip_path; else echo ""; ?>';
             console.log("slip_path: ", slip_path);
             console.log("slip_path: ", data.doc_[0]);
             
             const slipformData = new FormData();
             slipformData.append('document_id', data.doc_[0]); // data.doc_[0]
                               
             fetch(slip_path, {
                 method: 'POST',
                 body: slipformData
             })
                .then(response => response.json())
                .then(slipdata => {
                     console.log("fetched slipdata", slipdata);
                   if (slipdata.status === "Success") {
                       let Slip_Lists = localStorage.getItem('Slip_Lists');
                       Slip_Lists = Slip_Lists ? JSON.parse(Slip_Lists) : [];
                   
                       // Add new payment data to the list
                       Slip_Lists.push(slipdata.doc_data);
                   
                       // Store updated payment list back into local storage
                       localStorage.setItem('Slip_Lists', JSON.stringify(Slip_Lists));
                       Show_Slip_start("Slip");
                   }
                    //document.getElementById('slip').innerText = slipdata;
                })
                .catch(error => console.error('Error fetching slip:', error.message));
            } else {
                alert("ErrorStart_Processing t0d1: " + data.message);
            }
        })
        .catch(error => {
            console.error("ErrorStart_Processing t0d2: ", error.message);
            alert("ErrorStart_Processing t0d2: "+ error.message);
        });
  }
</script>