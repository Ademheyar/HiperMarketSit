<?php
  if (session_id() == "") session_start();
  if (isset($_POST['Set_Selected_Shop'])){
      $_SESSION['selected_company_id'] = $_POST['Set_Selected_Shop'];
      echo $_POST['Set_Selected_Shop'];
      exit();
  }


  if(file_exists("config.php")) include("config.php");
  if(file_exists("../../config.php")) include("../../config.php");
  
  $Company_profile_path = "";
  if(file_exists("server/Company/Company_profile.php")) $Company_profile_path = "server/Company/Company_profile.php";
 if(file_exists("../server/Company/Company_profile.php")) $Company_profile_path = "../server/Company/Company_profile.php";
 if(file_exists("../../server/Company/Company_profile.php")) $Company_profile_path = "../../server/Company/Company_profile.php";


  $Sell_path = "";
  if(file_exists("Template/Sell/Sell.php")) $Sell_path = "Template/Sell/Sell.php";
 if(file_exists("../Template/Sell/Sell.php")) $Sell_path = "../Template/Sell/Sell.php";
 if(file_exists("../../Template/Sell/Sell.php")) $Sell_path = "../../Template/Sell/Sell.php";
 
  if(!isset($conn)){
        $protocol = isset($_SERVER['HTTPS']);
        $doman = $_SERVER['HTTP_HOST'];
        $currontDir = dirname($_SERVER['REQUEST_URI']);
        $DIRPATHS = explode('/', $currontDir);
        $redirectURL = $protocol .$doman .$currontDir;
        include("../../config.php");
    }
    
if (!isset($ishome) or $_SESSION['on'] != 1){
    $_SESSION['on'] = 1;
    $protocol = isset($_SERVER['HTTPS']);
    $doman = $_SERVER['HTTP_HOST'];
    $currontDir = dirname($_SERVER['REQUEST_URI']);
    $redirectURL = $protocol .$doman .$currontDir;
    header("Location: ../../Home.php");
    exit; // Make sure to include exit after the header redirect
}
?>

<div class="Main">
    <div class="Sell_container">
        <button id="showButton"></button>
        <div id="animatedBox" class="tool-buttons">
            <button id="prev-actives-btn">Prev Actives</button>
            <button id="actives-btn">Actives</button>
            <button id="next-actives-btn">New Actives</button>
            <button id="void-btn">Void</button>
            <button id="payment-btn">Payment</button>
            <button id="open-cash-drawer-btn">Open Cash Drawer</button>
            <div id="paymentbox" class="paymentbuttons">
              
            </div>
        </div>
 
        <div class="selected-items">
            <ul id="selected-items"></ul>
        </div>
        
        <div class="states-Info-bar">
            <ul id="More-infos"></ul>
        </div>
        
        <div class="states-bar">
            <ul id="selling-infos"></ul>
        </div>
    </div>
</div>

<script>
    var Selected_Items_Infos = [];
    const sellingItems = [];
    var loded_paymemt_tools = [];
    let Total_discount = 0;

    const selectedItemsList = document.getElementById("selected-items");
    
    const moreInfosList = document.getElementById("More-infos");
    moreInfosList.style.display = "flex";
    
    const userprofile = document.createElement("li");
    userprofile.textContent = '<?php if(isset( $_SESSION['loged_user_info']['user_name'])) echo $_SESSION['loged_user_info']['user_name']; else echo "User Profile"; ?>';
    moreInfosList.appendChild(userprofile);
    
    const atshoplable = document.createElement("li");
    
    

    const User_shops = document.createElement("select");
    User_shops.className = `combobox`;
    const ust = '<?php if(isset( $_SESSION['loged_user_info']['User_work_shop'])) echo $_SESSION['loged_user_info']['User_work_shop']; else echo "[]"; ?>';
    console.log("geting ust list :", ust);
    var usershops = JSON.parse(ust);
    usershops = usershops ? usershops.map(usershop => [usershop[0], usershop[1]]):[];
    usershops.forEach(option => {
        const opt = document.createElement("option");
        opt.value = option[1];
        opt.shop_id = option[0];
         opt.addEventListener('click', () => {
             let selected_id = opt.shop_id;
             change_selected_shop(selected_id);
        });
        opt.textContent = option;
        User_shops.appendChild(opt);
    });
    moreInfosList.appendChild(User_shops);
    function change_selected_shop(selected_id){
            const this_path = '<?php if($Sell_path !== "") echo $Sell_path; ?>';
             console.log("this_path: ", this_path);
             const formData = new FormData();
             formData.append('Set_Selected_Shop', selected_id); // data.doc_[0]
                               
             fetch(this_path, {
                 method: 'POST',
                 body: formData
             })
            .then(response => response.json())
            .then(selected_shop_data => {
               atshoplable.textContent = usershops[selected_shop_data][1];
            })
            .catch(error => console.error('Error fetching slip:', error.message));
        }
    if(usershops.length == 1) change_selected_shop(0)
    
    moreInfosList.appendChild(atshoplable);
    
       var SelectedUsers = localStorage.getItem('SelectedUsers');
      SelectedUsers = !SelectedUsers ? [] : JSON.parse(SelectedUsers);
    
             console.log("SelectedUsers -: ", SelectedUsers);
    const moreInfosList_add_custemer = document.createElement("li");
    if(SelectedUsers.length) moreInfosList_add_custemer.textContent = "-"+SelectedUsers[0].user.user_name;
    else moreInfosList_add_custemer.textContent = "+Add Custemer";
    moreInfosList_add_custemer.style.color = "blue";
     moreInfosList_add_custemer.addEventListener('click', () => {
             var SelectedUsers = localStorage.getItem('SelectedUsers');
      SelectedUsers = !SelectedUsers ? [] : JSON.parse(SelectedUsers);
         if(SelectedUsers.length){
              SelectedUsers.splice(0, 1);
              localStorage.setItem('SelectedUsers', JSON.stringify(SelectedUsers));
              console.log("SelectedUsers :", SelectedUsers);
        }
        else  Payment_start('Select_User', loded_paymemt_tools); 
        if(SelectedUsers.length) moreInfosList_add_custemer.textContent = "-"+SelectedUsers[0].user.user_name;
        else moreInfosList_add_custemer.textContent = "+Add Custemer";
        });
    moreInfosList.appendChild(moreInfosList_add_custemer);
    
    
    
    const sellingInfosList = document.getElementById("selling-infos");
   sellingInfosList.style.display = "flex";
   //sellingInfosList.style.position = 'absolute';
           sellingInfosList.style.justifyContent = 'center';
        sellingInfosList.style.gap = '5rem';
        sellingInfosList.style.alignItems = 'center';
        sellingInfosList.style.alignContent = 'space-between';
        //sellingInfosList.style.flexWrap = 'wrap';
        sellingInfosList.style.flexDirection = 'row';
        sellingInfosList.style.flexWrap = 'wrap';
  
    function renderSellingInfos() {
            sellingInfosList.innerHTML = '';
            var activeChartIndex = localStorage.getItem('activeChartIndex');
      var isactiveChartData = localStorage.getItem('ActiveChartData');
      var activeChartData = isactiveChartData ? JSON.parse(isactiveChartData) : [];
      var iscartData = activeChartData[activeChartIndex];
      var cartData = iscartData ? activeChartData[activeChartIndex]: [];

            const totalItems = cartData.reduce((sum, item) => sum + parseInt(item.quantity), 0);
            const totalPrice = cartData.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const totalTax = totalPrice * 0.10;
            const totalItemDiscount = cartData.reduce((sum, item) => sum + (item.Price - item.price), 0);
            const totalDiscounted = Total_discount;
            const priceAfter = totalPrice - totalItemDiscount - totalDiscounted - totalTax;

            const sellingInfos = [
                { info: `Total Items: ${totalItems}` },
                { info: `Total Tax: ${totalTax.toFixed(2)}` },
                { info: `Total Item Discount: ${totalItemDiscount.toFixed(2)}` },
                { info: `Total Discounted: ${totalDiscounted.toFixed(2)}` },
                { info: `Total Price Before : ${totalPrice.toFixed(2)}` },
                { info: `Total Price After : ${priceAfter.toFixed(2)}` }
            ];

            sellingInfos.forEach((info) => {
                const listItem = document.createElement("li");
                listItem.textContent = info.info;
                sellingInfosList.appendChild(listItem);
            });
        }


    function updateCartDisplay(){
      console.log("geting chart list :");
      var activeChartIndex = localStorage.getItem('activeChartIndex');
      var isactiveChartData = localStorage.getItem('ActiveChartData');
      var activeChartData = isactiveChartData ? JSON.parse(isactiveChartData) : [];
      var iscartData = activeChartData[activeChartIndex];
      var cartData = iscartData ? activeChartData[activeChartIndex]: [];

      console.log("got cart list in chart.php :");
      console.log("cart list displaying:");
      // Remove old if it exists
     while(selectedItemsList.firstChild) selectedItemsList.removeChild(selectedItemsList.firstChild);
     
      console.log("_cart :", cartData);
      for (let i = 0; i < cartData.length; i++) {
         var item = cartData[i];
         
         const listItem = document.createElement("li");
         const deleteBtn = document.createElement("button");
         deleteBtn.className = "delete-btn";
         deleteBtn.textContent = "X";
         deleteBtn.style.width = "30px";
         deleteBtn.addEventListener('click', () => {
           cartData.splice(i, 1);
           localStorage.setItem('activeChartIndex', activeChartIndex);
      localStorage.setItem('ActiveChartData', JSON.stringify(activeChartData));
           updateCartDisplay();
        });
        
        listItem.appendChild(deleteBtn);
        
         var url = 'server/Products/Product.php'; // The PHP script that fetches items from the database
         var datasent = 'Search_Same_Query=Search_Same_Query&Search_Query_value=' + item.id + '&search_what=ID'+ '&limit=1';
         // Make an AJAX request to your PHP API
        sendAjaxRequest(url, 'POST', datasent, function(responseText) {
               var response = JSON.parse(responseText);
                 console.log("response sell items load ", response);
               response.result.forEach((value, index) => {
                 
                 console.log("response.result ", response.result);
                 console.log("response.result ", value.more_info);
                 //more_info
                 let loaded_info =  JSON.parse(value.more_info);
                 if(loaded_info && loaded_info.length > 0){
                   
                   listItem.loaded_info = loaded_info;
                   const itemInfo = document.createElement("div");
                  itemInfo.className = "item-info";
                  itemInfo.style.display = "block";
                
                  itemInfo.innerHTML = `
                      <div><strong>${value.name}</strong></div>
                  `;
                  const editInfo = document.createElement("div");
                  editInfo.className = "item-info";
                  editInfo.style.display = "flex";
                  //editInfo.style.justifyContent = 'center';
                  //editInfo.style.alignItems = 'center';
                  //editInfo.style.alignContent = 'space-between';
                  //sellingInfosList.style.flexWrap = 'wrap';
                  editInfo.style.flexDirection = 'row';
                  editInfo.style.flexWrap = 'wrap';
          
                  const shopSelect = document.createElement("select");
                  shopSelect.value = item.shop;
                  const codeSelect = document.createElement("select");
                 codeSelect.value = item.code;
                 const colorSelect = document.createElement("select");
                  colorSelect.value = item.color;
                 const sizeSelect = document.createElement("select");
                  sizeSelect.value = item.size;
                 const exBarcode_lable = document.createElement('p');
                  exBarcode_lable.fontSize = '6px';
                 exBarcode_lable.value = "exBarcode : " + item.ex_doc +",   ";
                 exBarcode_lable.innerText = "exBarcode : " + item.ex_doc +",   ";
                     
                 const Barcode_lable = document.createElement('p');
                  Barcode_lable.fontSize = '6px';
                 Barcode_lable.value = "Barcode ";
                 Barcode_lable.innerText = "Barcode ";
                 
                 const qtyInputlabel = document.createElement('p');
                 qtyInputlabel.textContent = "QTY \n Max is " + item.Quantity;
                 const qtyInput = document.createElement("input");
                    qtyInput.type = "number";
                    qtyInput.value = item.quantity;
                    qtyInput.style.width = "50px";
                    qtyInput.min = 1;
                 const itempricelabel = document.createElement('p');
                 itempricelabel.textContent = "Price is " + item.Price;
                 itempricelabel.style.display = "block";
                 const itemprice = document.createElement("input");
                    itemprice.type = "number";
                    itemprice.value =(parseInt(item.price));
                    itemprice.style.width = "70px";
                    itemprice.min = 1;
                 const itemtotalpricelabel = document.createElement('p');
                 itemtotalpricelabel.textContent = "Total Price :";
                 itemtotalpricelabel.style.display = "block";
                 const itemtotalprice = document.createElement("input");
                    itemtotalprice.type = "number";
                    itemtotalprice.value = (item.price * item.quantity);
                    itemtotalprice.style.width = "70px";
                    itemtotalprice.min = 1;
                    
                  function add_combobox_value(options, addto, deff_value){
                    while(addto.firstChild) selectedItemsList.removeChild(addto.firstChild);
                    var onindex = 0;
                    options.forEach((option, i) => {
                          const opt = document.createElement("option");
                          opt.value = option;
                          opt.textContent = option;
                          addto.appendChild(opt);
                          console.log('deff_value ', deff_value);
                          console.log('option.value ', option);
                          if(deff_value === "" || option === deff_value) onindex = i;
                   });
                      addto.selectedIndex = onindex;
                  }
                  
                  function get_next_value(fshop, fcode, fcolor, fsize){
                   let snames = [];
                   for(var sn = 0; sn < loaded_info.length; sn++){
                     const shop_info = loaded_info[sn];
                      if(fshop == shop_info[0])
                      {
                        let cnames = [];
                        for(var cn = 0; cn < shop_info[1].length; cn++){
                          const code_info = shop_info[1][cn];
                          if(fcode == code_info[0])
                          {
                            let conames = [];
                            for(var con = 0; con < code_info[1].length; con++){
                              const color_info = code_info[1][con];
                          if(fcolor == color_info[0])
                          {
                            let sinames = [];
                          for(var sin = 0; sin < color_info[1].length; sin++){
                            const size_info = color_info[1][sin];
                              if(fsize == size_info[0])
                              {
                                // add barcode 
                                
                               qtyInputlabel.textContent = "QTY  Max is " + size_info[1][0][1];
                               qtyInputlabel.appendChild(qtyInput);
                                sinames = []
                               sizeSelect.selectedIndex = sin;
                           sizeSelect.innerHTML = `<option value="`+fsize+`">`+fsize+`</option>`;
                                break;
                              }
                              else {
                                  sinames[cn] = color_info[1][cn][0];
                              }
                            }
                            if(sinames.length > 0)
                               add_combobox_value(sinames, sizeSelect, fsize);
                           conames = []
                            colorSelect.selectedIndex = con;
                           colorSelect.innerHTML = `<option value="`+fcolor+`">`+fcolor+`</option>`;
                           break;
                          }
                          else {
                              conames[cn] = code_info[1][cn][0];
                              }
                            }
                          if(conames.length > 0) add_combobox_value(conames, colorSelect, fcolor);
                       cnames = []
                            codeSelect.selectedIndex = cn;
                              codeSelect.innerHTML = `<option value="`+fcode+`">`+fcode+`</option>`;
                       break;
                          }
                          else {
                              cnames[cn] = shop_info[1][cn][0];
                          }
                        }
                       if(cnames.length > 0)
                       add_combobox_value(cnames, codeSelect, fcode);
         
                       snames = []
                        shopSelect.selectedIndex = sn;
                        shopSelect.innerHTML = `<option value="`+fshop+`">`+fshop+`</option>`;
                       break;
                      }
                      else{
                        snames[sn] = loaded_info[sn][0];
                      }
                   }
                   if(snames.length > 0) add_combobox_value(snames, shopSelect, fshop);
                 }
                 function updat_cart(){
                   //Barcode_lable.value = "Barcode ";       
                  cartData[i].shop = shopSelect.value;
                  cartData[i].code = codeSelect.value;
                  cartData[i].color = colorSelect.value;
                  cartData[i].size = sizeSelect.value;
                  cartData[i].quantity = qtyInput.value;
                  cartData[i].price = itemprice.value;
                  localStorage.setItem('activeChartIndex', activeChartIndex);
      localStorage.setItem('ActiveChartData', JSON.stringify(activeChartData));
                  renderSellingInfos();
                 }
                shopSelect.addEventListener('click', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value);
                  updat_cart();
                });
              
                codeSelect.addEventListener('click', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value); updat_cart();
                });
                
                colorSelect.addEventListener('click', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value); updat_cart();
                });
                
               sizeSelect.addEventListener('click', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value); updat_cart();
               });
               
              shopSelect.addEventListener('change', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value);
                  updat_cart();
                });
              
                codeSelect.addEventListener('change', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value); updat_cart();
                });
                
                colorSelect.addEventListener('change', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value); updat_cart();
                });
                
               sizeSelect.addEventListener('change', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value); updat_cart();
               });
              
              qtyInput.addEventListener('input', (e) => {
                        get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value);
                        itemtotalprice.value = (parseInt(itemprice.value) * parseInt(qtyInput.value));
                        updat_cart();
                    });      
            itemprice.addEventListener('input', (e) => {
                        itemtotalprice.value = (parseInt(itemprice.value) * parseInt(qtyInput.value));
                        updat_cart();
                    });      
                    
             itemtotalprice.addEventListener('input', (e) => {
                        itemtotalprice.value = (parseInt(itemprice.value) * parseInt(qtyInput.value));
                        localStorage.setItem('activeChartIndex', activeChartIndex);
      localStorage.setItem('ActiveChartData', JSON.stringify(activeChartData));
                        renderSellingInfos();
                    });             
                 
             get_next_value(item.shop, item.code, item.color, item.size);
                    
                    itemInfo.appendChild(Barcode_lable);
                    itemInfo.appendChild(exBarcode_lable);
                    editInfo.appendChild(shopSelect);
                    editInfo.appendChild(codeSelect);
                    editInfo.appendChild(colorSelect);
                    editInfo.appendChild(sizeSelect);
                    editInfo.appendChild(qtyInputlabel);
                    qtyInputlabel.appendChild(qtyInput);
                    editInfo.appendChild(itempricelabel);
                    itempricelabel.appendChild(itemprice);
                    editInfo.appendChild(itemtotalpricelabel);
                    itemtotalpricelabel.appendChild(itemtotalprice);
                    
                    itemInfo.appendChild(editInfo);
                    listItem.appendChild(itemInfo);
                    //listItem.selecters = [shopSelect, codeSelect, colorSelect, sizeSelect, qtyInput];
                    //updateSelectedItemProperty(shopSelect);
                 }
               });
        }, function(errorStatus) { console.log('Error: ' + errorStatus);});
          selectedItemsList.appendChild(listItem);
      }
      var activeChartIndex = localStorage.getItem('activeChartIndex');
      var isactiveChartData = localStorage.getItem('ActiveChartData');
      let oldactiveChartIndex = activeChartIndex;
      let oldactiveChartData = activeChartData;
      renderSellingInfos();
  }
  
  function showPrevActives() {
      setPrevActives();
      // Logic to show previous active items
      updateCartDisplay();
  }
  
  function showActives() {
    View_Active_Charts();
      alert('Showing active items...');
      // Logic to show active items
  }
  
  function showNextActives() {
      // Logic to show next active items
      setNewActives();
      alert('Showing next active items...', activeChartIndex);
      updateCartDisplay();
  }
  
  function voidSelectedItems() {
     voidSelectedActives(); // in chart.php or chart.js
	localStorage.setItem('Payment_Lists', JSON.stringify([]));
     updateCartDisplay();
  }
    
  updateCartDisplay();
    
    let selectedItems = [];
    let tempSelectedItems = [];
    
  const showButton = document.getElementById('showButton');
  const animatedBox = document.getElementById('animatedBox');
  
  showButton.addEventListener('click', function() {
    animatedBox.classList.toggle('show');
  });
  
  function fetchPaymentToolsForAllShops() {
        console.log("fetchPaymentToolsForAllShops");
        const formData = new FormData();
        formData.append('payment_tool_action', 'get_payment_tool_for_all_shops');
const Company_profile_path = '<?php if(isset($Company_profile_path)) echo $Company_profile_path; else echo ""; ?>';
console.log("Company_profile_path: ", Company_profile_path);
        function add_payment_btn(data){
            const pbox = animatedBox.querySelector('.paymentbuttons');
              if(pbox) {
                pbox.innerHTML = ''; // Clear existing table if any);
                pbox.style.display = "flex";
                pbox.style.gap = "2px";
                //pbox.style.justifyContent = 'center';
                //pbox.style.alignItems = 'center';
                 pbox.style.alignContent = 'space-between';
                 
                  pbox.style.flexDirection = 'row';
                  pbox.style.flexWrap = 'wrap';
                data.forEach(tool => {
                    console.log("fetched .paymentbuttons : ", tool);
                    const pbtn = document.createElement("button");
                    pbtn.textContent = tool[0]+" "+tool[1];
                    pbtn.style.padding= "15px";
                    pbtn.style.backgroundColor = "#28a745";
                    pbtn.style.color = "#fff";
                    pbtn.style.padding = "10px 20px";
                    pbtn.style.border = "none";
                    pbtn.style.borderRadius = "5px";
                    pbtn.style.cursor = "pointer";
                    pbtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        Payment_start(tool[0], loded_paymemt_tools);
                    });
                    pbox.appendChild(pbtn);
                });
              }
        }
        /*sendAjaxRequest(Company_profile_path, 'POST', formData, function(responseText) {
               var data = JSON.parse(responseText);       
               console.log("fetched data", data);
            if (data.payment_tools) {
              loded_paymemt_tools = data.payment_tools;
              add_payment_btn(loded_paymemt_tools);
            } else {
                alert("Errorpayment_toolst0d1: " + data.message);
            }
        }, function(errorStatus) { console.error("Errorpayment_toolst0d2: ", error);
            alert("Errorpayment_toolst0d2: "+ error);});*/
        
        fetch(Company_profile_path, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("fetched data", data);
            if (data.payment_tools) {
              loded_paymemt_tools = data.payment_tools;
              add_payment_btn(loded_paymemt_tools);
            } else {
                alert("Errorpayment_toolst0d1: " + data.message);
            }
        })
        .catch(error => {
            console.error("Errorpayment_toolst0d2: ", error.message);
            alert("Errorpayment_toolst0d2: "+ error);
        });
    }
    // Add payment buttons
    fetchPaymentToolsForAllShops();

        
        
        
        
        
        

        function createComboBox(options, className) {
            const select = document.createElement("select");
            select.className = `combobox ${className}`;
            options.forEach(option => {
                const opt = document.createElement("option");
                opt.value = option;
                opt.textContent = option;
                select.appendChild(opt);
            });
            return select;
        }

        function renderSelectedItems() {
            selectedItemsList.innerHTML = '';

            selectedItems.forEach((item, index) => {
                const listItem = document.createElement("li");
                
                const deleteBtn = document.createElement("button");
                deleteBtn.className = "delete-btn";
                deleteBtn.textContent = "X";
                deleteBtn.addEventListener('click', () => {
                    selectedItems.splice(index, 1);
                    renderSelectedItems();
                    renderSellingInfos();
                });

                const itemInfo = document.createElement("div");
                itemInfo.className = "item-info";
                itemInfo.innerHTML = `
                    <div><strong>${item.name}</strong></div>
                    <div>Price: $${(item.price * item.qty).toFixed(2)}</div>
                `;

                const codeSelect = createComboBox(item.codes, 'code');
                codeSelect.addEventListener('change', (e) => {
                    updateSelectedItemProperty('code', e.target.value, index);
                });

                const colorSelect = createComboBox(item.colors, 'color');
                colorSelect.addEventListener('change', (e) => {
                    updateSelectedItemProperty('color', e.target.value, index);
                });

                const sizeSelect = createComboBox(item.sizes, 'size');
                sizeSelect.addEventListener('change', (e) => {
                    updateSelectedItemProperty('size', e.target.value, index);
                });

                const qtyInput = document.createElement("input");
                qtyInput.type = "number";
                qtyInput.className = "combobox";
                qtyInput.value = item.qty;
                qtyInput.min = 1;
                qtyInput.addEventListener('input', (e) => {
                    updateSelectedItemProperty('qty', parseInt(e.target.value, 10), index);
                });

                itemInfo.appendChild(codeSelect);
                itemInfo.appendChild(colorSelect);
                itemInfo.appendChild(sizeSelect);
                itemInfo.appendChild(qtyInput);

                listItem.appendChild(deleteBtn);
                listItem.appendChild(itemInfo);
                
                selectedItemsList.appendChild(listItem);
            });

            renderSellingInfos();
        }

        function addToSelectedItems(item) {
            if (!selectedItems.includes(item)) {
                selectedItems.push(item);
                const selectedItem = document.createElement("li");

                const qtyInput = document.createElement("input");
                qtyInput.type = "number";
                qtyInput.value = 1;
                qtyInput.min = 1;
                qtyInput.addEventListener('input', () => updateQuantity(item, qtyInput.value));

                const itemInfo = document.createElement("div");
                itemInfo.className = "item-info";
                itemInfo.innerHTML = `
                    <div><strong>${item.name}</strong></div>
                    <div>Code: ${item.code}</div>
                    <div>Color: ${item.color}</div>
                    <div>Size: ${item.size}</div>
                    <div>Price: $${item.price.toFixed(2)}</div>
                `;

                selectedItem.appendChild(qtyInput);
                selectedItem.appendChild(itemInfo);
                selectedItemsList.appendChild(selectedItem);
                renderSellingInfos();
            }
        }

        function updateQuantity(item, quantity) {
            item.quantity = quantity;
            renderSellingInfos();
        }



        

        // Add event listeners for tool buttons
        document.getElementById('prev-actives-btn').addEventListener('click', () => {
            showPrevActives();
        });
        
        document.getElementById('actives-btn').addEventListener('click', () => {
            showActives();
        });

        document.getElementById('next-actives-btn').addEventListener('click', () => {
            showNextActives();
        });
        
        document.getElementById('void-btn').addEventListener('click', () => {
            voidSelectedItems();
        });

        document.getElementById('payment-btn').addEventListener('click', () => {
            processPayment();
        });

        document.getElementById('open-cash-drawer-btn').addEventListener('click', () => {
            openCashDrawer();
        });
        
        

        

        

        function changeQuantity() {
            // Logic to change quantity for selected items
            selectedItems.forEach(item => {
                const newQty = prompt(`Enter new quantity for ${item.name}:`, item.qty);
                if (newQty !== null) {
                    item.qty = parseInt(newQty, 10);
                }
            });
            renderSelectedItems();
            renderSellingInfos();
        }

        function processPayment() {
            Payment_start('Show', loded_paymemt_tools);
        }

        function openCashDrawer() {
            alert('Opening cash drawer...');
            // Logic to open cash drawer
        }

        

        


        /*document.getElementById('choose-customer-btn').addEventListener('click', () => {
            chooseCustomer();
        });
        function chooseCustomer() {
            alert('Choosing customer...');
            // Logic to choose customer
        }*/
        

  
    </script>
<style>
    body .Main {
        overflow-y: scroll;
        top: 5%;
        width: 100%;
        height: 100%;
        align-items: flex-start;
        background: #f8f8ff
    }
        .selected-items, .states-bar, .states-Info-bar {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 15px;
            gap: 0px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .Sell_container .tool-buttons {
            position: absolute;
            right: 20px;
            width: 25%;
            transition: width 0.5s ease;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .Sell_container .tool-buttons button {
            
            margin-bottom: 10px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 15px;
            cursor: pointer;
        }

        .Sell_container .tool-buttons button:hover {
            background-color: #45a049;
        }
        
       /* CSS styles for show button and animation */
       .Sell_container .show {
          width: 100%;
        }

        #showButton {
          display: none;
        }
      
       .Sell_container .selected-items {
            flex-grow: 1;
            height: 50%;  /* Set a height to enable scrolling */
            overflow: auto; /* Enable scroll if content exceeds height */
            width: 70%; /* Adjust width based on container padding */
        }

        .Sell_container .states-bar, .states-Info-bar {
            width: 70%;
        }

        .Sell_container ul {
            list-style-type: none;
            padding: 0;
        }

        .Sell_container li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
        }

        .Sell_container li:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .Sell_container .item-info {
            display: flex;
            align-items: center;
            gap: 10px; /* Add space between the flex items */
            flex-grow: 1;
            margin-left: 10px;
        }

        .Sell_container .combobox {
            margin-left: 10px;
            padding: 5px;
            width: auto; /* Ensure comboboxes are appropriately sized */
        }

        .Sell_container .delete-btn {
            background-color: red;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            padding: 5px 10px;
        }

        .Sell_container .delete-btn:hover {
            background-color: darkred;
        }

        @media (max-width: 768px) {
            .Sell_container .selected-items, .Sell_container {
                width: 100%;
                margin-right: 0;
                
            }
        
        .Sell_container .tool-buttons {
            position: absolute;
            right: 20px;
            width: 0%;
            transition: width 0.5s ease;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .Sell_container .tool-buttons button {
            display: none;
        }
  
          .Sell_container .tool-buttons button:hover {
              background-color: #45a049;
          }
                 /* CSS styles for show button and animation */
         .Sell_container .show {
            width: 90%;
          }
          
         .Sell_container .show button {
            display: inline;
        }
        
          #showButton {
            display: block;
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            z-index: 1;
            font-size: 20px;
            background: none;
            border: none;
            cursor: pointer;
          }
    
          #showButton::before {
            content: "<";
          }
    
          #showButton.show::before {
            content: ">";
          }
        }
    </style>