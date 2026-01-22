
// Function to get the cart data from cookies
   function get_Active_ChartData() {
      console.log("geting get_ActiveChartData list :");
      var activeChartData = localStorage.getItem('ActiveChartData');
      return activeChartData ? JSON.parse(activeChartData) : [];
   }
   
   function updte_chat_lenght(){
     var list = document.querySelector('.header .header_btns .cart_icon span');
    var ActiveChartData = localStorage.getItem('ActiveChartData');
    ActiveChartData =  ActiveChartData ? JSON.parse(ActiveChartData) : [];
    var l = 0;
    ActiveChartData.forEach(cartData => {
      if(cartData) l += cartData.length;
    });
    list.innerText = l;
   }
   
   function setNewActives() {
      // Logic to show next active items
      var activeChartData = localStorage.getItem('ActiveChartData');
      activeChartData = activeChartData ? JSON.parse(activeChartData) : [];
      var activeChartIndex = localStorage.getItem('activeChartIndex');
      if(activeChartIndex)
      {
        if(activeChartData[activeChartIndex] != [])
        { activeChartIndex = activeChartData.length; }
      }
      else activeChartIndex = 0;
      
      localStorage.setItem('activeChartIndex', activeChartIndex);
      localStorage.setItem('ActiveChartData', JSON.stringify(activeChartData));
      updte_chat_lenght();
  }
  
  function setPrevActives() {
      var activeChartIndex = localStorage.getItem('activeChartIndex');
      var activeChartData = localStorage.getItem('ActiveChartData');
      activeChartData = activeChartData ? JSON.parse(activeChartData) : [];
      activeChartIndex = activeChartIndex-1 < 0 ? activeChartData.length-1: activeChartIndex-1;
      
      localStorage.setItem('activeChartIndex', activeChartIndex);
      updte_chat_lenght();
  }
  
  function setNextActives() {
      var activeChartIndex = localStorage.getItem('activeChartIndex');
      var activeChartData = localStorage.getItem('ActiveChartData');
      activeChartData = activeChartData ? JSON.parse(activeChartData) : [];
      activeChartIndex = activeChartIndex+1 >= activeChartData.length ? 0 : activeChartIndex-1;
      
      localStorage.setItem('activeChartIndex', activeChartIndex);
      updte_chat_lenght();
  }
  
  function voidSelectedActives() {
     var activeChartData = localStorage.getItem('ActiveChartData');
      activeChartData = activeChartData ? JSON.parse(activeChartData) : [];
      var activeChartIndex = localStorage.getItem('activeChartIndex');
      if(activeChartData != [] && activeChartIndex < activeChartData.length) {
        activeChartData.splice(activeChartIndex, 1);
        activeChartIndex -= 1;
      }
      activeChartIndex = activeChartIndex < 0 ? 0: activeChartIndex;

      localStorage.setItem('activeChartIndex', activeChartIndex);
      localStorage.setItem('ActiveChartData', JSON.stringify(activeChartData));
      updte_chat_lenght();
  }
  
   // Function to update the cart data in cookies
   function updateactiveChartData(activeChartData) {
      localStorage.setItem('ActiveChartData', JSON.stringify(activeChartData));
   }

    // Function for payment process
    function pay() {
      // Add your payment process logic here
      alert('Payment process initiated!');
      Payment_start();
      var activeChartData = get_Active_ChartData();
      // Perform payment process here
      alert('Payment Successful!');
      deleteAllItems();
    }

function View_Active_Charts() {
    console.log("selected  View_Carts >>" );

    // Check if title display is enabled
    
    var vi_mainu = document.querySelector('body');
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
    view_Box.style.display = "flex";
    view_Box.style.alignItems = "center";
    view_Box.style.justifyContent = "center";
    view_Box.style.zIndex = "1000";
    vi_mainu.appendChild(view_Box);

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
    const item_keys = ["Active Id","User", "States","Total Price", "Do"];
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
    
    const Delete_btn = document.createElement('button');
    do_btn.appendChild(Delete_btn);
    //Delete_btn.classList.add('btns');
    Delete_btn.style.color = 'var(--white)';
    Delete_btn.style.textAlign = "center";
    Delete_btn.style.marginTop ="1rem";
    Delete_btn.style.backgroundColor ="var(--blue)";
    Delete_btn.style.padding ="1.2rem 3rem";
    Delete_btn.style.borderRadius ="0.5rem";
    
    Delete_btn.name="Delete";
    Delete_btn.innerText= "Delete";
    Delete_btn.value= "Delete";

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
    
    //Pay_btn.classList.add('btns_add_to_cart');
    Pay_btn.addEventListener('click', ()=>{
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

  const Done_btn = document.createElement('button');
  do_btn.appendChild(Done_btn);
  //Done_btn.classList.add('btns');
  Done_btn.style.color = 'var(--white)';
  Done_btn.style.textAlign = "center";
  Done_btn.style.marginTop ="1rem";
  Done_btn.style.backgroundColor ="var(--blue)";
  Done_btn.style.padding ="1.2rem 3rem";
  Done_btn.style.borderRadius ="0.5rem";
  
  Done_btn.name="Done";
  Done_btn.innerText= "Done";
  Done_btn.value= "Done";

    view_Box.appendChild(item_Box);
    view_Box.appendChild(do_btn);

  console.log("disply_item 'vi_info'>>"+'vs_info');
   // Function to remove an item from the cart
   
  function updateCartDisplay(){
    var activeChartData = get_Active_ChartData();
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
    
    console.log("_cart :", activeChartData);
    for (let j = 0; j < activeChartData.length; j++) {
       var chartdata = activeChartData[j];
       const tr = tbody.insertRow();
       var grandTotal = 0;
       tr.insertCell().textContent = j;
       for (let i = 0; i < chartdata.length; i++) {
         var item = chartdata[i];
         var total = item.quantity * item.price;
         grandTotal += total;

       }
       tr.insertCell().textContent = 'item.user';
       tr.insertCell().textContent = 'item.states';
       tr.insertCell().textContent = grandTotal;
       const td = tr.insertCell();
       var addButton = document.createElement("button");
       addButton.textContent = "Remove";
       addButton.addEventListener("click", () => {
         console.log("_cart :", j);
         activeChartData.splice(j, 1);
         updateactiveChartData(activeChartData);
         updateCartDisplay();
       });
       td.appendChild(addButton);
    }
  }
  
  updateCartDisplay();
   
   // Function to delete all items from the cart
   function deleteAllItems() {
      if (confirm('Are you sure you want to delete all items?')) {
         // Remove all items
         var activeChartData = [];
         updateactiveChartData(activeChartData);
         updateCartDisplay();
      }
   }
    //Clean_All_btn.classList.add('btns_add_to_cart');
    Clean_All_btn.addEventListener('click', ()=>{
        deleteAllItems();
    });
}