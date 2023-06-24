
<!-- Creating the form-box -->
<div id="shopping-cart-form" class="shopping-cart">
   <h1 class="heading">Cart Lists</h1>
   <table>
      <thead>
            <tr>
               <th>Product</th>
               <th>Size</th>
               <th>Color</th>
               <th>Quantity</th>
               <th>Price</th>
               <th>Total</th>
               <th>Remove</th>
            </tr>
      </thead>
      <tbody id="cart-items">
            <!-- Cart items will be dynamically added here -->
      </tbody>
   </table>
   <!-- Total price display -->
   <div class="total-price">Total Price: $<span id="grand-total"></span></div>

   <!-- Clean All button to delete all items -->
   <button type="button" onclick="deleteAllItems();" class="clean-btn">Clean All</button>

   <!-- Pay button for payment process -->
   <button type="button" onclick="pay();" class="pay-btn">Pay</button>

   <!-- Cancel button to close the form -->
   <button type="button" onclick="cancelForm();" class="cancel-btn">Cancel</button>
</div>

<!-- Add Item form -->
<div id="add-item-form" class="add-item-form">
   <h2 class="heading">Add Item</h2>
   <form onsubmit="addNewItem(event)">
      <label for="product-name">Product:</label>
      <input type="text" id="product-name" required><br>

      <label for="product-size">Size:</label>
      <input type="text" id="product-size" required><br>

      <label for="product-color">Color:</label>
      <input type="text" id="product-color" required><br>

      <label for="product-quantity">Quantity:</label>
      <input type="number" id="product-quantity" min="1" required><br>

      <label for="product-price">Price:</label>
      <input type="number" id="product-price" min="0" step="0.01" required><br>

      <button type="submit">Add</button>
   </form>
   <button type="button" onclick="cancelForm()">Cancel</button>
</div>

<script>
   // Function to get the cart data from cookies
   function getCartData() {
      var cartData = localStorage.getItem('cartData');
      return cartData ? JSON.parse(cartData) : [];
   }

   // Function to update the cart data in cookies
   function updateCartData(cartData) {
      localStorage.setItem('cartData', JSON.stringify(cartData));
   }

   // Function to initialize the cart data and display it
   function initializeCartData() {
      var cartData = getCartData();
      updateCartDisplay(cartData);
   }

   // Function to update the cart display
   function updateCartDisplay(cartData) {
      var cartItemsContainer = document.getElementById('cart-items');
      var grandTotalElement = document.getElementById('grand-total');
      cartItemsContainer.innerHTML = '';
      var grandTotal = 0;

      for (var i = 0; i < cartData.length; i++) {
            var item = cartData[i];
            var total = item.quantity * item.price;
            grandTotal += total;

            var row = document.createElement('tr');
            row.innerHTML = `
               <td>${item.product}</td>
               <td>${item.size}</td>
               <td>${item.color}</td>
               <td>${item.quantity}</td>
               <td>${item.price}</td>
               <td>${total}</td>
               <td><button type="button" onclick="removeItem(${i})">Remove</button></td>
            `;

            cartItemsContainer.appendChild(row);
      }

      grandTotalElement.textContent = grandTotal.toFixed(2);
   }

   // Function to add a new item to the cart
   function addNewItem(event) {
      event.preventDefault();

      var productName = document.getElementById('product-name').value;
      var productSize = document.getElementById('product-size').value;
      var productColor = document.getElementById('product-color').value;
      var productQuantity = parseInt(document.getElementById('product-quantity').value);
      var productPrice = parseFloat(document.getElementById('product-price').value);

      var newItem = {
            product: productName,
            size: productSize,
            color: productColor,
            quantity: productQuantity,
            price: productPrice
      };

      var cartData = getCartData();
      cartData.push(newItem);
      updateCartData(cartData);
      updateCartDisplay(cartData);

      cancelForm();
   }

   // Function to remove an item from the cart
   function removeItem(index) {
      var cartData = getCartData();
      cartData.splice(index, 1);
      updateCartData(cartData);
      updateCartDisplay(cartData);
   }

   // Function to delete all items from the cart
   function deleteAllItems() {
      var cartData = [];
      updateCartData(cartData);
      updateCartDisplay(cartData);
   }

   // Function to simulate payment process
   function pay() {
      var cartData = getCartData();
      // Perform payment process here
      alert('Payment Successful!');
      deleteAllItems();
   }

   // Function to cancel the form
   function cancelForm() {
      document.getElementById('add-item-form').style.display = 'none';
   }

   // Function to show the add item form
   function showAddItemForm() {
      document.getElementById('add-item-form').style.display = 'block';
   }

   // Initialize the cart data and display
   initializeCartData();

    // Function to remove a cart item
    function removeCartItem(cartId) {
        // Remove only selected item
    }

    // Function to delete all items
    function deleteAllItems() {
        if (confirm('Are you sure you want to delete all items?')) {
         // Remove all items
        }
    }

    // Function for payment process
    function pay() {
        // Add your payment process logic here
        alert('Payment process initiated!');
    }

    // Function to cancel the form and close it
    function cancelForm() {
        document.getElementById('shopping-cart-form').style.display = 'none';
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
   window.onscroll = () => {
        var mainy = 200;
        
   var sy = scrollY; 
   var y = mainy + sy;
   var a = document.querySelector('body .Main');
	var ya  = y+ a.scrollTop
	document.getElementById('view-form').style.top = ya + 'px';
        if(document.querySelector('#login-form')) document.querySelector('#login-form').style.top = y + 'px';
        document.querySelector('#shopping-cart-form').style.top = y + 'px';
        menu.classList.remove('fa-times');
        navbar.classList.remove('active');
    };

	function chart_start()
	{
		var mainy = 200;
		var sy = scrollY;
      var y = sy;
      document.querySelector('#shopping-cart-form').style.top = mainy+ y + 'px';
      document.getElementById('shopping-cart-form').style.display='block'; 
      document.getElementById('login-form').style.display='none';
      document.getElementById('view-form').style.display='none'; 
	} 

	// this is for the when you click out the login or registration page the form -box disappears 
   var modal =document.getElementById('login-form');
	window.onclick = function(event)
	{
		if (event.target == modal)
		{
		   modal.style.display = "none";
		}
	}

</script>

<style>
   

.shopping-cart table {
  text-align: center;
  width: 100%;
  border-collapse: collapse;
  overflow-x: scroll;
    margin: auto;
    padding: 1%;
    width: 82rem;
    /* display: inline-table; */
    /* overflow-x: scroll; */
    grid-template-columns: repeat(auto-fit, 20rem);
    gap: 11.5rem;
    justify-content: center;
    line-height: 100%;
    margin-right: 19px;
    text-align: center;
    padding: 18rem;
    box-shadow: var(--box-shadow);
    border: var(--border);
    border-radius: 12.5rem;
    align-items: center;
    align-content: space-between;
}

.shopping-cart table thead th {
  padding: 1.5rem;
  font-size: 2rem;
  color: var(--white);
  background-color: var(--black);
}

.shopping-cart table tbody td {
      font-size: 2rem;
    gap: 10rem;
    font-family: cursive;
    color: #f5f5f5;
    border-bottom: var(--border);
}

.shopping-cart table tbody tr:last-child td {
  border-bottom: none;
}

.shopping-cart table input[type="number"] {
  border: var(--border);
  padding: 1rem 2rem;
  font-size: 2rem;
  color: var(--black);
  width: 10rem;
}

.shopping-cart table select {
  border: var(--border);
  padding: 1rem 2rem;
  font-size: 2rem;
  color: var(--black);
  width: 10rem;
}

.shopping-cart table input[type="submit"] {
  padding: 0.5rem 1.5rem;
  cursor: pointer;
  font-size: 2rem;
  background-color: var(--orange);
  color: var(--white);
}

.shopping-cart table input[type="submit"]:hover {
  background-color: var(--black);
}

.shopping-cart table .table-bottom {
  background-color: var(--bg-color);
}

.shopping-cart .total-price {
  margin-top: 2rem;
  font-size: 2rem;
  color: var(--white);
}

.shopping-cart .no-items {
  margin-top: 2rem;
  font-size: 2rem;
  color: var(--white);
}

.shopping-cart .checkout-btn {
  text-align: center;
  margin-top: 1rem;
}

.shopping-cart .checkout-btn a {
  display: inline-block;
width: 100%;
}

.shopping-cart .checkout-btn a.disabled {
  pointer-events: none;
  opacity: 0.5;
  user-select: none;
  background-color: var(--red);
}

.shopping-cart {
width: 100%;
  height: auto;
  position: absolute;
  margin: 3%;
  left: 15%;
  background: rgba(0, 0, 0, 0.3);
  padding: 10px;
  overflow: hidden;
  display: none;
}

.shopping-cart table th,
.shopping-cart table td {
  padding: 10px;
  font-size: 16px;
  text-align: center;
  border-bottom: 1px solid #ccc;
}

.shopping-cart table th {
  background-color: #333;
  color: #fff;
}

.shopping-cart table td input[type="number"] {
  width: 60px;
  padding: 5px;
  font-size: 14px;
}

.shopping-cart table .remove-btn {
  padding: 5px 10px;
  font-size: 14px;
  color: #fff;
  background-color: #ff0000;
  border: none;
  cursor: pointer;
}

.shopping-cart table .remove-btn:hover {
  background-color: #cc0000;
}

.shopping-cart .total-price {
  font-size: 18px;
  color: #fff;
  margin-bottom: 10px;
}

.shopping-cart button {
  margin-right: 10px;
  padding: 10px 20px;
  font-size: 16px;
  color: #fff;
  background-color: #ff8800;
  border: none;
  cursor: pointer;
}

.shopping-cart button:hover {
  background-color: #e67700;
}

.shopping-cart .clean-btn {
  background-color: #ff0000;
}

.shopping-cart .pay-btn {
  background-color: #4caf50;
}

.shopping-cart .cancel-btn {
  background-color: #333;
}



/* Styles for the buttons */
.shopping-cart button {
  margin-top: 1rem;
  padding: 1rem 2rem;
  font-size: 1.8rem;
  color: var(--white);
  background-color: var(--orange);
  border: none;
  cursor: pointer;
}

.shopping-cart button:hover {
  background-color: var(--black);
}

.shopping-cart button.cancel-btn {
  background-color: var(--red);
}

.shopping-cart button.cancel-btn:hover {
  background-color: var(--dark-red);
}



 
 
 /* media queries  */
 
 @media (max-width:1500px){
   .shopping-cart{
      width: 80%;
      height: auto;
      position: absolute;
      margin: 3%;
      left: 15rem;
      background: rgba(0, 0, 0, 0.3);
      padding: 10px;
      overflow: hidden;
      display: none;
       overflow-x: scroll;
    }
 
    .shopping-cart table{
       width: 120rem;
    }
 
    .shopping-cart .heading{
       text-align: left;
    }
 
    .shopping-cart .checkout-btn{
       text-align: left;
    }
    
    .shopping-cart{
       overflow-x: scroll;
    }
 
 }
 
 @media (max-width:991px){
   .shopping-cart{
      width: 100%;
      height: auto;
      position: absolute;
      margin: 3%;
      left: 0;
      background: rgba(0, 0, 0, 0.3);
      padding: 10px;
      overflow: hidden;
      display: none;
       overflow-x: scroll;
    }
 
    .shopping-cart table{
       width: 120rem;
    }
 
    .shopping-cart .heading{
       text-align: left;
    }
 
    .shopping-cart .checkout-btn{
       text-align: left;
    }
    
    .shopping-cart{
       overflow-x: scroll;
    }
 
 }
 


 
 @media (max-width:768px){
   .shopping-cart{
      width: 100%;
      height: auto;
      position: absolute;
      margin: 3%;
      left: 0;
      background: rgba(0, 0, 0, 0.3);
      padding: 10px;
      overflow: hidden;
      display: none;
       overflow-x: scroll;
    }
 
    .shopping-cart table{
       width: 120rem;
    }
 
    .shopping-cart .heading{
       text-align: left;
    }
 
    .shopping-cart .checkout-btn{
       text-align: left;
    }
    
    .shopping-cart{
       overflow-x: scroll;
    }
 
 }
 
 @media (max-width:450px){
   .shopping-cart{
      width: 100%;
      height: auto;
      position: absolute;
      margin: 3%;
      left: 0;
      background: rgba(0, 0, 0, 0.3);
      padding: 10px;
      overflow: hidden;
      display: none;
       overflow-x: scroll;
    }
 
    .shopping-cart table{
       width: 120rem;
    }
 
    .shopping-cart .heading{
       text-align: left;
    }
 
    .shopping-cart .checkout-btn{
       text-align: left;
    }
    
    .shopping-cart{
       overflow-x: scroll;
    }
 
 }


</style>