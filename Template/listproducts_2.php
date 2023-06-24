<?php 
include 'config.php';
#include 'view.php';
?>
<!-- HTML markup for the product grid -->

<div class="list_containers">
	<h1 class="heading">latest products</h1>
	<div class="box-container">
  		<!-- The product items will be added dynamically using JavaScript -->
	</div>
</div>

<script>
// Select the table element
var a = document.querySelector('body .Main');

const data = [];
var data_leght = 0

// Variables to keep track of the current offset and limit
var offset = 0;
var limit = 10;
var itemlimit = 50;
var firstset = 0;
var lastset = 0;

// Function to remove items from the productGrid and data array
function removeitem(howmany, a) {
  const productGrid = document.querySelector('.list_containers .box-container');
  const itemCount = productGrid.childElementCount;
	console.log("going to remove items in container" + a);
	for (let i = 0; i <= howmany; i++) {
		if(data.length >= itemlimit){
			if (data.length >= itemlimit) howmany+=1;
			if (a == 0 && firstset <= data.length-1) data.pop(); // Remove the last item from the data array
			else if (a == 1 && lastset >= 1) data.shift(); // Remove the first item from the data array
		}
		if(itemCount >= itemlimit){
			if (itemCount >= itemlimit) howmany+=1;
			if (a == 0 && firstset <= data.length-1) {
				console.log("from bottom " + i);
				productGrid.removeChild(productGrid.lastChild);
				console.log("from bottom 1 " + i);
				const itemCount = productGrid.childElementCount;
				console.log("temCount> " +itemlimit);
				console.log("from bottom 2 " + i);
				console.log(data.length + " <data.length")
			}
			else if (a == 1 && lastset >= 1) {
				console.log("from top");
				productGrid.removeChild(productGrid.firstChild);
				console.log("from bottom 2 " + i);
				console.log(data.length + " <data.length")
			}
		}
	}
  console.log(data); // Verify that the data array is updated correctly
}

function sendAjaxRequest(url, method, itemsData, successCallback, errorCallback) {
	var xhr = new XMLHttpRequest();
	xhr.open(method, url, true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function() {
		if (xhr.readyState === XMLHttpRequest.DONE) {
		if (xhr.status === 200) {
			successCallback(xhr.responseText);
		} else {
			errorCallback(xhr.status);
		}
		}
	};
	xhr.send(itemsData);
}

function readhtmtable() {
	var url = 'get_items.php'; // The PHP script that fetches items from the database

	console.log('offset=' + offset + '  &limit=' + limit + '  &firstset=' + firstset + '  &lastset=' + lastset);
	var datasent = 'offset=' + offset + '&limit=' + limit + '&firstset=' + firstset + '&lastset=' + lastset;

	// Store the current scroll position
	previousScrollTop = window.pageYOffset || document.documentElement.scrollTop;

	// Make an AJAX request to your PHP API
	sendAjaxRequest(url, 'POST', datasent, function(responseText) {
		console.log(responseText + '<< responseText');
		var response = JSON.parse(responseText);
		items = response.items;
		console.log(items);
		
		firstset = response.firstset;
		lastset = response.lastset;
		a = response.a;
		
		console.log(a);
		console.log(a + '<< a');
		
		console.log(items.length + '<< items.length');
		data.splice(0, data.length);
		// Process the response and add the items to the itemContainer
		for (var i = 0; i < items.length; i++) {
			data.push({
				id: items[i].id,
				at_shop: items[i].at_shop,
				name: items[i].name,
				type: items[i].type,
				active: items[i].active,
				code: items[i].code,
				barcode: items[i].barcode,
				price: items[i].price,
				tax: items[i].tax,
				cost: items[i].cost,
				service: items[i].service,
				price_change: items[i].price_change,
				quantity: items[i].quantity,
				images: items[i].images,
				description: items[i].description,
				include_tax: items[i].include_tax,
				default_quantity: items[i].default_quantity,
				more_info: items[i].more_info
			}); 
		}
		console.log(data[0].more_info);
		console.log(data_leght + '<< value : ' + data.length + ">=" + itemlimit+ '-' + limit);
		createItems();
		removeitem(data.length-itemlimit/2,offset);	

	}, function(errorStatus) {
		// Handle error
		console.log('Error: ' + errorStatus);
	});
}
//*/

readhtmtable();
var createing = 0;

function createItems() {
  const productGrid = document.querySelector('.list_containers .box-container');
  let itemCount = productGrid.childElementCount;

  for (var i = 0; i < data.length; i++) {
	console.log(itemCount+"<<itemCount<data.length>>"+data.length);
	  console.log(i+"<<i");
	  console.log("id>>"+data[i].id);
	  console.log(data);
	  
    const shop_name = data[i].at_shop.split(' ')[0];
    const na = data[i].name.replaceAll(' ', '_');
    const path = `img/${shop_name}/products/${data[i].type}/${na}/${data[i].code}`;

    // Check if the item already exists by searching for a specific attribute/value combination
    const existingItem = productGrid.querySelector(`[data-item="${data[i].id}"]`);
    if (existingItem) {
      // If the item exists, skip creating a new one and update the counter variables
      if (offset === 0) {
        if (i === 0) break;
        else i--;
      } else {
        i++;
      }
      continue;
    }

    // Create the new item element
    const productItem_Box = document.createElement('div');
    productItem_Box.classList.add('box');
    productItem_Box.setAttribute('data-item', data[i].id); // Set a data attribute to identify the item

    const productImage_Box = document.createElement('div');
    productItem_Box.appendChild(productImage_Box);
    productImage_Box.classList.add('img_box');

    const hidden_info_name = document.createElement('input');
    productImage_Box.appendChild(hidden_info_name);
    hidden_info_name.classList.add('p_name');
    hidden_info_name.name = 'product_name';
    hidden_info_name.value = i+": "+data[i].name;
    hidden_info_name.hidden = true;

    // Add other hidden input elements here

    const productImage_Btn = document.createElement('button');
    productImage_Box.appendChild(productImage_Btn);
    productImage_Btn.classList.add('product-image');

    const productImage = document.createElement('img');
    productImage_Btn.appendChild(productImage);
    productImage.style.height = '50px';
	productImage.onerror = function() {
		this.src = 'img/error1.jpg'; // Set the error image path
		this.style.width = '100%'; // Set width to match original image
		this.style.height = '100%'; // Set height to match original image
	};
    productImage.src = `${path}/${data[i].images[0]}`;

    const Image_Box_Btn = document.createElement('div');
    productImage_Box.appendChild(Image_Box_Btn);
    Image_Box_Btn.classList.add('box_btns');

    const Image_Box_likeBtn = document.createElement('button');
    Image_Box_Btn.appendChild(Image_Box_likeBtn);
    Image_Box_likeBtn.classList.add('lcb_1btns');
    Image_Box_likeBtn.name = 'add_to_cart';
    Image_Box_likeBtn.value = 'Like';

    const Image_Box_addBtn = document.createElement('button');
    Image_Box_Btn.appendChild(Image_Box_addBtn);
    Image_Box_addBtn.classList.add('lcb_1btns');
    Image_Box_addBtn.name = 'add_to_cart';
    Image_Box_addBtn.value = 'Add To Cart';

    const productName = document.createElement('h3');
    productItem_Box.appendChild(productName);
    productName.classList.add('product_name');
    productName.name = 'product_name';
    productName.textContent = data[i].name;

    const productPrice = document.createElement('div');
    productItem_Box.appendChild(productPrice);
    productPrice.name = 'product_price';
    productPrice.classList.add('price');
    productPrice.textContent = `R${data[i].price}`;

    const productCode = document.createElement('div');
    productItem_Box.appendChild(productCode);
    productCode.classList.add('product_image');
    productCode.name = 'product_image';
    productCode.textContent = data[i].Image;
    productCode.hidden = true;
	console.log("selected item info >>" + data[i].more_info);
	let b0 = data[i].id;
	let b1 = data[i].name;
	let b2 = data[i].at_shop;
	let b3 = data[i].type;
	let b4 = data[i].code;
	let b5 = data[i].price;
	let b6 = data[i].images;
	let b7 = data[i].description;
	let b8 = data[i].more_info;
	let b9 = data[i].more_info;
	productImage_Btn.addEventListener('click', function() {
		// Check if the required values are set before passing them
		// Create a closure to capture the current state of the data
		(function(a0, a1, a2, a3, a4, a5, a6, a7, a8, a9, a10) {
			// Pass the captured values to the View_Selected function
			console.log("selected item info >>" + [a1, a2, a3, a4, a5, a6, a7, a8, a9, a0]);
			View_Selected(a0, a1, a2, a3, a4, a5, a6, a7, a8, a9, a10);
		})(b9, b0, b1, b2, b3, b4, b5, b6, path, b7, b8);
	});


	if(offset === 0){
		// Get the first child of the parent element
		var firstChild = productGrid.firstChild;
		console.log(">> addin on top");
		// Insert the new child element before the first child
		productGrid.insertBefore(productItem_Box, firstChild);
	}
	else if(offset === 1) 
	{
		console.log(">> adding on last");
		productGrid.appendChild(productItem_Box);
	} 
	
	itemCount = productGrid.childElementCount;
  }
}

// Function to handle scroll event
function handleScroll() {
	const containerElement = document.querySelector('body .Main');
  const targetElement = document.querySelector('.list_containers .box-container');

  const containerScrollTop = containerElement.scrollTop;
  const targetElementTop = targetElement.offsetTop;
  
  
  // Set the threshold distance from the top and bottom positions
  const threshold = 190;
  
  // Check if the scroll position is within the threshold distance from the top
  if (containerScrollTop <= targetElementTop + threshold) {
		offset = 0;
		readhtmtable();
  }

  const containerHeight = containerElement.offsetHeight;
  const targetElementHeight = targetElement.offsetHeight;

  const containerBottomScrollPosition = containerScrollTop + containerHeight;
  const targetElementBottomPosition = targetElementTop + targetElementHeight;

  // Check if the scroll position is within the threshold distance from the bottom
  if (containerBottomScrollPosition >= targetElementBottomPosition - threshold) {
		//console. log(">>", targetElementBottomPosition);
			//console.log('Scroll about to reach bottom of target element');
		offset = 1;
		readhtmtable();
  }
}

// Attach scroll event listener to the container element
var a = document.querySelector('body .Main');
a.addEventListener('scroll', handleScroll);

</script>

<style>
/*  end of view-form */


.list_containers .box-container{
	display: grid;
	grid-template-columns: repeat(auto-fit, 35rem);
	gap: 1.5rem;
	justify-content: center;
	overflow: hidden;
	/* line-height: 100%; */
	margin-right: auto;
	text-align: center;
	padding: 2rem;
	box-shadow: var(--box-shadow);
	border: var(--border);
	border-radius: 1.5rem;
	align-items: center;
	align-content: space-between;
	flex-wrap: wrap;	
 }

 .list_containers .box-container .box{
    text-align: center;
    padding: 2rem;
    box-shadow: var(--box-shadow);
    border:var(--border);
    border-radius: .5rem;
 }

 @media (max-width:600px){
 
	.list_containers .box-container .box{
		width: 90%;
		border-radius: .5rem;
	}
	
	.list_containers .box-container{
		display: grid;
		grid-template-columns: repeat(auto-fit, 35rem);
		gap: 1.5rem;
		justify-content: center;
		overflow: hidden;
		/* line-height: 100%; */
		margin-right: auto;
		text-align: center;
		padding: 2rem;
		box-shadow: var(--box-shadow);
		border: var(--border);
		border-radius: 1.5rem;
		align-items: center;
		align-content: space-between;
		flex-wrap: wrap;	
 	}
}

.list_containers .box-container .box:hover {
	transform: scale(1.5);
}
 

.list_containers .box-container .box .img_box{
    position: relative;
 }

.list_containers .box-container .box .img_box .box_btns{
	width: 100%;
	display: -webkit-inline-box;
	position: absolute;
	padding: 16px;
	bottom: -13px;
	left: 5%;
 }

.list_containers .box-container .box .box_btns .lcb_1btns {
	display: block;
	color: black;
	WidTH: 30%;
	background-color: var(--with);
	font-size: 1rem;
	padding: 6%;
	border-radius: 0.2rem;
	cursor: pointer;
	margin-top: 1rem;
 }
 
 .list_containers .box-container .box .box_btns .lcb_1btns:hover {
  background-color: black;
	color: white;
 }
 
 .list_containers .box-container .box img{
    height: 25rem;
 }
 
 .list_containers .box-container .box h3{
    margin:1rem 0;
    font-size: 2.5rem;
    color:var(--black);
 }
 
 .list_containers .box-container .box .price{
    font-size: 2.5rem;
    color:var(--black);
 }
 

</style>	