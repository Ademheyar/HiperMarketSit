
// Function to get the cart data from cookies
   function getCartData() {
      console.log("geting chart list :");
      var activeChartIndex = localStorage.getItem('activeChartIndex');
      var isactiveChartData = localStorage.getItem('ActiveChartData');
      var activeChartData = isactiveChartData ? JSON.parse(isactiveChartData) : [];
      var iscartData = activeChartData[activeChartIndex];
      
      return iscartData ? activeChartData[activeChartIndex]: [];
   }

   // Function to update the cart data in cookies
   function updateCartData(cartData) {
      localStorage.setItem('cartData', JSON.stringify(cartData));
   }

    // Function for payment process
    function pay() {
      // Add your payment process logic here
      alert('Payment process initiated!');
      Payment_start();
      var cartData = getCartData();
      // Perform payment process here
      alert('Payment Successful!');
      deleteAllItems();
    }

    var a_u_list = [];
   function quantity_changed(){

   }

   function chang_to_list(vs_info){
      a_u_list = [];
      var main_info = vs_info.split("},");
      for(var m = 0; main_info[m]; m++){
         a_u_list[m] = [];
         var main_value = main_info[m].split(",[");
         var size = main_value[0].replace("{", "");
         var other_info = main_value[1].split("|,");
         a_u_list[m][0] = size;
         a_u_list[m][1] = [];
         for(var o = 0; other_info[o]; o++){
            var other_value = other_info[o].split(",");
            if(other_value.length < 2) break;
            var color = other_value[0].replace("|", "");
            a_u_list[m][1][o] = [color, other_value[1]];
         }
      }
   }

   function list_size_info()
   {
      //clear
      chang_to_list(document.querySelector('.shopping-cart .p_info').value);
      var i = 0;
      var list = document.querySelector('.shopping-cart .cp_size_list');
      for(var q = list.length; q >= 0; q--)
      {
         list.options.remove(q);
      }

      for(var x = 0; a_u_list[x]; x++)
      {
         //[[45,[[black, 4], [wihte, 8]]], [32,[[black, 2], [wihte, 6]]] ]
         i++;
         var item = document.createElement('option');
         item.text = a_u_list[x][0];
         item.value = a_u_list[x][0];
         list.add(item);
      }
   }

   function list_color_info()
   {
      //clear
      chang_to_list(document.querySelector('.shopping-cart .p_info').value);
      var i = 0;
      var list = document.querySelector('.shopping-cart .cp_color_list');
      for(var q = list.length; q >= 0; q--)
      {
         list.options.remove(q);
      }

      for(var x = 0; a_u_list[x]; x++)
      {
         
         if(a_u_list[x][0] == document.querySelector('.shopping-cart .cp_size_list').value)
         {
            for(var y = 0; a_u_list[x][1][y]; y++)
            {
               var item = document.createElement('option');
               item.text = a_u_list[x][1][y][0];
               item.value = a_u_list[x][1][y][0];
               list.add(item);
            }
         }
      }
   }



   function add_new_info()
   {
      var i = 0, found = 0;
      for(var x = 0; a_u_list[x]; x++)
      {
         //[[45,[[black, 4], [wihte, 8]]], [32,[[black, 2], [wihte, 6]]] ]
         i++;
         if(a_u_list[x][0] == document.querySelector('.add-product-form .input_table .qty_box .p_size_class').value)
         {
            found = 1;
            var color_i = 0, color_found = 0;
            for(var y = 0; a_u_list[x][1][y]; y++)
            {
               color_i++;
               if(a_u_list[x][1][y][0] == document.querySelector('.add-product-form .input_table .qty_box .p_color_class').value)
               {
                  color_found = 1;
                  a_u_list[x][1][y][1] = document.querySelector('.add-product-form .input_table .qty_box .p_qty_class').value;

                  // send msg value orady there
                  break;
               }
            }
            if(color_found == 0)
            {
               a_u_list[x][1][color_i] = [document.querySelector('.add-product-form .input_table .qty_box .p_color_class').value, document.querySelector('.add-product-form .input_table .qty_box .p_qty_class').value];
            }
            break;
         }
      }
      if(found == 0)
      {
         a_u_list[i] = [document.querySelector('.add-product-form .input_table .qty_box .p_size_class').value, [[document.querySelector('.add-product-form .input_table .qty_box .p_color_class').value, document.querySelector('.add-product-form .input_table .qty_box .p_qty_class').value]]];
      }
      chang_to_text();
   }

   function remove_new_info()
   {
      var i = 0, remov_all = 0;
      for(var x = 0; a_u_list[x]; x++)
      {
         //[[45,[[black, 4], [wihte, 8]]], [32,[[black, 2], [wihte, 6]]] ]
         i++;
         if(remov_all) { a_u_list[x-1] = a_u_list[x]; continue;}

         if(a_u_list[x][0] == document.querySelector('.add-product-form .input_table .qty_box .p_size_class').value)
         {
            if(document.querySelector('.add-product-form .input_table .qty_box .p_color_class').value == "")
            { remov_all = 1; continue; }

            var color_i = 0, remove_color_qty = 0;
            for(var y = 0; a_u_list[x][1][y]; y++)
            {
               color_i++;
               if(remove_color_qty) 
               {
                  a_u_list[x][1][y-1] = a_u_list[x][1][y]; 
                  continue;
               }

               if(a_u_list[x][1][y][0] == document.querySelector('.add-product-form .input_table .qty_box .p_color_class').value)
               {
                  if(document.querySelector('.add-product-form .input_table .qty_box .p_qty_class').value == "")
                  { remove_color_qty = 1; continue; }
                  
                  if(document.querySelector('.add-product-form .input_table .qty_box .p_qty_class').value == a_u_list[x][1][y][1])
                  a_u_list[x][1][y][1] = "0";
                  break;
               }
            }
            if(remove_color_qty) a_u_list[x][1][color_i-1] = null;
            break;
         }
      }
      if(remov_all) a_u_list[i-1] = null;
      
      chang_to_text();
   }


   /*window.onscroll = () => {
        var mainy = 200;
   var sy = scrollY; 
   var y = mainy + sy;
   var chart_main = document.querySelector('body .Main');
	var ya  = y+ chart_main.scrollTop
	//document.getElementById('view-form').style.top = ya + 'px';
   if(document.querySelector('#login-form')) document.querySelector('#login-form').style.top = y + 'px';
        document.querySelector('#shopping-cart-form').style.top = y + 'px';
        menu.classList.remove('fa-times');
        navbar.classList.remove('active');
   };*/


function View_Carts() {
    console.log("selected  View_Carts >>" );
    //Payment_start();
    // Check if title display is enabled
    
    const vc_body = document.querySelector('body');
    const view_Box = document.createElement('div');
    view_Box.style.fontSize = "small";
    view_Box.style.width = "100%";
    view_Box.style.height = "100vh";
    view_Box.style.background = "rgba(0,0,0,.3)";
    view_Box.style.padding = "18px";
    view_Box.style.overflow = "hidden";
    view_Box.style.position = "fixed";
    view_Box.style.top = "0";
    view_Box.style.left = "0";
    view_Box.style.display = "block";
    view_Box.style.alignItems = "center";
    view_Box.style.justifyContent = "center";
    view_Box.style.zIndex = "1000";
    vc_body.appendChild(view_Box);

    const active_btn = document.createElement('div');
    active_btn.style.display ="flex";
    active_btn.style.gap ="1rem";
    
    const Prev_active_btn = document.createElement('button');
    active_btn.appendChild(Prev_active_btn);
    //Prev_active_btn.classList.add('btns');
    Prev_active_btn.style.color = 'var(--white)';
    Prev_active_btn.style.textAlign = "center";
    Prev_active_btn.style.marginTop ="1rem";
    Prev_active_btn.style.backgroundColor ="var(--blue)";
    Prev_active_btn.style.padding ="1.2rem 3rem";
    Prev_active_btn.style.borderRadius ="0.5rem";
    
    Prev_active_btn.name="<<";
    Prev_active_btn.innerText= "<<";
    Prev_active_btn.value= "<<";
    
    const New_active_btn = document.createElement('button');
    active_btn.appendChild(New_active_btn);
    //New_active_btn.classList.add('btns');
    New_active_btn.style.color = 'var(--white)';
    New_active_btn.style.textAlign = "center";
    New_active_btn.style.marginTop ="1rem";
    New_active_btn.style.backgroundColor ="var(--blue)";
    New_active_btn.style.padding ="1.2rem 3rem";
    New_active_btn.style.borderRadius ="0.5rem";
    
    New_active_btn.name="+";
    New_active_btn.innerText= "+";
    New_active_btn.value= "+";
    
    const Next_active_btn = document.createElement('button');
    active_btn.appendChild(Next_active_btn);
    //Next_active_btn.classList.add('btns');
    Next_active_btn.style.color = 'var(--white)';
    Next_active_btn.style.textAlign = "center";
    Next_active_btn.style.marginTop ="1rem";
    Next_active_btn.style.backgroundColor ="var(--blue)";
    Next_active_btn.style.padding ="1.2rem 3rem";
    Next_active_btn.style.borderRadius ="0.5rem";
    
    Next_active_btn.name=">>";
    Next_active_btn.innerText= ">>";
    Next_active_btn.value= ">>";
    
    // CREATE PARENTS FIRST
    const item_Box = document.createElement('div');
    item_Box.id = 'item_Box-panal';

    const table_divs = document.createElement('div');
    table_divs.style.overflowX = 'auto';
    
    const itemtable = document.createElement('table')
    itemtable.setAttribute('border', '1');
    itemtable.style.borderCollapse = 'collapse'; // = 'auto-fit';
    itemtable.style.borderSpacing = '0'; // = 'auto-fit';
    itemtable.style.borderRadius = '12px 12px 0 0'; // = 'auto-fit';
    itemtable.style.boxShadow = '0 12px 12px rgba(32, 32, 32, .3)'; // = 'auto-fit';
    itemtable.style.background = '#fafafa'; // = 'auto-fit';
    itemtable.style.textAlign = 'center'; // = 'auto-fit';
    table_divs.appendChild(itemtable);
    
    item_Box.appendChild(table_divs);
    // Create table header
    const item_keys = ["Product","Code","Color","Size","Quantity","Price","Total","Remove"];
    const itemheader = itemtable.createTHead();
    const itemheaderRow = itemheader.insertRow();
    item_keys.forEach(itemheaderText => {
        const th = document.createElement('th');
        th.style.padding = '12px 15px'; // = 'auto-fit';
        th.style.backgroundColor = '#333'; // = 'auto-fit';
        th.style.color = '#fff'; // = 'auto-fit';
        th.style.textAlign = 'center'; // = 'auto-fit';
        const text = document.createTextNode(itemheaderText);
        th.appendChild(text);
        itemheaderRow.appendChild(th);
    });
    
    const grandTotalElement = document.createElement('lable');
    grandTotalElement.textContent = "Total Price: $";
    grandTotalElement.style.display ="flex";
    grandTotalElement.style.gap ="1rem";
    
    const do_btn = document.createElement('div');
    do_btn.style.display ="flex";
    do_btn.style.gap ="1rem";
    
    const Clean_All_btn = document.createElement('button');
    do_btn.appendChild(Clean_All_btn);
    //Clean_All_btn.classList.add('btns');
    Clean_All_btn.style.color = 'var(--white)';
    Clean_All_btn.style.textAlign = "center";
    Clean_All_btn.style.marginTop ="1rem";
    Clean_All_btn.style.backgroundColor ="var(--blue)";
    Clean_All_btn.style.padding ="1.2rem 3rem";
    Clean_All_btn.style.borderRadius ="0.5rem";
    
    Clean_All_btn.name="Clean All";
    Clean_All_btn.innerText= "Clean All";
    Clean_All_btn.value= "Clean All";
    

    const Pay_btn = document.createElement('button');
    do_btn.appendChild(Pay_btn);
    //Pay_btn.classList.add('btns');
    Pay_btn.style.color = 'var(--white)';
    Pay_btn.style.textAlign = "center";
    Pay_btn.style.marginTop ="1rem";
    Pay_btn.style.backgroundColor ="var(--blue)";
    Pay_btn.style.padding ="1.2rem 3rem";
    Pay_btn.style.borderRadius ="0.5rem";
    
    Pay_btn.name="Pay";
    Pay_btn.innerText= "Pay";
    Pay_btn.value= "Pay";
    
    //Prev_active_btn.classList.add('btns_add_to_cart');
    Pay_btn.addEventListener('click', ()=>{
      console.log("inshate payment  View_Carts >>" );
        pay();
    });
    
    
  const view_Boxclose_btn = document.createElement('input');
  do_btn.appendChild(view_Boxclose_btn);
  view_Boxclose_btn.type = "button";
  view_Boxclose_btn.value = "Cancel";
  view_Boxclose_btn.style.background ="border-box";
  view_Boxclose_btn.style.color ="red";
  //view_Boxclose_btn.classList.add('btns');
  view_Boxclose_btn.style.color = 'var(--white)';
  view_Boxclose_btn.style.textAlign = "center";
  view_Boxclose_btn.style.marginTop ="1rem";
  view_Boxclose_btn.style.backgroundColor ="var(--blue)";
  view_Boxclose_btn.style.padding ="1.2rem 3rem";
  view_Boxclose_btn.style.borderRadius ="0.5rem";
  view_Boxclose_btn.classList.add('btns_add_to_cart');
  view_Boxclose_btn.addEventListener('click', ()=>{
        view_Box.remove();
    });
    
    view_Box.appendChild(active_btn);
    view_Box.appendChild(item_Box);
    view_Box.appendChild(do_btn);

  console.log("disply_item 'vs_info'>>"+'vs_info');
   // Function to remove an item from the cart
   
  function updateCartDisplay(){
    var cartData = getCartData();
    console.log("got cart list in chart.php :");
    console.log("cart list displaying:");
    // Remove old tbody if it exists
    var oldTbody = itemtable.querySelector('tbody');
    if (oldTbody) {
        oldTbody.remove();
    }
    
    // Create a new tbody
    var tbody = itemtable.createTBody();
    tbody.innerHTML = '';
    var grandTotal = 0;
    
    console.log("_cart :", cartData);
    for (let i = 0; i < cartData.length; i++) {
       var item = cartData[i];
       var total = item.quantity * item.price;
       grandTotal += total;
       const tr = tbody.insertRow();
       tr.insertCell().textContent = item.name;
       tr.insertCell().textContent = item.code;
       tr.insertCell().textContent = item.color;
       tr.insertCell().textContent = item.size;
       tr.insertCell().textContent = item.quantity;
       tr.insertCell().textContent = item.price;
       tr.insertCell().textContent = total;
       const td = tr.insertCell();
       var addButton = document.createElement("button");
       addButton.textContent = "Remove";
       addButton.addEventListener("click", () => {
         console.log("_cart :", i);
         cartData.splice(i, 1);
         updateCartData(cartData);
         updateCartDisplay();
       });
       td.appendChild(addButton);
    }
    
    grandTotalElement.textContent = grandTotal.toFixed(2);
  }
  
  updateCartDisplay();
  
   Prev_active_btn.addEventListener('click', ()=>{
        setPrevActives();
        updateCartData(cartData);
        updateCartDisplay();
    });
    
    New_active_btn.addEventListener('click', ()=>{
      setNewActives();
        updateCartData(cartData);
         updateCartDisplay();
    });
    
    Next_active_btn.addEventListener('click', ()=>{
      setNextActives();
        updateCartData(cartData);
         updateCartDisplay();
    });
   // Function to delete all items from the cart
   function deleteAllItems() {
      if (confirm('Are you sure you want to delete all items?')) {
         // Remove all items
         var cartData = [];
         updateCartData(cartData);
         updateCartDisplay();
      }
   }
    //Clean_All_btn.classList.add('btns_add_to_cart');
    Clean_All_btn.addEventListener('click', ()=>{
        deleteAllItems();
    });
}