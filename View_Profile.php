<?php 
   if(session_id() == "") session_start();
   if ($_SESSION['on'] != 1){
      $_SESSION['on'] = 1;
      header("Location: Home.php");
      exit; // Make sure to include exit after the header redirect
   }
?>
<div class="view_profile">
   
<main>
    <div class="tab">
      <button class="tablinks" onclick="openTab(event, 'shopStockTab')">Shop Stock</button>
      <button class="tablinks" onclick="openTab(event, 'customerInfoTab')">Customer Information</button>
      <button class="tablinks" onclick="openTab(event, 'productInfoTab')">Product Information</button>
    </div>

    <div id="shopStockTab" class="tabcontent">
      <h2>Shop Stock</h2>
      <table id="shopStockTable">
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Availability</th>
          </tr>
        </thead>
        <tbody>
          <!-- Populate table rows dynamically using JavaScript -->
        </tbody>
      </table>
    </div>

    <div id="customerInfoTab" class="tabcontent">
      <h2>Customer Information</h2>
      <table id="customerInfoTable">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
          </tr>
        </thead>
        <tbody>
          <!-- Populate table rows dynamically using JavaScript -->
        </tbody>
      </table>
    </div>

    <div id="productInfoTab" class="tabcontent">
      <h2>Product Information</h2>
      <div id="productDetails">
        <!-- Populate product details dynamically using JavaScript -->
      </div>
    </div>
  </main>
</div>
<?php include 'login.php'; ?>
<?php include 'cart.php'; ?>

<script>
    // Sample data for demonstration
   const shopStock = [
   { name: "Product 1", price: "$10", availability: "In Stock" },
   { name: "Product 2", price: "$20", availability: "Out of Stock" },
   { name: "Product 3", price: "$15", availability: "In Stock" },
   ];

   const customerInfo = [
   { name: "John Doe", email: "john@example.com", phone: "123-456-7890" },
   { name: "Jane Smith", email: "jane@example.com", phone: "987-654-3210" },
   ];

   const productInfo = [
   { name: "Product 1", description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.", image: "product1.jpg" },
   { name: "Product 2", description: "Nulla eget quam nec mi imperdiet cursus.", image: "product2.jpg" },
   { name: "Product 3", description: "Sed ullamcorper mi et nunc pulvinar iaculis.", image: "product3.jpg" },
   ];

   // Open the default tab
   document.getElementById("shopStockTab").style.display = "block";

   // Handle tab switching
   function openTab(evt, tabName) {
   // Get all tab content elements and hide them
   const tabContent = document.getElementsByClassName("tabcontent");
   for (let i = 0; i < tabContent.length; i++) {
      tabContent[i].style.display = "none";
   }

   // Remove 'active' class from all tablinks
   const tabLinks = document.getElementsByClassName("tablinks");
   for (let i = 0; i < tabLinks.length; i++) {
      tabLinks[i].classList.remove("active");
   }

   // Show the selected tab and mark the corresponding tablink as active
   document.getElementById(tabName).style.display = "block";
   evt.currentTarget.classList.add("active");
   }

   // Populate shop stock table
   const stockTable = document.getElementById("shopStockTable").getElementsByTagName("tbody")[0];
   shopStock.forEach(product => {
   const row = stockTable.insertRow();
   row.innerHTML = `<td>${product.name}</td><td>${product.price}</td><td>${product.availability}</td>`;
   });

   // Populate customer information table
   const customerTable = document.getElementById("customerInfoTable").getElementsByTagName("tbody")[0];
   customerInfo.forEach(customer => {
   const row = customerTable.insertRow();
   row.innerHTML = `<td>${customer.name}</td><td>${customer.email}</td><td>${customer.phone}</td>`;
   });

   // Populate product details
   const productDetailsContainer = document.getElementById("productDetails");
   productInfo.forEach(product => {
   const card = document.createElement("div");
   card.classList.add("productCard");
   card.innerHTML = `
      <img src="${product.image}" alt="${product.name}">
      <h3>${product.name}</h3>
      <p>${product.description}</p>
   `;
   productDetailsContainer.appendChild(card);
   });

  </script>
<style>

/* view_profile Styles */

body .view_profile{
   overflow: auto;
   position: relative;
   top: 24rem;
   left: 15%;
   align-items: flex-start;
   position: absolute;
   width: 100%;
   height: 100%;
   background: #f8f8ff;
}


h1, h2 {
  margin-top: 0;
}

.tab {
  overflow: hidden;
  margin-bottom: 20px;
}

.tab button {
  background-color: #f2f2f2;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 10px 20px;
  font-size: 16px;
  transition: background-color 0.3s;
}

.tab button:hover {
  background-color: #ddd;
}

.tab button.active {
  background-color: #ccc;
}

.tabcontent {
  display: none;
}

table {
 /* width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;*/
}

table th, table td {
  padding: 10px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

#productDetails {
  display: flex;
  flex-wrap: wrap;
}

.productCard {
  width: 200px;
  padding: 10px;
  margin-right: 20px;
  margin-bottom: 20px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.productCard img {
  width: 100%;
  height: auto;
  margin-bottom: 10px;
}

.productCard h3 {
  margin-top: 0;
}

.productCard p {
  margin: 0;
}

/* media queries  */
 
@media (max-width:1500px){
   
   /* view_profile Styles */
   body .view_profile{
      overflow: auto;
      position: relative;
      top: 24rem;
      left: 15%;
      align-items: flex-start;
      position: absolute;
      width: 85%;
      height: 100%;
      background: #f8f8ff;
   }
}
 
@media (max-width:991px){
   
   /* view_profile Styles */
   body .view_profile{
      overflow: auto;
      position: relative;
      top: 24rem;
      left: 15%;
      align-items: flex-start;
      position: absolute;
      width: 85%;
      height: 100%;
      background: #f8f8ff;
   }
}
 
@media (max-width:768px){
   
   /* view_profile Styles */
   body .view_profile{
      overflow: auto;
      position: relative;
      top: 24rem;
      left: 15%;
      align-items: flex-start;
      position: absolute;
      width: 85%;
      height: 100%;
      background: #f8f8ff;
   }
}
 
@media (max-width: 600px) {

   /* view_profile Styles */
   body .view_profile{
        overflow: auto;
        position: relative;
        top: 24rem;
        left: 0;
        align-items: flex-start;
        position: absolute;
        width: 100%;
        height: 100%;
        background: #f8f8ff;
   }
}

@media (max-width:450px){

   /* view_profile Styles */
   body .view_profile{
        overflow: auto;
        position: relative;
        top: 24rem;
        left: 0;
        align-items: flex-start;
        position: absolute;
        width: 100%;
        height: 100%;
        background: #f8f8ff;
   }
}






.logo {
  font-size: 24px;
}

.links {
  display: flex;
}

.link {
  margin-right: 20px;
  cursor: pointer;
}

/* Responsive Styles */

nav {
   flex: 1;
   text-align: right;
 }
 nav ul 
 {
   display: contents;
    list-style: none;
 }
 
 nav ul li {
    display: table-row;
    list-style: 70px;
    /* this blocks are for styling the list elements */
 }
 
 nav ul li a {
    text-decoration: none;
    list-style: 70px;
    text-decoration: none;
    color: palevioletred;
    font-size: 28px;
    text-align: center;
    padding: 2rem;
    box-shadow: var(--box-shadow);
    border: var(--border);
    border-radius: 0.5rem;
    gap: 50px;
    margin: auto;
 }
 
 nav ul li a:hover {
    color: aqua;
 }
 
 nav ul li button {
    font-size: 20px;
    color: white;
    outline: none;
    border: none;
    background: transparent;
    cursor: pointer;
    font-family: sans-serif;
 }
 
 nav ul li button:hover {
    color: aqua;
 }
 
 .navbar {
    align-items: center;
    padding: 0px;
    padding-left: 50px;
    padding-right: 30px;
    /* this is for setting the dimensions of navigation bar */
 }

/* 
   this will make loging nice
*/
.loginbtn {
  font-size: 16px;
  color: #fff;
  background-color: transparent;
  border: none;
  cursor: pointer;
  transition: color 0.3s ease;
}

.loginbtn:hover {
  color: aqua;
}


 body .flex .navbar a{
    margin-left: 2rem;
    font-size: 2rem;
    color:var(--white);
 }
 
 body .flex .navbar a:hover{
    color:yellow;
 }
 
 body .flex .cart{
    margin-left: 2rem;
    font-size: 2rem;
    color:var(--white);
 }
 
 body .flex .cart:hover{
    color:yellow;
 }
 
 body .flex .cart span{
    padding:.1rem .5rem;
    border-radius: .5rem;
    background-color: var(--white);
    color:var(--blue);
    font-size: 2rem;
 }
 
 #menu-btn{
    margin-left: 2rem;
    font-size: 3rem;
    cursor: pointer;
    display: inline-block;
   color:var(--white);
   display: none;
 }
 
 
 .header .navbar a{
   margin: 0 1rem;
   font-size: 1.6rem;
   color: #fff;
 }
 
 .header .navbar a:hover{
   color: var(--main-color);
   border-bottom: .1rem solid var(--main-color);
   padding-bottom: .5rem;
 }
 
 .header .icons div{
   color: #fff;
   cursor: pointer;
   font-size: 2.5rem;
   margin-left: 2rem;
 }
 
 .header .icons div:hover{
   color: var(--main-color);
 }
 


.logo {
  font-size: 24px;
}


.links {
  display: flex;
}

.link {
  margin-right: 20px;
  cursor: pointer;
}

@media (max-width: 600px) {

  .links {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .link {
    margin-bottom: 20px;
    margin-right: 0;
  }
}


</style>