
<?php 
@include 'config.php';
include 'forms\view.php'; 
?>

<?php
// Database connection parameters

// SQL query to retrieve data from the 'products' table
$sql = "SELECT * FROM products";

// Execute the query and store the results in a variable
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
  // Display the results in an HTML table
  echo "<div id='hidendiv' style='display: none;'>";
  echo "<table>";
  echo "<tr><th>id</th><th>Name</th><th>Code</th><th>Type</th><th>Barcode</th><th>at_shop</th><th>Quantity</th><th>Cost</th><th>Tax</th><th>Price</th><th>Include_Tax</th><th>Price_Change</th><th>More_Info</th><th>Images</th><th>Description</th><th>Service</th><th>Default_Quantity</th><th>Active</th></tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["code"] . "</td><td>" . $row["type"] . "</td><td>" . $row["barcode"] . "</td><td>" . $row["at_shop"] . "</td><td>" . $row["quantity"] . "</td><td>" . $row["cost"] . "</td><td>" . $row["tax"] . "</td><td>" . $row["price"] . "</td><td>" . $row["include_tax"] . "</td><td>" . $row["price_change"] . "</td><td>" . $row["more_info"] . "</td><td>" . $row["images"] . "</td><td>" . $row["Description"] . "</td><td>" . $row["Service"] . "</td><td>" . $row["Default_Quantity"] . "</td><td>" . $row["Active"] . "</td></tr>";
  }
  echo "</table>";
  echo "</div>";
} else {
  echo "No results found.";
}
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
const table = document.querySelector('#product-table');
var a = document.querySelector('body .Main');

	/*
function readhtmtable(){
	// Get a reference to the HTML table
	const table = document.querySelector('table');
	// Create an array to store the table data

	// Loop through each row in the table
	for (let i = 1; i < table.rows.length; i++) {
		// Get a reference to the current row
		const row = table.rows[i];
		
		// Create an object to store the data for this row
		const obj = {};
		
		// Loop through each cell in the row
		for (let j = 0; j < row.cells.length; j++) {
			// Get a reference to the current cell
			const cell = row.cells[j];
			
			// Add the cell data to the object
			obj[table.rows[0].cells[j].textContent] = cell.textContent;
		}
		
		// Add the object to the data array
		
		data.push(obj);
		console.log(row.cells[j]);
	}
	// Print the resulting data array to the console
	console.log(data);
}*/
const data = [];

// Variables to keep track of the current offset and limit
var offset = 0;
var limit = 10;

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
	var datasent = 'offset=' + offset + '&limit=' + limit;

	// Store the current scroll position
	previousScrollTop = window.pageYOffset || document.documentElement.scrollTop;

	// Make an AJAX request to your PHP API
	sendAjaxRequest(url, 'POST', datasent, function(responseText) {
		var response = JSON.parse(responseText);
		var items = response.items;

		// Process the response and add the items to the itemContainer
		for (var i = 0; i < items.length; i++) {
	  		data.push(items[i]);
		}

		// Restore the previous scroll position
		//window.scrollTo(0, previousScrollTop);
		
		// Print the resulting data array to the console
		console.log(data);
		createitems();

	}, function(errorStatus) {
		// Handle error
		console.log('Error: ' + errorStatus);
	});
}
//*/


readhtmtable();
var createing = 0;

function disply_item(vs_id, vs_n, vs_At_Shop, vs_type, vs_code, vs_price, vs_img, vs_path, vs_dic, vs_info) {
	var sy = scrollY;
	var y = sy;
   
	const view_Box = document.createElement('div');
    view_Box.classList.add('view');
	view_Box.id = 'view-form';
	view_Box.style.display='none'; 
	a.appendChild(view_Box);
	const view_Boxclose_btn = document.createElement('input');
	view_Box.appendChild(view_Boxclose_btn);
	view_Boxclose_btn.value = "x";
	view_Boxclose_btn.style.width ="10px";
	view_Boxclose_btn.style.background ="border-box";
	view_Boxclose_btn.style.color ="red";
	view_Boxclose_btn.style.position ="absolute";
	view_Boxclose_btn.style.right ="5%";
	view_Boxclose_btn.addEventListener('click', ()=>{
		document.querySelector('#view-form').style.display = 'none';
	});
	
	var shop_name = (vs_At_Shop + " ").split(' ');
	var na = vs_n.replaceAll(' ', '_');
	
	var path = ("img\\" + shop_name[0] + "\\products\\" + (vs_type).replaceAll(' ', '\\') + "\\"+ na + "\\"+ vs_code).replaceAll('\\\\', '\\');
	var images = (vs_img + "~").split('~');
	console.log(images[0]);
	
	const viewbox_title = document.createElement('h1');
    viewbox_title.classList.add('heading');
	viewbox_title.value = "View";
	view_Box.appendChild(viewbox_title);
	
	const view_form = document.createElement('form');
	// Add the product item element to the product grid container
	view_Box.appendChild(view_form);
        
	const hidden_info_name = document.createElement('input');
	view_form.appendChild(hidden_info_name);
    hidden_info_name.classList.add('p_name');
	hidden_info_name.name="product_name";
	//<input type="hidden" name="product_name" class="p_name" value="">
	hidden_info_name.value = vs_n;
   hidden_info_name.innerText = vs_n;
   
   hidden_info_name.hidden = true;
   const hidden_info_code = document.createElement('input');
   view_form.appendChild(hidden_info_code);
   hidden_info_code.classList.add('p_code');
   hidden_info_code.name="product_code";
	hidden_info_code.value = vs_price;
	hidden_info_code.hidden = true;
    const hidden_info_type = document.createElement('input');
	view_form.appendChild(hidden_info_type);
	hidden_info_type.classList.add('p_type');
	hidden_info_type.name="product_type";
	hidden_info_type.value = vs_price;
	hidden_info_type.hidden = true;
    const hidden_info_imge = document.createElement('input');
	view_form.appendChild(hidden_info_imge);
	hidden_info_imge.classList.add('p_img');
	hidden_info_imge.name="product_image";
	hidden_info_imge.value= "";
	
   hidden_info_imge.hidden = true;
   const hidden_info_price = document.createElement('input');
   view_form.appendChild(hidden_info_price);
   hidden_info_price.classList.add('p_price');
   hidden_info_price.name="product_price";
   hidden_info_price.value = vs_price;
   hidden_info_price.innerText = vs_price;
	hidden_info_price.hidden = true;
    const hidden_info_disc = document.createElement('input');
	view_form.appendChild(hidden_info_disc);
	hidden_info_disc.classList.add('p_disc');
	hidden_info_disc.name="product_disc";
	hidden_info_disc.innerText = vs_dic;
	hidden_info_disc.value = vs_dic;
	hidden_info_disc.hidden = true;
    const hidden_info_info = document.createElement('input');
	view_form.appendChild(hidden_info_info);
	hidden_info_info.classList.add('p_info');
	hidden_info_info.name="product_info";
   
	hidden_info_info.value = vs_info;
	hidden_info_info.hidden = true;
    const hidden_info_size = document.createElement('input');
	view_form.appendChild(hidden_info_size);
	hidden_info_size.classList.add('p_size');
	hidden_info_size.name="product_size";
	hidden_info_size.value= "";
	hidden_info_size.hidden = true;
    const hidden_info_color = document.createElement('input');
	view_form.appendChild(hidden_info_color);
	hidden_info_color.classList.add('p_color');
	hidden_info_color.name="product_color";
	hidden_info_color.value= "";
	hidden_info_color.hidden = true;
    const hidden_info_path = document.createElement('input');
	view_form.appendChild(hidden_info_path);
	hidden_info_path.classList.add('p_path');
	hidden_info_path.name="product_path";
	hidden_info_path.value= path;
	hidden_info_path.hidden = true;

	const do_btn = document.createElement('div');
	view_form.appendChild(do_btn);
    do_btn.classList.add('do_btns');

	const do_like_btn = document.createElement('input');
	do_btn.appendChild(do_like_btn);
	do_like_btn.classList.add('btns');
	do_like_btn.name="add_to_cart";
	do_like_btn.value= "like";
	
	const do_buy_btn = document.createElement('input');
	do_btn.appendChild(do_buy_btn);
	do_buy_btn.classList.add('btns');
	do_buy_btn.name="add_to_cart";
	do_buy_btn.value= "Buy";
	
	const do_cart_btn = document.createElement('input');
	do_btn.appendChild(do_cart_btn);
	do_cart_btn.classList.add('btns');
	do_cart_btn.name="add_to_cart";
	do_cart_btn.value= "Add to cart";
	
	
	const info_Box = document.createElement('div');
	view_Box.appendChild(info_Box);
    info_Box.classList.add('box');
	
	
	const Images_Box = document.createElement('div');
	info_Box.appendChild(Images_Box);
    Images_Box.classList.add('img_box');
	
	
	const otherinfo_Box = document.createElement('div');
	info_Box.appendChild(otherinfo_Box);
    otherinfo_Box.classList.add('sub_box');
	
	const p_name_title = document.createElement('h1');
    p_name_title.classList.add('p_name');
	p_name_title.value = vs_n;
	p_name_title.innerText = vs_n;
	otherinfo_Box.appendChild(p_name_title);
	
	const size_info = document.createElement('div');
	otherinfo_Box.appendChild(size_info);
    size_info.classList.add('size_box');

	const size_info_id = document.createElement('div');
	otherinfo_Box.appendChild(size_info_id);
	size_info_id.id = "size_box_id";
	size_info_id.value = "View";
    size_info_id.classList.add('color_box');

	const p_disc_info = document.createElement('h1');
    p_disc_info.classList.add('p_disc');
	p_disc_info.value = "color_box_id";
	p_disc_info.innerText = vs_dic;
	otherinfo_Box.appendChild(p_disc_info);
   	
	const p_price_info = document.createElement('h1');
    p_price_info.classList.add('p_price');
	p_price_info.value = "R" + vs_price;
	p_price_info.innerText = "R" + vs_price;
	otherinfo_Box.appendChild(p_price_info);

   for(var z = 0; z <= Images_Box.children.length-1; z++){
      Images_Box.children[z].remove();
   }

   for(var m = 0; images[m]; m++){
      var img = document.createElement('img');
      alert("image "+  path + "/" + images[m]);
      img.src =  path + "/" + images[m];
      Images_Box.appendChild(img);
      
      Images_Box.value = "0";
      for(var z = 0; z <= Images_Box.children.length-1; z++){
         var n = 100/Images_Box.children.length;
         if(100/3 >= n) n=n;
         else n = 100/3;
         if(z == 0){
            Images_Box.children[z].style.width =String(100)+"%";
            Images_Box.children[z].style.height =String(100-100/4)+"%";
         }
         else {
            Images_Box.children[z].style.width =String(n)+"%";
            Images_Box.children[z].style.height =String(100/4)+"%";
         }
         img.setAttribute('onclick', 'set_img_pos("'+ z + '")');
      }
   }

   //{l,[|black,2|,|green,3|,|white,5|,]},{xl,[|white,5|,|black,2|,|green,6|,]},
   var main_info = (vs_info + "}").split("},");
   for(var m = 0; main_info[m]; m++){
       var main_value = main_info[m].split(",[");
       var size = main_value[0].replace("{", "");
       var item = document.createElement('button');
       item.setAttribute('onclick', 'View_color("' + main_value[1] + '","' + size + '")');
       item.innerHTML = '<i class="fa fa-trash-o"></i>';
       item.class="itemBttnclass";
       item.style.width = '50px';
       item.style.height = '20px';
       item.style.color = 'black';
       item.innerText = "" + size;
       size_info_id.appendChild(item);
   }
	var ya  = y+ a.scrollTop
	view_Box.style.top = ya + 'px';
}

disply_item("", "", "", "", "", "", "", "", "", "");
function View_Selected(vs_id, vs_n, vs_at_shop, vs_type, vs_code, vs_price, vs_img, vs_path, vs_dic, vs_info) {
  return function() {
    document.getElementById('view-form').style.display = 'block';

    var sy = scrollY;
    var y = sy;
    var ya = y + a.scrollTop;
    document.getElementById('view-form').style.top = ya + 'px';
    var images = vs_img.split('~');

    document.querySelector('#view-form .p_name').value = vs_n;
    document.querySelector('#view-form .p_name').innerText = vs_n;
    document.querySelector('#view-form .box .sub_box .p_name').innerText = vs_n;

    document.querySelector('#view-form .p_code').value = vs_price;

    document.querySelector('#view-form .p_type').value = vs_price;

    var list = document.querySelector('#view-form .box .img_box');
    list.innerHTML = '';

    for (var m = 0; m < images.length; m++) {
      var img = document.createElement('img');
	  img.onerror = function() {

			this.style.width = '100%'; // Set width to match original image
			this.style.height = '100%'; // Set height to match original image
			this.src = 'img/error1.jpg'; // Set the error image path
		};
      img.src = `${vs_path}/${images[m]}`;
      list.appendChild(img);

      list.value = "0";
      for (var z = 0; z < list.children.length; z++) {
        var n = 100 / list.children.length;
        if (100 / 3 >= n) n = n;
        else n = 100 / 3;
        if (z == 0) {
          list.children[z].style.width = '100%';
          list.children[z].style.height = `${100 - 100 / 4}%`;
        } else {
          list.children[z].style.width = `${n}%`;
          list.children[z].style.height = `${100 / 4}%`;
        }
        img.setAttribute('onclick', `set_img_pos("${z}")`);
      }
    }

    document.querySelector('#view-form .p_price').value = vs_price;
    document.querySelector('#view-form .p_price').innerText = vs_price;
    document.querySelector('#view-form .box .sub_box .p_price').innerText = `R${vs_price}`;

    document.querySelector('#view-form .p_path').value = vs_price;

    document.querySelector('#view-form .p_info').value = vs_info;

    document.querySelector('#view-form .p_disc').innerText = vs_dic;
    document.querySelector('#view-form .box .sub_box .p_disc').innerText = vs_dic;

    var main_info = vs_info.split('},');
    for (var m = 0; m < main_info.length; m++) {
      var main_value = main_info[m].split(',[');
      var size = main_value[0].replace('{', '');
      var item = document.createElement('button');
      item.setAttribute('onclick', `View_color("${main_value[1]}","${size}")`);
      item.innerHTML = '<i class="fa fa-trash-o"></i>';
      item.class = 'itemBttnclass';
      item.style.width = '50px';
      item.style.height = '20px';
      item.style.color = 'black';
      item.innerText = size;
      document.getElementById('size_box_id').appendChild(item);
    }

    document.getElementById('view-form').style.top = ya + 'px';
  }
}

/*function View_Selected(vs_id, vs_n, vs_at_shop, vs_type, vs_code, vs_price, vs_img, vs_path, vs_dic, vs_info) {
	return function() {
		document.getElementById('view-form').style.display='block';

		var sy = scrollY;
		var y = sy;
		var ya  = y+ a.scrollTop
		document.getElementById('view-form').style.top = ya + 'px';
		var images = (vs_img + "~").split('~');
		//<input type="hidden" name="product_name" class="p_name" value="">
		document.querySelector('#view-form .p_name').value = vs_n;
		document.querySelector('#view-form .p_name').innerText = vs_n;
		document.querySelector('#view-form .box .sub_box .p_name').innerText = vs_n;
		//<input type="hidden" name="product_code" class="p_code" value="">
		document.querySelector('#view-form .p_code').value = vs_price;
		//<input type="hidden" name="product_type" class="p_type" value="">
		document.querySelector('#view-form .p_type').value = vs_price;
		//<input type="hidden" name="product_image" class="p_img" value="">
		var list = document.querySelector('#view-form .box .img_box');
		for(var z = 0; z <= list.children.length-1; z++){
			list.children[z].remove();
		}

		for(var m = 0; images[m]; m++){
			var img = document.createElement('img');
			img.src =  vs_path + '\\' + images[m];
			list.appendChild(img);
			
			list.value = "0";
			for(var z = 0; z <= list.children.length-1; z++){
				var n = 100/list.children.length;
				if(100/3 >= n) n=n;
				else n = 100/3;
				if(z == 0){
					list.children[z].style.width =String(100)+"%";
					list.children[z].style.height =String(100-100/4)+"%";
				}
				else {
					list.children[z].style.width =String(n)+"%";
					list.children[z].style.height =String(100/4)+"%";
				}
				img.setAttribute('onclick', 'set_img_pos("'+ z + '")');
			}
		}
		//<input type="hidden" name="product_price" class="p_price" value="">
		document.querySelector('#view-form .p_price').value = vs_price;
		document.querySelector('#view-form .p_price').innerText = vs_price;
		document.querySelector('#view-form .box .sub_box .p_price').innerText = "R" + vs_price;
		//<input type="hidden" name="product_path" class="p_path" value="">
		document.querySelector('#view-form .p_path').value = vs_price;
		//<input type="hidden" name="product_info" class="p_info" value="">
		document.querySelector('#view-form .p_info').value = vs_info;

		document.querySelector('#view-form .p_disc').innerText = vs_dic;
		document.querySelector('#view-form .box .sub_box .p_disc').innerText = vs_dic;

		//{l,[|black,2|,|green,3|,|white,5|,]},{xl,[|white,5|,|black,2|,|green,6|,]},
		var main_info = (vs_info + "}").split("},");
		for(var m = 0; main_info[m]; m++){
			var main_value = main_info[m].split(",[");
			var size = main_value[0].replace("{", "");
			var item = document.createElement('button');
			item.setAttribute('onclick', 'View_color("' + main_value[1] + '","' + size + '")');
			item.innerHTML = '<i class="fa fa-trash-o"></i>';
			item.class="itemBttnclass";
			item.style.width = '50px';
			item.style.height = '20px';
			item.style.color = 'black';
			item.innerText = "" + size;
			document.getElementById("size_box_id").appendChild(item);
		}

		document.getElementById('view-form').style.top = ya + 'px';
		//document.getElementById('shopping-cart-form').style.display='none'; 
		//document.getElementById('login-form').style.display='none';
	}
}*/

function createitems() {
  const productGrid = document.querySelector('.list_containers .box-container');

  for (let i = 0; i < data.length; i++) {
    const productItem_Box = document.createElement('div');
    productItem_Box.classList.add('box');
    productGrid.appendChild(productItem_Box);

    const productImage_Box = document.createElement('div');
    productItem_Box.appendChild(productImage_Box);
    productImage_Box.classList.add('img_box');

    const shop_name = data[i].at_shop.split(' ')[0];
    const na = data[i].name.replaceAll(' ', '_');
    const path = `img/${shop_name}/products/${data[i].type}/${na}/${data[i].code}`;

    const hidden_info_name = document.createElement('input');
    productImage_Box.appendChild(hidden_info_name);
    hidden_info_name.classList.add('p_name');
    hidden_info_name.name = 'product_name';
    hidden_info_name.value = data[i].name;
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

    const Image_Box_likeBtn = document.createElement('input');
    Image_Box_Btn.appendChild(Image_Box_likeBtn);
    Image_Box_likeBtn.classList.add('lcb_1btns');
    Image_Box_likeBtn.name = 'add_to_cart';
    Image_Box_likeBtn.value = 'Like';

    const Image_Box_addBtn = document.createElement('input');
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

    productImage_Btn.addEventListener('click', function() {
      View_Selected(
        data[i].id,
        data[i].name,
        data[i].at_shop,
        data[i].type,
        data[i].code,
        data[i].price,
        data[i].images,
        path,
        data[i].Description,
        data[i].More_info
      );
    });
  }
}

// Function to handle scroll event
function handleScroll() {
  const containerElement = document.querySelector('body .Main');
  const targetElement = document.querySelector('.list_containers .box-container');

  const containerScrollTop = containerElement.scrollTop;
  const targetElementTop = targetElement.offsetTop;

  if (containerScrollTop <= targetElementTop) {
    console.log('Scroll reaching top of target element');
  }

  const containerHeight = containerElement.offsetHeight;
  const targetElementHeight = targetElement.offsetHeight;

  const containerBottomScrollPosition = containerScrollTop + containerHeight;
  const targetElementBottomPosition = targetElementTop + targetElementHeight;

  if (containerBottomScrollPosition >= targetElementBottomPosition) {
    console.log('Scroll reaching bottom of target element');
	//var offset += limit;
	//readhtmtable();
  }
}

// Attach scroll event listener to the container element
var a = document.querySelector('body .Main');
a.addEventListener('scroll', handleScroll);

</script>

<style>
#view-form {
   width: 100%;
   height: auto;
   position: absolute;
   background: rgba(0,0,0,.3);
   padding: 18px;
   overflow: hidden;
   display: none;
}

#view-form .do_btns {
    display: line;
}

#view-form .do_btns .btns {
    width: 33%;
    text-align: center;
    background-color: var(--blue);
    color: var(--white);
    padding: 1.2rem 3rem;
    border-radius: 0.5rem;
    margin-top: 1rem;
}

#view-form .box {
    width: 100%;
    height: auto;
    background: rgba(0,0,0,.3);
    padding: 3px;
    display: inline-flex;
    position: relative;
    color: aliceblue;
}

#view-form .box .img_box {
    width: 50%;
    height: 330px;
    background: rgba(0,0,0,.3);
    padding: 6px;
    display: list-item;
}

#view-form .sub_box {

}

#view-form .sub_box .size_box {
    width: 100%;
    padding: 6px;
}

#view-form .sub_box .color_box {
    width: 100%;
    padding: 6px;
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
 
@media (max-width:1200px){
	
}
 
@media (max-width:991px){
 

}

@media (max-width:768px){

}

@media (max-width:450px){
	
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