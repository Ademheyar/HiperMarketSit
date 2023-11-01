// this item listing will list only ones all in a product table with out repting
// if shop_is give only it will display give shop product items
// dont forget to sand list_containers and list_box in which you what to create the items js

//const productGrid = document.querySelector('#product_items_list_containers3 .product_items_list_box3');
//const body_main_container = document.querySelector('body .Main');

// Select the table element
//var a = document.querySelector('body .Main');


// Function to remove items from the productGrid and data array
function removeitem(parent_, howmany, dl, data, data_leght, offset, limit, itemlimit, firstset, lastset) {
  const itemCount = parent_.childElementCount;
	console.log("going to remove items in container" + dl);
	for (let i = 0; i <= howmany; i++) {
		if(data.length >= itemlimit){
			if (data.length >= itemlimit) howmany+=1;
			if (dl == 0 && firstset <= data.length-1) data.pop(); // Remove the last item from the data array
			else if (dl == 1 && lastset >= 1) data.shift(); // Remove the first item from the data array
		}
		if(itemCount >= itemlimit){
			if (itemCount >= itemlimit) howmany+=1;
			if (dl == 0 && firstset <= data.length-1) {
				console.log("from bottom " + i);
				parent_.removeChild(parent_.lastChild);
				console.log("from bottom 1 " + i);
				const itemCount = parent_.childElementCount;
				console.log("temCount> " +itemlimit);
				console.log("from bottom 2 " + i);
				console.log(data.length + " <data.length")
			}
			else if (dl == 1 && lastset >= 1) {
				console.log("from top");
				parent_.removeChild(parent_.firstChild);
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

function readhtmtable(parent_, data, data_leght, offset, limit, itemlimit, firstset, lastset) {
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
		ra = response.a;
		
		console.log(ra);
		console.log(ra + '<< ra');
		
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
		createItems(parent_, data, data_leght, offset, limit, itemlimit, firstset, lastset);
		removeitem(parent_, data.length-itemlimit/2,offset);	

	}, function(errorStatus) {
		// Handle error
		console.log('Error: ' + errorStatus);
	});
}

function createItems(parent_, data, data_leght, offset, limit, itemlimit, firstset, lastset) {
  let itemCount = parent_.childElementCount;

  for (var i = 0; i < data.length; i++) {
	console.log(itemCount+"<<itemCount<data.length>>"+data.length);
	  console.log(i+"<<i");
	  console.log("id>>"+data[i].id);
	  console.log(data);
	  
    const shop_name = data[i].at_shop.split(' ')[0];
    const na = data[i].name.replaceAll(' ', '_');
    const path = `img/${shop_name}/products/${data[i].type}/${na}/${data[i].code}`;

    // Check if the item already exists by searching for a specific attribute/value combination
    const existingItem = parent_.querySelector(`[data-item="${data[i].id}"]`);
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
    productItem_Box.setAttribute('data-item', data[i].id); 
    
    // Set a data attribute to identify the item
    
  //styleing
  productItem_Box.style.textAlign = 'center';
  productItem_Box.style.width = 'auto-fit'; 
  productItem_Box.style.padding ='5rem';
	productItem_Box.style.boxShadow = 'var(--box-shadow)';
	productItem_Box.style.border = 'var(--border)';
	productItem_Box.style.borderRadius = '0.5rem';
	
  const productImage_Box = document.createElement('div');
  productItem_Box.appendChild(productImage_Box);
  productImage_Box.classList.add('img_box');
  //productImage_Box.style.position = 'relative';
  productImage_Box.style.width = '100%'; 
  
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
	console.log("selected item info >>" + data[i].price);
	var b0 = data[i].id;
	var b1 = data[i].name;
	var b2 = data[i].price;
	var b3 = data[i].images;
	var b4 = data[i].description;
	var b5 = data[i].at_shop;
	var b6 = data[i].type;
	var b7 = data[i].code;
	var b8 = data[i].more_info;
	var b9 = data[i].more_info;
	productImage_Btn.addEventListener('click', function() {
		// Check if the required values are set before passing them
		// Create a closure to capture the current state of the data
		(function(a0, a1, a2, a3, a4, a5, a6, a7, a8, a9, a10) {
			// Pass the captured values to the View_Selected function
			// vs_info, vs_id, vs_n, vs_price, vs_img, vs_path, vs_dic, vs_info1
			console.log("selected item info >>" + [a1, a2, a3, a4, a5, a6, a7, a8, a9, a0]);
			View_Selected(a0, a1, a2, a3, a4, a5, a6, a7, a8, a9, a10);
		})(b9, b0, b1, b2, b3, path, b4, b5, b6, b7, b8);
	});


	if(offset === 0){
		// Get the first child of the parent element
		var firstChild = parent_.firstChild;
		console.log(">> addin on top");
		// Insert the new child element before the first child
		parent_.insertBefore(productItem_Box, firstChild);
	}
	else if(offset === 1) 
	{
		console.log(">> adding on last");
		parent_.appendChild(productItem_Box);
	} 
	
	itemCount = parent_.childElementCount;
  }
}

// Function to handle scroll event
function handleScroll(items_container, Items_Box, data, data_leght, offset, limit, itemlimit, firstset, lastset) {
  const containerScrollTop = Items_Box.scrollTop;
  const targetElementTop = items_container.offsetTop;
  
			console.log('Scrolling......');
  
  // Set the threshold distance from the top and bottom positions
  const threshold = 190;
  
  // Check if the scroll position is within the threshold distance from the top
  if (containerScrollTop <= targetElementTop + threshold) {
		offset = 0;
		console. log(">>", targetElementTop);
			console.log('Scroll about to reach top of target element');
		readhtmtable(Items_Box, data, data_leght, offset, limit, itemlimit, firstset, lastset);
  }

  const containerHeight = Items_Box.offsetHeight;
  const targetElementHeight = items_container.offsetHeight;

  const containerBottomScrollPosition = containerScrollTop + containerHeight;
  const targetElementBottomPosition = targetElementTop + targetElementHeight;

  // Check if the scroll position is within the threshold distance from the bottom
  if (containerBottomScrollPosition >= targetElementBottomPosition - threshold) {
		console. log(">>", targetElementBottomPosition);
			console.log('Scroll about to reach bottom of target element');
		offset = 1;
		readhtmtable(Items_Box, data, data_leght, offset, limit, itemlimit, firstset, lastset);
  }
}

function create_list(parent_b, contenur_n, box_n, title, display_t_on, display_style) {
  const data = [];
  var data_leght = 0;

  // Variables to keep track of the current offset and limit
  var offset = 0;
  var limit = 10;
  var itemlimit = 50;
  var firstset = 0;
  var lastset = 0;

  const items_list_container = document.createElement('div');
  items_list_container.id = contenur_n;
  parent_b.appendChild(items_list_container);
  items_list_container.classList.add(contenur_n);
  items_list_container.style.gap = '1.5rem';
	items_list_container.style.justifyContent = 'left';
	
	items_list_container.style.height = 'auto'; 
	items_list_container.style.overflowX = 'hidden';
  items_list_container.style.overflowY = 'hidden';
	items_list_container.style.marginRight = 'auto';
	items_list_container.style.textAlign = 'center';
	items_list_container.style.padding ='0.5rem';
	items_list_container.style.boxShadow = 'var(--box-shadow)';
	items_list_container.style.border = 'var(--border)';
	items_list_container.style.borderRadius = '1.5rem';
	items_list_container.style.alignItems = 'center';
	items_list_container.style.alignContent = 'space-between';
  items_list_container.style.position ='relative';
  
  if(display_t_on >= 0){
    const title_t = document.createElement('h1');
    title_t.classList.add('heading');
    title_t.textContent = title;
    items_list_container.appendChild(title_t);
  }
  
  const Items_Box = document.createElement('div');
  Items_Box.classList.add(box_n);
  // styling
  Items_Box.style.textAlign = 'center';
  
	Items_Box.style.boxShadow = 'var(--box-shadow)';
	Items_Box.style.border = 'var(--border)';
	Items_Box.style.borderRadius = '1.5rem';
  Items_Box.style.justifyContent = 'left';
  Items_Box.style.lineHeight = '100%'; 
	Items_Box.style.marginRight = 'auto';
	Items_Box.style.padding = '2rem';
	
	Items_Box.style.alignItems = 'center';
	Items_Box.style.alignContent = 'space-between';
  Items_Box.style.position ='relative';
  
	/*grid-template-columns: repeat(auto-fit, 35rem);
		margin-right: auto;
		flex-wrap: wrap;	*/
	/*
	Items_Box.style.gap = '1.5rem';
	*/
  if (display_style == 0){
    items_list_container.style.height = 'auto'; 
  
    Items_Box.style.height = '25%'; 
    Items_Box.style.display = 'flex';
    Items_Box.style.gap = '1.5rem';
    Items_Box.style.overflowX = 'auto';
  }
  else if (display_style == 1){
    Items_Box.style.display = 'grid';
    Items_Box.style.gap = '1.5rem';
    //Items_Box.style.height = '75%'; 
    Items_Box.style.overflowY = 'scroll';
  }
  items_list_container.appendChild(Items_Box);
  
  const productGrid = document.querySelector('#' + contenur_n + ' .' + box_n);
  items_list_container.addEventListener('scroll', handleScroll(items_list_container, Items_Box, data, data_leght, offset, limit, itemlimit, firstset, lastset));
  readhtmtable(Items_Box, data, data_leght, offset, limit, itemlimit, firstset, lastset);
}

//productGrid_container.addEventListener('scroll', handleScroll);
