// this item listing will list only ones all in a product table with out repting
// if shop_is give only it will display give shop product items
// dont forget to sand list_containers and list_box in which you what to create the items js
// create_list(Contaner, 'hf', 'ldn', 'ti8899e', 1,1);

//const productGrid = document.querySelector('#product_items_list_containers3 .product_items_list_box3');
//const body_main_container = document.querySelector('body .Main');

// Select the table element
//var a = document.querySelector('body .Main');


// Function to remove items from the productGrid and data array
function removeitem(parent_, id) {
	const dl = window.globallist[id].offset;
	var howmany = window.globallist[id].limit;
	console.log("going to remove items in container" + dl);
	console.log("data.length " + window.globallist[id].data.length);
	console.log("itemlimit " + window.globallist[id].itemlimit);
	
	if(window.globallist[id].data.length >= window.globallist[id].itemlimit){
		console.log("items in data" + howmany);
		for (let i = 0; i <= howmany; i++) {
			if (window.globallist[id].data.length >= window.globallist[id].itemlimit) howmany+=1;
			if (dl == 0 && window.globallist[id].firstset <= window.globallist[id].data.length-1) window.globallist[id].data.pop(); // Remove the last item from the data array
			else if (dl == 1 && lastset >= 1) window.globallist[id].data.shift(); // Remove the first item from the data array			
		}
	}

	if(parent_.childElementCount >= window.globallist[id].itemlimit){
		var itemCount = parent_.childElementCount;
		console.log("items in container" + howmany);
		console.log("window.globallist[id].firstset " + window.globallist[id].firstset);
		console.log("window.globallist[id].lastset " + window.globallist[id].lastset);
		console.log(" window.globallist[id].data.length-1 " +  window.globallist[id].data.length);
		for (let i = 0; i <= howmany; i++) {
				console.log("itemCount B " + itemCount);
			if (dl == 0 && window.globallist[id].firstset <= itemCount-1) {
				console.log("from bottom " + i);
				parent_.removeChild(parent_.lastChild);
			}
			else if (dl == 1 && window.globallist[id].lastset >= 1) {
				console.log("from top " + i);
				parent_.removeChild(parent_.firstChild);
			}
			itemCount = parent_.childElementCount;
			if (itemCount >= window.globallist[id].itemlimit) howmany+=1;
			console.log("itemCount A " + itemCount);
		}
	}
  //console.log(data); // Verify that the data array is updated correctly
}

function readhtmtable(parent_, id) {
	var url = 'Get/get_items.php'; // The PHP script that fetches items from the database
	// TODO CHACK THIS AGEN
	var withtype = window.globallist[id].def_search_info !== '' ? (window.globallist[id].def_search_info+";") : "";
	console.log('withtype ' + withtype);	
	var datasent = 'Company_Id='+ window.globallist[id].Company_Id +'&withtype=' + withtype + '&list_what=' + window.globallist[id].list_what + '&offset=' + window.globallist[id].offset + '&limit=' + window.globallist[id].limit + '&firstset=' + window.globallist[id].firstset + '&lastset=' + window.globallist[id].lastset;
	console.log('Hbefore ' + datasent);
	// Store the current scroll position
	previousScrollTop = window.pageYOffset || document.documentElement.scrollTop;

	// Make an AJAX request to your PHP API
	sendAjaxRequest(url, 'POST', datasent, function(responseText) {
	  console.log(responseText + '<< responseText');
	  //var replacedData = responseText.replace(/\|/g, '"'); 
	  //console.log(replacedData + '<< replacedData');
		var response = JSON.parse(responseText);
		items = response.items;
		//console.log(items);
		
		window.globallist[id].firstset = response.firstset;
		window.globallist[id].lastset = response.lastset;
		ra = response.a;
		window.globallist[id].list_clumens = response.list_clumens;

		//console.log(ra);
		//console.log(ra + '<< ra');
		
		//console.log(items.length + '<< items.length');
		window.globallist[id].data.splice(0, window.globallist[id].data.length);
		// Process the response and add the items to the itemContainer
		for (var i = 0; i < items.length; i++) {
			let keylist = {};
			window.globallist[id].list_clumens.forEach(headerText => {
				keylist[headerText] = items[i][headerText];
			});

			window.globallist[id].data.push(keylist); 
		}
		//console.log(window.globallist[id].data[0].more_info);
		//console.log(data_leght + '<< value : ' + window.globallist[id].data.length + ">=" + window.globallist[id].itemlimit+ '-' + limit);
		//console.log('Hbefore offset=' + offset + '  &limit=' + limit + '  &firstset=' + firstset + '  &lastset=' + lastset);
		console.log(responseText + '<< responseText');
		createLists(parent_, id);
		removeitem(parent_, id);	
		//console.log('Hbefore offset=' + offset + '  &limit=' + limit + '  &firstset=' + firstset + '  &lastset=' + lastset);

	}, function(errorStatus) {
		// Handle error
		//console.log('Error: ' + errorStatus);
	});
}

function createLists(parent_, id) {
  let itemCount = parent_.childElementCount;
  let slide_Box = NaN;
  let nav_m = NaN;
  let table = NaN;
  let def_banner_count = 0;
  if(window.globallist[id].list_what == "BANNERS") {
    // Create the new item element
    slide_Box = document.createElement('div');
	parent_.appendChild(slide_Box);

	nav_m = document.createElement('div');
	parent_.appendChild(nav_m);
	//nav_m.style.position = 'absolute'; // = 'auto-fit'; 
	nav_m.style.width = '100%'; // = 'auto-fit'; 
	nav_m.style.display = 'flex'; // = 'auto-fit'; 
	nav_m.style.marginTop = '-40px'; // = 'auto-fit'; 
	nav_m.style.justifyContent = 'center'; // = 'auto-fit'; 
  }
  if(window.globallist[id].display_style.split("-")[1] == "TABLE"){
	while (parent_.firstChild) {
		parent_.removeChild(parent_.firstChild);
	}
	
	table = document.createElement('table');
	parent_.appendChild(table);
	
	table.setAttribute('border', '1');
	parent_.style.display = "block";
	//table.style.position = 'absolute'; // = 'auto-fit';
	//table.style.zIndex = "2"; // = 'auto-fit';
	//table.style.left = '50%'; // = 'auto-fit';
	//table.style.top = '50%'; // = 'auto-fit';
	//table.style.transform = "translate(-50%, -50%)"; // = 'auto-fit';
	//table.style.width = '60%'; // = 'auto-fit';
	table.style.borderCollapse = 'collapse'; // = 'auto-fit';
	table.style.borderSpacing = '0'; // = 'auto-fit';
	table.style.borderRadius = '12px 12px 0 0'; // = 'auto-fit';
	//table.style.overflow = 'hidden'; // = 'auto-fit';
	table.style.boxShadow = '0 12px 12px rgba(32, 32, 32, .3)'; // = 'auto-fit';
	table.style.background = '#fafafa'; // = 'auto-fit';
	table.style.textAlign = 'center'; // = 'auto-fit';

	// Create table header
	const header = table.createTHead();
	const headerRow = header.insertRow();
	window.globallist[id].list_clumens.forEach(headerText => {
		const th = document.createElement('th');
		th.style.padding = '12px 15px'; // = 'auto-fit';
		th.style.backgroundColor = '#333'; // = 'auto-fit';
		th.style.color = '#fff'; // = 'auto-fit';
		th.style.textAlign = 'center'; // = 'auto-fit';
		const text = document.createTextNode(headerText);
		th.appendChild(text);
		headerRow.appendChild(th);
	});



  }

	for (var i = 0; i < window.globallist[id].data.length; i++) {
		//console.log(itemCount+"<<itemCount<window.globallist[id].data.length>>"+window.globallist[id].data.length);
		//console.log(i+"<<i");
		//console.log("id>>"+window.globallist[id].data[i].id);
		

		// Create the new item element
		let Item_Box = NaN;
		//Item_Box.classList.add('box');
		if(window.globallist[id].list_what == "DOCUMENTS") {
			if(window.globallist[id].display_style.split("-")[1] == "BOX"){
				const shop_name = window.globallist[id].data[i].at_shop;
				console.log("window.globallist[id].data[i].at_shop doc = ", window.globallist[id].data[i].at_shop);
				
				const na = window.globallist[id].data[i].name.replaceAll(' ', '_');
				const path = `Img/${shop_name}/products/${window.globallist[id].data[i].type}/${na}/${window.globallist[id].data[i].code}`;
			
				// Check if the item already exists by searching for a specific attribute/value combination
				const existingItem = parent_.querySelector(`[data-item="${window.globallist[id].data[i].id}"]`);
					
				if (existingItem) {
				// If the item exists, skip creating a new one and update the counter variables
				if (window.globallist[id].offset === 0) {
					if (i === 0) break;
					else i--;
				} else {
					i++;
				}
				continue;
				}
				
				Item_Box = document.createElement('div');
				Item_Box.setAttribute('data-item', window.globallist[id].data[i].id);
				//Item_Box.style.position = 'fixed';
				//Item_Box.style.textAlign = 'center';
				//Item_Box.style.padding = '50px';
				Item_Box.style.borderRadius = '5rem';
				//Item_Box.style.display = 'flex';
				
				// Set a data attribute to identify the item
				
			//styleing
			Item_Box.style.textAlign = 'center';
			Item_Box.style.width = '250px'; // = 'auto-fit'; 
			Item_Box.style.height = '250px'; 
			//Item_Box.style.height = '90%'; 
			Item_Box.style.padding ='0.5rem';
				Item_Box.style.boxShadow = 'var(--box-shadow)';
				Item_Box.style.border = 'var(--border)';
				Item_Box.style.borderRadius = '0.5rem';
				
			const productImage_Box = document.createElement('div');
			Item_Box.appendChild(productImage_Box);
			//productImage_Box.classList.add('img_box');
			productImage_Box.style.position = 'relative';
			//productImage_Box.style.width = '100%'; 
			//productImage_Box.style.height = '80%';
			productImage_Box.style.background = '#ddd';
			productImage_Box.style.overflow = 'hidden';
				
				const hidden_info_name = document.createElement('input');
				productImage_Box.appendChild(hidden_info_name);
				//hidden_info_name.classList.add('p_name');
				hidden_info_name.name = 'product_name';
				hidden_info_name.value = i+": "+window.globallist[id].data[i].name;
				hidden_info_name.hidden = true;

				// Add other hidden input elements here
				const product_profile_Btn = document.createElement('a');
				var cil3s_id = window.globallist[id].data[i].at_shop;
				product_profile_Btn.href = 'Template/shop/Shop_page.php?shop_pag_name='+cil3s_id;

				
				productImage_Box.appendChild(product_profile_Btn);
				product_profile_Btn.style.width = '100%';
				//product_profile_Btn.style.display = 'flex';
				//product_profile_Btn.style.position = 'absolute';
				product_profile_Btn.style.textAlign = 'center';
				product_profile_Btn.style.fontSize = '8px';
				//product_profile_Btn.style.padding = '16px';
				//product_profile_Btn.style.bottom ='-13px';
				
				product_profile_Btn.innerText = window.globallist[id].data[i].id+": Document Shop Mame "+window.globallist[id].data[i].at_shop;

				const product_profile_Img = document.createElement('img');
				product_profile_Btn.appendChild(product_profile_Img);
				product_profile_Img.style.height = '12%';
				product_profile_Img.style.textAlign = 'center';
				//product_profile_Img.style.width = '12%';
				//product_profile_Img.classList.add('profile-image');
				//product_profile_Img.style.padding = '2rem';
				product_profile_Img.style.boxShadow = 'var(--box-shadow)';
				product_profile_Img.style.border = 'var(--border)';
				//product_profile_Img.style.borderRadius = '.5rem';
				//product_profile_Img.style.display = 'contents';
				product_profile_Img.style.display = "flow-root";
				product_profile_Img.style.position = 'absolute';
				
				product_profile_Img.onerror = function() {
					this.src = 'Img/error1.jpg'; //Set the error image path
				};
				//product_profile_Img.src = `${path}/${window.globallist[id].data[i].images[0]}`;
				
				const productImage_Btn = document.createElement('div');
				//.appendChild(productImage_Btn);
				//productImage_Btn.classList.add('product-image');;
				productImage_Btn.style.width = '100%';
				productImage_Btn.style.height = '80%';
				productImage_Btn.style.background = '#ddd';
				productImage_Btn.style.overflow = 'hidden';

				
				const Image_Box_Btn = document.createElement('div');
				productImage_Box.appendChild(Image_Box_Btn);
				//Image_Box_Btn.classList.add('box_btns'); 
				//Image_Box_Btn.style.top = "0";
				  Image_Box_Btn.style.bottom = "0";
				Image_Box_Btn.style.width = "100%";
				Image_Box_Btn.style.height = "21%";
				Image_Box_Btn.style.zIndex = "1";
				Image_Box_Btn.style.position = 'absolute';
				  Image_Box_Btn.style.background = 'aliceblue';

				const Image_Box_likeBtn = document.createElement('button');
				Image_Box_Btn.appendChild(Image_Box_likeBtn);
				//Image_Box_likeBtn.style.width = '30%';
				//Image_Box_likeBtn.classList.add('lcb_1btns');
				//Image_Box_likeBtn.name = 'add_to_cart';
				///Image_Box_addBtn.style.display= "block";
				//Image_Box_addBtn.style.color = "black";
				Image_Box_likeBtn.style.backgroundColor = 'var(--with)';
				//Image_Box_likeBtn.style.top = "9rem";
				//Image_Box_likeBtn.style.display = "flow-root";
				//Image_Box_likeBtn.style.position = 'absolute';
				Image_Box_likeBtn.style.color = "black";
				Image_Box_likeBtn.style.fontSize = '1rem';
				Image_Box_likeBtn.style.padding = '6%';
				Image_Box_likeBtn.style.borderRadius = '0.2rem';
				Image_Box_likeBtn.style.cursor = 'pointer';
				Image_Box_likeBtn.style.marginTop = '1rem';
				Image_Box_likeBtn.innerText = 'Like';

				const Image_Box_addBtn = document.createElement('button');
				Image_Box_Btn.appendChild(Image_Box_addBtn);
				//Image_Box_addBtn.classList.add('lcb_1btns');
				//Image_Box_addBtn.name = 'add_to_cart';
				Image_Box_addBtn.innerText = 'Add To Cart';
				//Image_Box_addBtn.style.width = '30%';
				//Image_Box_addBtn.style.display= "block";
				//Image_Box_addBtn.style.color = "black";
				Image_Box_addBtn.style.backgroundColor = 'var(--with)';
				
				Image_Box_addBtn.style.color = "black";
				Image_Box_addBtn.style.fontSize = '1rem';
				Image_Box_addBtn.style.padding = '6%';
				Image_Box_addBtn.style.borderRadius = '0.2rem';
				Image_Box_addBtn.style.cursor = 'pointer';
				Image_Box_addBtn.style.marginTop = '1rem';

				const productImage = document.createElement('img');
				productImage_Box.appendChild(productImage);
				productImage.style.width = '100%';
				productImage.style.height = '100%';
				//productImage.style.objectFit = 'cover'; // This ensures the image covers the entire box without stretching
				productImage.onerror = function() {
					this.src = 'Img/error1.jpg'; // Set the error image path
					//this.style.width = '100%'; // Set width to match original image
					//this.style.height = '100%'; // Set height to match original image
				};
				//productImage.src = `${path}/${window.globallist[id].data[i].images[0]}`;


				const productName = document.createElement('h3');
				Image_Box_Btn.appendChild(productName);
				//productName.classList.add('product_name');
				//productName.name = 'product_name';
				productName.textContent = window.globallist[id].data[i].name;

				const productPrice = document.createElement('div');
				Image_Box_Btn.appendChild(productPrice);
			// productPrice.name = 'product_price';
				//productPrice.classList.add('price');
				productPrice.textContent = `R${window.globallist[id].data[i].price}`;

				const productCode = document.createElement('div');
				Image_Box_Btn.appendChild(productCode);
				//productCode.classList.add('product_image');
				//productCode.name = 'product_image';
				productCode.textContent = window.globallist[id].data[i].Image;
				productCode.hidden = true;
				//console.log("selected item info0 >>" + window.globallist[id].data[i].price);
				var b0 = window.globallist[id].data[i].id;
				var b1 = window.globallist[id].data[i].name;
				var b2 = window.globallist[id].data[i].price;
				var b3 = window.globallist[id].data[i].images;
				var b4 = window.globallist[id].data[i].description;
				var b5 = window.globallist[id].data[i].at_shop;
				var b6 = window.globallist[id].data[i].type;
				var b7 = window.globallist[id].data[i].code;
				var b8 = window.globallist[id].data[i].more_info;
				var b9 = window.globallist[id].data[i].more_info;
				productImage.addEventListener('click', function() {
					// Check if the required values are set before passing them
					// Create a closure to capture the current state of the data
					(function(a0, a1, a2, a3, a4, a5, a6, a7, a8, a9, a10) {
						// Pass the captured values to the View_Selected function
						// vs_info, vs_id, vs_n, vs_price, vs_img, vs_path, vs_dic, vs_info1
						//vs_info, vs_id, vs_n, vs_price, vs_img, vs_dicvs_At_Shop, vs_type, vs_code, vs_path, vs_info1
						//console.log("selected item info1 a0 >>" + a0);
						//console.log("selected item info1 a1 >>" + a1);
						//console.log("selected item info1 a2 >>" + a2);
						//console.log("selected item info1 a3 >>" + a3);
						//console.log("selected item info1 a4 >>" + a4);
						//console.log("selected item info1 a5 >>" + a5);
						//console.log("selected item info1 a6 >>" + a6);
						//console.log("selected item info1 a7 >>" + a7);
						//console.log("selected item info1 a8 >>" + a8);
						//console.log("selected item info1 a9 >>" + a9);
						//console.log("selected item info1 a10 >>" + a10);
						
						//console.log("in");
						View_Selected(a0, a1, a2, a3, a4, a5, a6, a7, a8, a9, a10);
						//console.log("out");
						//console.log("out selected item info1 >>" + [a1, a2, a3, a4, a5, a6, a7, a8, a9, a0]);
					})(b9, b0, b1, b2, b3, b4, b5, b6, b7, path, b8);
				});
			}
			if(window.globallist[id].display_style.split("-")[1] == "TABLE"){
				
				const path = `Img/Items`;
				// Create table body
				const tbody = table.createTBody();
				//tbody.style.display = 'inline-flex';
				const btn_divs = document.createElement('div');
				tbody.appendChild(btn_divs);
				btn_divs.className = 'item_editer_btns';
				btn_divs.style.width = '100%'
				btn_divs.style.height = '100%'
				btn_divs.style.display = 'none';

				const UpdateItem_btn = document.createElement('button');
				btn_divs.appendChild(UpdateItem_btn);
				//UpdateItem_btn.classList.add('lcb_1btns');
				//UpdateItem_btn.name = 'add_to_cart';
				UpdateItem_btn.innerText = 'Update';
				UpdateItem_btn.style.backgroundColor = 'var(--with)';
				UpdateItem_btn.style.width = '100%'
				UpdateItem_btn.style.height = '100%'
				UpdateItem_btn.style.marginTop = '1rem';
				UpdateItem_btn.style.position = 'inherit';
				//DeleteItem_btn.style.display = 'none';
				const item_data =window.globallist[id].data[i];
				/*UpdateItem_btn.addEventListener('click', function() { 
					(function (data){
						console.log("UpdateItem_btn");
						selected_Item_updater(data)
					})(item_data);
				});*/

				const ViewItem_btn = document.createElement('button');
				btn_divs.appendChild(ViewItem_btn);
				//ViewItem_btn.classList.add('lcb_1btns');
				//ViewItem_btn.name = 'add_to_cart';
				ViewItem_btn.innerText = 'View';
				ViewItem_btn.style.backgroundColor = 'var(--with)';
				ViewItem_btn.style.width = '100%'
				ViewItem_btn.style.height = '100%'
				ViewItem_btn.style.marginTop = '1rem';
				ViewItem_btn.style.position = 'inherit';
				//DeleteItem_btn.style.display = 'none';
				let image_file_name = [];
				
				/*if(window.globallist[id].data[i].more_info != ""){
					console.log("window.globallist[id].data[i].more_info ++++++", window.globallist[id].data[i].more_info);
					let item_infos = JSON.parse(window.globallist[id].data[i].more_info);
					//let item_infos = JSON.parse(JSON.stringify(['a',['b',[]]]));
					console.log("item_infos ++++++", item_infos);
					function get_images(curront) {
						if(curront){
							for (let index = 0; index < curront.length; index++) {
								if(curront[index].length > 4){
									if(curront[index][4].includes(";")){
										var values = curront[index][4].split(';');
										for(let value of values) image_file_name.push(value)
									}
									else image_file_name.push(curront[index][4]); 
								}
								else get_images(curront[index][1]);
							}
						}
					}
					get_images(item_infos);
					
				}*/
				let data = window.globallist[id].data[i];
				ViewItem_btn.addEventListener('click', function() {
					let a0 = data;
					View_Selected_Document(a0);
				});

				const DeleteItem_btn = document.createElement('button');
				btn_divs.appendChild(DeleteItem_btn);
				//DeleteItem_btn.classList.add('lcb_1btns');
				//DeleteItem_btn.name = 'add_to_cart';
				DeleteItem_btn.innerText = 'Delete';
				DeleteItem_btn.style.backgroundColor = 'red';
				DeleteItem_btn.style.width = '100%'
				DeleteItem_btn.style.height = '100%'
				DeleteItem_btn.style.marginTop = '1rem';
				DeleteItem_btn.style.position = 'inherit';
				//DeleteItem_btn.style.display = 'none';

				const tr = tbody.insertRow();
				window.globallist[id].list_clumens.forEach(headerText => {
					const td = tr.insertCell();
					td.textContent = window.globallist[id].data[i][headerText];
					td.addEventListener('click', function() {
						let parent_tbody = tbody.parentElement;
						if (tbody.style.backgroundColor != "lightblue") {
							for (let index = 0; index < parent_tbody.childNodes.length; index++) {
								const element = parent_tbody.childNodes[index];
								if(element.tagName == "TBODY") {
									element.style.backgroundColor = '';
									element.querySelector('.item_editer_btns').style.display = 'none';
								}
							}
							tbody.style.backgroundColor = 'lightblue';
						}
						else btn_divs.style.display = 'flex';
					});
				});

			}
			if(window.globallist[id].display_style.split("-")[1] == "TEXT"){
				// Create table body
				let headerText = window.globallist[id].list_clumens[i];
				if(headerText == "TOTAL_SUM")
				{
					var titleLabel = document.createElement('label');
					titleLabel.textContent = "TOTAL SUM : " + window.globallist[id].data[i][headerText];
					titleLabel.style.fontSize = 'x-large';
				}
				if(headerText == "TOTAL_COUNTED"){	
					var titleLabel = document.createElement('label');
					titleLabel.textContent = "TOTAL IN " + window.globallist[id].data[i][headerText] + " DOCUMENTS";
				}
				//titleLabel.style.fontSize = 'x-large';
				parent_.appendChild(titleLabel);
			}
			if(window.globallist[id].display_style.split("-")[1] == "CHART"){
				// Create table body
				xclumen = ""; yclumen = "";
				type = "";
				if(window.globallist[id].display_style.split("-").length >= 3) type = window.globallist[id].display_style.split("-")[2];
				if(window.globallist[id].display_style.split("-").length >= 4) xclumen = window.globallist[id].display_style.split("-")[3];
				if(window.globallist[id].display_style.split("-").length >= 5) yclumen = window.globallist[id].display_style.split("-")[4];

				drawBarChart(parent_, window.globallist[id].data, xclumen, yclumen, type);
			}	
		}
		else if(window.globallist[id].list_what == "USERS") {
			if(window.globallist[id].display_style.split("-")[1] == "BOX"){
			  console.log("window.globallist[id].data[i].at_shop user box = ", window.globallist[id].data[i].at_shop);
				const shop_name = window.globallist[id].data[i].at_shop;
				const na = window.globallist[id].data[i].name.replaceAll(' ', '_');
				const path = `Img/${shop_name}/products/${window.globallist[id].data[i].type}/${na}/${window.globallist[id].data[i].code}`;
			
				// Check if the item already exists by searching for a specific attribute/value combination
				const existingItem = parent_.querySelector(`[data-item="${window.globallist[id].data[i].id}"]`);
					
				if (existingItem) {
				// If the item exists, skip creating a new one and update the counter variables
				if (window.globallist[id].offset === 0) {
					if (i === 0) break;
					else i--;
				} else {
					i++;
				}
				continue;
				}
				
				Item_Box = document.createElement('div');
				Item_Box.setAttribute('data-item', window.globallist[id].data[i].id);
				//Item_Box.style.position = 'fixed';
				//Item_Box.style.textAlign = 'center';
				//Item_Box.style.padding = '50px';
				Item_Box.style.borderRadius = '5rem';
				//Item_Box.style.display = 'flex';
				
				// Set a data attribute to identify the item
				
			//styleing
			Item_Box.style.textAlign = 'center';
			Item_Box.style.width = '250px'; // = 'auto-fit'; 
			Item_Box.style.height = '250px'; 
			//Item_Box.style.height = '90%'; 
			Item_Box.style.padding ='0.5rem';
				Item_Box.style.boxShadow = 'var(--box-shadow)';
				Item_Box.style.border = 'var(--border)';
				Item_Box.style.borderRadius = '0.5rem';
				
			const productImage_Box = document.createElement('div');
			Item_Box.appendChild(productImage_Box);
			//productImage_Box.classList.add('img_box');
			productImage_Box.style.position = 'relative';
			//productImage_Box.style.width = '100%'; 
			//productImage_Box.style.height = '80%';
			productImage_Box.style.background = '#ddd';
			productImage_Box.style.overflow = 'hidden';
				
				const hidden_info_name = document.createElement('input');
				productImage_Box.appendChild(hidden_info_name);
				//hidden_info_name.classList.add('p_name');
				hidden_info_name.name = 'product_name';
				hidden_info_name.value = i+": "+window.globallist[id].data[i].name;
				hidden_info_name.hidden = true;

				// Add other hidden input elements here
				const product_profile_Btn = document.createElement('a');
				var cil3s_id = window.globallist[id].data[i].at_shop;
				product_profile_Btn.href = 'Template/shop/Shop_page.php?shop_pag_name='+cil3s_id;

				
				productImage_Box.appendChild(product_profile_Btn);
				product_profile_Btn.style.width = '100%';
				//product_profile_Btn.style.display = 'flex';
				//product_profile_Btn.style.position = 'absolute';
				product_profile_Btn.style.textAlign = 'center';
				product_profile_Btn.style.fontSize = '8px';
				//product_profile_Btn.style.padding = '16px';
				//product_profile_Btn.style.bottom ='-13px';
				
				product_profile_Btn.innerText = window.globallist[id].data[i].id+": User Shop id 1"+window.globallist[id].data[i].at_shop;

				const product_profile_Img = document.createElement('img');
				product_profile_Btn.appendChild(product_profile_Img);
				product_profile_Img.style.height = '12%';
				product_profile_Img.style.textAlign = 'center';
				//product_profile_Img.style.width = '12%';
				//product_profile_Img.classList.add('profile-image');
				//product_profile_Img.style.padding = '2rem';
				product_profile_Img.style.boxShadow = 'var(--box-shadow)';
				product_profile_Img.style.border = 'var(--border)';
				//product_profile_Img.style.borderRadius = '.5rem';
				//product_profile_Img.style.display = 'contents';
				product_profile_Img.style.display = "flow-root";
				product_profile_Img.style.position = 'absolute';
				
				product_profile_Img.onerror = function() {
					this.src = 'Img/error1.jpg'; //Set the error image path
				};
				//product_profile_Img.src = `${path}/${window.globallist[id].data[i].images[0]}`;
				
				const productImage_Btn = document.createElement('div');
				//.appendChild(productImage_Btn);
				//productImage_Btn.classList.add('product-image');;
				productImage_Btn.style.width = '100%';
				productImage_Btn.style.height = '80%';
				productImage_Btn.style.background = '#ddd';
				productImage_Btn.style.overflow = 'hidden';

				
				const Image_Box_Btn = document.createElement('div');
				productImage_Box.appendChild(Image_Box_Btn);
				//Image_Box_Btn.classList.add('box_btns'); 
				//Image_Box_Btn.style.top = "0";
				  Image_Box_Btn.style.bottom = "0";
				Image_Box_Btn.style.width = "100%";
				Image_Box_Btn.style.height = "21%";
				Image_Box_Btn.style.zIndex = "1";
				Image_Box_Btn.style.position = 'absolute';
				  Image_Box_Btn.style.background = 'aliceblue';

				const Image_Box_likeBtn = document.createElement('button');
				Image_Box_Btn.appendChild(Image_Box_likeBtn);
				//Image_Box_likeBtn.style.width = '30%';
				//Image_Box_likeBtn.classList.add('lcb_1btns');
				//Image_Box_likeBtn.name = 'add_to_cart';
				///Image_Box_addBtn.style.display= "block";
				//Image_Box_addBtn.style.color = "black";
				Image_Box_likeBtn.style.backgroundColor = 'var(--with)';
				//Image_Box_likeBtn.style.top = "9rem";
				//Image_Box_likeBtn.style.display = "flow-root";
				//Image_Box_likeBtn.style.position = 'absolute';
				Image_Box_likeBtn.style.color = "black";
				Image_Box_likeBtn.style.fontSize = '1rem';
				Image_Box_likeBtn.style.padding = '6%';
				Image_Box_likeBtn.style.borderRadius = '0.2rem';
				Image_Box_likeBtn.style.cursor = 'pointer';
				Image_Box_likeBtn.style.marginTop = '1rem';
				Image_Box_likeBtn.innerText = 'Like';

				const Image_Box_addBtn = document.createElement('button');
				Image_Box_Btn.appendChild(Image_Box_addBtn);
				//Image_Box_addBtn.classList.add('lcb_1btns');
				//Image_Box_addBtn.name = 'add_to_cart';
				Image_Box_addBtn.innerText = 'Add To Cart';
				//Image_Box_addBtn.style.width = '30%';
				//Image_Box_addBtn.style.display= "block";
				//Image_Box_addBtn.style.color = "black";
				Image_Box_addBtn.style.backgroundColor = 'var(--with)';
				
				Image_Box_addBtn.style.color = "black";
				Image_Box_addBtn.style.fontSize = '1rem';
				Image_Box_addBtn.style.padding = '6%';
				Image_Box_addBtn.style.borderRadius = '0.2rem';
				Image_Box_addBtn.style.cursor = 'pointer';
				Image_Box_addBtn.style.marginTop = '1rem';

				const productImage = document.createElement('img');
				productImage_Box.appendChild(productImage);
				productImage.style.width = '100%';
				productImage.style.height = '100%';
				//productImage.style.objectFit = 'cover'; // This ensures the image covers the entire box without stretching
				productImage.onerror = function() {
					this.src = 'Img/error1.jpg'; // Set the error image path
					//this.style.width = '100%'; // Set width to match original image
					//this.style.height = '100%'; // Set height to match original image
				};
				//productImage.src = `${path}/${window.globallist[id].data[i].images[0]}`;


				const productName = document.createElement('h3');
				productImage_Box.appendChild(productName);
				//productName.classList.add('product_name');
				//productName.name = 'product_name';
				productName.textContent = window.globallist[id].data[i].name;

				const productPrice = document.createElement('div');
				productImage_Box.appendChild(productPrice);
			// productPrice.name = 'product_price';
				//productPrice.classList.add('price');
				productPrice.textContent = `R${window.globallist[id].data[i].price}`;

				const productCode = document.createElement('div');
				productImage_Box.appendChild(productCode);
				//productCode.classList.add('product_image');
				//productCode.name = 'product_image';
				productCode.textContent = window.globallist[id].data[i].Image;
				productCode.hidden = true;
				//console.log("selected item info0 >>" + window.globallist[id].data[i].price);
				var b0 = window.globallist[id].data[i].id;
				var b1 = window.globallist[id].data[i].name;
				var b2 = window.globallist[id].data[i].price;
				var b3 = window.globallist[id].data[i].images;
				var b4 = window.globallist[id].data[i].description;
				var b5 = window.globallist[id].data[i].at_shop;
				var b6 = window.globallist[id].data[i].type;
				var b7 = window.globallist[id].data[i].code;
				var b8 = window.globallist[id].data[i].more_info;
				var b9 = window.globallist[id].data[i].more_info;
				productImage.addEventListener('click', function() {
					// Check if the required values are set before passing them
					// Create a closure to capture the current state of the data
					(function(a0, a1, a2, a3, a4, a5, a6, a7, a8, a9, a10) {
						View_Selected(a0, a1, a2, a3, a4, a5, a6, a7, a8, a9, a10);
					})(b9, b0, b1, b2, b3, b4, b5, b6, b7, path, b8);
				});
			}
			if(window.globallist[id].display_style.split("-")[1] == "TABLE"){
				// Create table body
				const tbody = table.createTBody();
				const tr = tbody.insertRow();
				window.globallist[id].list_clumens.forEach(headerText => {
					const td = tr.insertCell();
					td.textContent = window.globallist[id].data[i][headerText];
					td.addEventListener('click', function() {
						let parent_tbody = tbody.parentElement;
						if (tbody.style.backgroundColor != "") {
							for (let index = 0; index < parent_tbody.childNodes.length; index++) {
								const element = parent_tbody.childNodes[index];
								if(element.tagName == "TBODY") element.style.backgroundColor = 'none';
							}
							tbody.style.backgroundColor = 'lightblue';
							console.log("out");
						}
						else{

						}
					});
					tbody.style.backgroundColor = 'blue';
				});


			}
		}
		else if(window.globallist[id].list_what == "ITEMS" || window.globallist[id].list_what == "SHOP_ITEMS") {
			if(window.globallist[id].display_style.split("-")[1] == "TABLE"){
				
				const path = `Img/Items`;
				// Create table body
				const tbody = table.createTBody();
				//tbody.style.display = 'inline-flex';
				const btn_divs = document.createElement('div');
				tbody.appendChild(btn_divs);
				btn_divs.className = 'item_editer_btns';
				btn_divs.style.width = '100%'
				btn_divs.style.height = '100%'
				btn_divs.style.display = 'none';

				const UpdateItem_btn = document.createElement('button');
				btn_divs.appendChild(UpdateItem_btn);
				//UpdateItem_btn.classList.add('lcb_1btns');
				//UpdateItem_btn.name = 'add_to_cart';
				UpdateItem_btn.innerText = 'Update';
				UpdateItem_btn.style.backgroundColor = 'var(--with)';
				UpdateItem_btn.style.width = '100%'
				UpdateItem_btn.style.height = '100%'
				UpdateItem_btn.style.marginTop = '1rem';
				UpdateItem_btn.style.position = 'inherit';
				//DeleteItem_btn.style.display = 'none';
				const item_data =window.globallist[id].data[i];
				UpdateItem_btn.addEventListener('click', function() { 
					(function (data){
						console.log("UpdateItem_btn");
						selected_Item_updater(data)
					})(item_data);
				});

				const ViewItem_btn = document.createElement('button');
				btn_divs.appendChild(ViewItem_btn);
				//ViewItem_btn.classList.add('lcb_1btns');
				//ViewItem_btn.name = 'add_to_cart';
				ViewItem_btn.innerText = 'View';
				ViewItem_btn.style.backgroundColor = 'var(--with)';
				ViewItem_btn.style.width = '100%'
				ViewItem_btn.style.height = '100%'
				ViewItem_btn.style.marginTop = '1rem';
				ViewItem_btn.style.position = 'inherit';
				//DeleteItem_btn.style.display = 'none';
				let image_file_name = [];
				
				if(window.globallist[id].data[i].more_info != ""){
					console.log("window.globallist[id].data[i].more_info ++++++", window.globallist[id].data[i].more_info);
					let item_infos = JSON.parse(window.globallist[id].data[i].more_info);
					//let item_infos = JSON.parse(JSON.stringify(['a',['b',[]]]));
					
					function get_images(curront) {
						if(curront){
							for (let index = 0; index < curront.length; index++) {
								if(curront[index].length > 4){
									if(curront[index][4].includes(";")){
										var values = curront[index][4].split(';');
										for(let value of values) image_file_name.push(value)
									}
									else image_file_name.push(curront[index][4]); 
								}
								else get_images(curront[index][1]);
							}
						}
					}
					get_images(item_infos);
				}

				let b0 = window.globallist[id].data[i].id;
				let b1 = window.globallist[id].data[i].name;
				let b2 = window.globallist[id].data[i].price;
				let b3 = image_file_name;
				let b4 = window.globallist[id].data[i].description;
				let b5 = window.globallist[id].data[i].at_shop;
				let b6 = window.globallist[id].data[i].type;
				let b7 = window.globallist[id].data[i].code;
				let b8 = window.globallist[id].data[i].more_info;
				let b9 = window.globallist[id].data[i].more_info;
				ViewItem_btn.addEventListener('click', function() {
					let a0 = b9;
					let a1 = b0;
					let a2 = b1;
					let a3 = b2;
					let a4 = b3;
					let a5 = b4;
					let a6 = b5;
					let a7 = b6;
					let a8 = b7;
					let a9 = path;
					let a10 = b8;
					View_Selected(a0, a1, a2, a3, a4, a5, a6, a7, a8, a9, a10);
				});

				const DeleteItem_btn = document.createElement('button');
				btn_divs.appendChild(DeleteItem_btn);
				//DeleteItem_btn.classList.add('lcb_1btns');
				//DeleteItem_btn.name = 'add_to_cart';
				DeleteItem_btn.innerText = 'Delete';
				DeleteItem_btn.style.backgroundColor = 'red';
				DeleteItem_btn.style.width = '100%'
				DeleteItem_btn.style.height = '100%'
				DeleteItem_btn.style.marginTop = '1rem';
				DeleteItem_btn.style.position = 'inherit';
				//DeleteItem_btn.style.display = 'none';

				const tr = tbody.insertRow();
				window.globallist[id].list_clumens.forEach(headerText => {
					const td = tr.insertCell();
					td.textContent = window.globallist[id].data[i][headerText];
					td.addEventListener('click', function() {
						let parent_tbody = tbody.parentElement;
						if (tbody.style.backgroundColor != "lightblue") {
							for (let index = 0; index < parent_tbody.childNodes.length; index++) {
								const element = parent_tbody.childNodes[index];
								if(element.tagName == "TBODY") {
									element.style.backgroundColor = '';
									element.querySelector('.item_editer_btns').style.display = 'none';
								}
							}
							tbody.style.backgroundColor = 'lightblue';
						}
						else btn_divs.style.display = 'flex';
					});
				});
			}
			else {
			  if(window.globallist[id].display_style.split("-")[2] == "EDITLIST") {
			    parent_.style.width = '100%'; 
			    parent_.style.height = '90%';
			    parent_.style.display = 'flex';
			    parent_.style.flexWrap = 'wrap';
			    parent_.style.overflow = 'scroll';
			    parent_.style.gap = '5rem 0.5rem';
			  console.log("window.globallist[id].data[i].at_shop item edit box = ", window.globallist[id].data[i].at_shop);
				const shop_name = window.globallist[id].data[i].at_shop;
				
				const na = window.globallist[id].data[i].name.replaceAll(' ', '_');
				const path = `Img/Items`;
				
				Item_Box = document.createElement('div');
				Item_Box.setAttribute('data-item', window.globallist[id].data[i].id);
				//Item_Box.style.position = 'fixed';
				//Item_Box.style.textAlign = 'center';
				Item_Box.style.padding = '5px';
				Item_Box.style.borderRadius = '1rem';
				Item_Box.style.display = 'flex';
				
				// Set a data attribute to identify the item
				
				//styleing
				//Item_Box.style.textAlign = 'center';
				Item_Box.style.width = '100%'; // 'auto-fit'; 
				Item_Box.style.height = 'auto'; 
				//Item_Box.style.height = '90%'; 
				//Item_Box.style.padding ='0.5rem';
				//Item_Box.style.overflow = 'hidden';
				Item_Box.style.boxShadow = 'var(--box-shadow)';
				Item_Box.style.border = 'var(--border)';
				//Item_Box.style.borderRadius = '0.5rem';
					
				const productImage = document.createElement('img');
				Item_Box.appendChild(productImage);
				productImage.style.width = '100px';
				productImage.style.height = '90%';
				//productImage.style.objectFit = 'cover'; // This ensures the image covers the entire box without stretching
				productImage.onerror = function() {
					this.src = 'Img/error1.jpg'; // Set the error image path
					//this.style.width = '100%'; // Set width to match original image
					//this.style.height = '100%'; // Set height to match original image
				};

				let image_file_name = [];
				
				const editInfo = document.createElement("div");
				editInfo.className = "item-info";
				editInfo.style.display = "flex";

				editInfo.style.flexDirection = 'row';
				editInfo.style.flexWrap = 'wrap';
	      editInfo.style.gap = "1px";
				
				const shopSelect = document.createElement("select");
				shopSelect.value = window.globallist[id].data[i].shop;
				
				const codeSelect = document.createElement("select");
				codeSelect.value = window.globallist[id].data[i].code;
				
				const colorSelect = document.createElement("select");
				colorSelect.value = window.globallist[id].data[i].color;
				
				const sizeSelect = document.createElement("select");
				sizeSelect.value = window.globallist[id].data[i].size;
				
				const qtyInput = document.createElement("input");
				qtyInput.type = "number";
				qtyInput.value = 1;
				qtyInput.style.width = "50px";
				qtyInput.min = 1
					
			  const Save_info_btn = document.createElement('button');
         //Save_info_btn.style.display = 'None';
         Save_info_btn.value = 'Save';
         Save_info_btn.textContent = 'Add';
        Save_info_btn.style.backgroundColor = 'green';
        Save_info_btn.style.color = 'white';
        Save_info_btn.style.border = 'none';
        Save_info_btn.style.borderRadius = '4px';
        Save_info_btn.style.cursor = 'pointer';
        Save_info_btn.style.padding = '5px 10px';
          /* Save_info_btn.addEventListener('click', () => {
             var exinfofound = 0;
              tempSelectedItems.forEach((selectedItem, sindex) => {
                if(selectedItem.id == item.id){
                  exinfofound = 1;
                  let ext = selectedItem.exinfo;
                  var extfound = 0;
                  ext.forEach((extvalue, extindex) => {
                    if(extvalue[0] == shopSelect.value 
                    && extvalue[1] == codeSelect.value 
                    && extvalue[2] == colorSelect.value
                    && extvalue[3] == sizeSelect.value){
                     extvalue[4] = (parseInt(extvalue[4]) + parseInt(qtyInput.value));
                      extfound = 1;
                     // break;
                    }
                  });
                  if (!extfound){
                    if(tempSelectedItems[sindex].exinfo){
                    tempSelectedItems[sindex].exinfo.push([shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value, qtyInput.value]);
                  }
                  }
                  //break;
                }
              });
              update_total_info();
          });*/
          
       const edit_info_btn = document.createElement('button');
         //edit_info_btn.style.display = 'None';
         edit_info_btn.value = 'Full Edit';
         edit_info_btn.textContent = 'Add';
        edit_info_btn.style.backgroundColor = 'Blue';
        edit_info_btn.style.color = 'white';
        edit_info_btn.style.border = 'none';
        edit_info_btn.style.borderRadius = '4px';
        edit_info_btn.style.cursor = 'pointer';
        edit_info_btn.style.padding = '5px 10px';
          /* edit_info_btn.addEventListener('click', () => {
             var exinfofound = 0;
              tempSelectedItems.forEach((selectedItem, sindex) => {
                if(selectedItem.id == item.id){
                  exinfofound = 1;
                  let ext = selectedItem.exinfo;
                  var extfound = 0;
                  ext.forEach((extvalue, extindex) => {
                    if(extvalue[0] == shopSelect.value 
                    && extvalue[1] == codeSelect.value 
                    && extvalue[2] == colorSelect.value
                    && extvalue[3] == sizeSelect.value){
                     extvalue[4] = (parseInt(extvalue[4]) + parseInt(qtyInput.value));
                      extfound = 1;
                     // break;
                    }
                  });
                  if (!extfound){
                    if(tempSelectedItems[sindex].exinfo){
                    tempSelectedItems[sindex].exinfo.push([shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value, qtyInput.value]);
                  }
                  }
                  //break;
                }
              });
              update_total_info();
          });*/
          
			const remove_info_btn = document.createElement('button');
           //remove_info_btn.style.display = 'None';
           remove_info_btn.value = 'Remove';
           remove_info_btn.textContent = 'Remove';
    	 remove_info_btn.style.backgroundColor = 'red';
    	 remove_info_btn.style.color = 'white';
    	remove_info_btn.style.border = 'none';
    	remove_info_btn.style.borderRadius = '4px';
    	remove_info_btn.style.cursor = 'pointer';
    	remove_info_btn.style.padding = '5px 10px';
			
           /*remove_info_btn.addEventListener('click', () => {
             var exinfofound = 0;
              tempSelectedItems.forEach((selectedItem, sindex) => {
                if(selectedItem.id == item.id){
                  exinfofound = 1;
                  let ext = selectedItem.exinfo;
                  ext.forEach((extvalue, extindex) => {
                    if(extvalue[0] == shopSelect.value 
                    && extvalue[1] == codeSelect.value 
                    && extvalue[2] == colorSelect.value
                    && extvalue[3] == sizeSelect.value){
                    if((parseInt(extvalue[4]) - parseInt(qtyInput.value)) <= 0){
                      extvalue.splice(extindex, 1);
                    }
                    else {
                      extvalue[4] = (parseInt(extvalue[4]) - parseInt(qtyInput.value));
                    }
                    //break;
                    }
                  });
                  //break;
                }
              });
              update_total_info();
          });
             */
             
					editInfo.appendChild(shopSelect);
					editInfo.appendChild(codeSelect);
					editInfo.appendChild(colorSelect);
					editInfo.appendChild(sizeSelect);
					editInfo.appendChild(qtyInput);
				
					editInfo.appendChild(Save_info_btn);
					editInfo.appendChild(edit_info_btn);
					editInfo.appendChild(remove_info_btn);
					
					Item_Box.appendChild(editInfo);
				if(window.globallist[id].data[i].more_info != ""){
					//console.log("window.globallist[id].data[i].more_info ++++++", window.globallist[id].data[i].more_info);
					let item_infos = JSON.parse(window.globallist[id].data[i].more_info);

					function add_combobox_value(options, addto){
            while(addto.firstChild) selectedItemsList.removeChild(addto.firstChild);
            options.forEach(option => {
                  const opt = document.createElement("option");
                  opt.value = option;
                  opt.textContent = option;
                  addto.appendChild(opt);
           });
          }
					function get_next_value(fshop, fcode, fcolor, fsize){
						let snames = [];
						for(var sn = 0; sn < item_infos.length; sn++){
							const shop_info = item_infos[sn];
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
													 qtyInputlabel.textContent = "QTY : \nLeft : " + size_info[1][0][1];
													 qtyInputlabel.appendChild(qtyInput);
													 sinames = [];
													 break;
												 }
												 else {
													 sinames[cn] = color_info[1][cn][0];
												 }
											 }
											 if(sinames.length > 0)
												 add_combobox_value(sinames, sizeSelect);
											 conames = [];
											 break;
										 }
										 else {
											 conames[cn] = code_info[1][cn][0];
										 }
									 }
									 if(conames.length > 0)
										 add_combobox_value(conames, colorSelect);
									 cnames = [];
									 break;
								 }
								 else {
									 cnames[cn] = shop_info[1][cn][0];
								 }
							 }
								if(cnames.length > 0)
									add_combobox_value(cnames, codeSelect);
								snames = [];
								break;
							}
							else{
								snames[sn] = item_infos[sn][0];
							}
						}
						if(snames.length > 0)
							add_combobox_value(snames, shopSelect);
					}
					
					shopSelect.addEventListener('click', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value); });
					codeSelect.addEventListener('click', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value); });
					colorSelect.addEventListener('click', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value); });
					sizeSelect.addEventListener('click', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value); });
					
					shopSelect.addEventListener('change', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value); });
					codeSelect.addEventListener('change', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value); });
					
					colorSelect.addEventListener('change', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value); });
					
					sizeSelect.addEventListener('change', (e) => { get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value); });
					qtyInput.addEventListener('input', (e) => {
						get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value);
					});   
					
					function get_images(curront) {
						if(curront){
							for (let index = 0; index < curront.length; index++) {
								if(curront[index].length > 4){
									if(curront[index][4].includes(";")){
										var values = curront[index][4].split(';');
										for(let value of values) image_file_name.push(value)
									}
									else image_file_name.push(curront[index][4]); 
								}
								else get_images(curront[index][1]);
							}
						}
					}
					get_images(item_infos);
					
				get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value);
					
				const productImage_Box = document.createElement('div');
				productImage.appendChild(productImage_Box);
				//productImage_Box.classList.add('img_box');
				productImage_Box.style.position = 'relative';
				productImage_Box.style.width = '10%'; 
				productImage_Box.style.height = '10%';
				productImage_Box.style.background = '#ddd';
				
					
				const hidden_info_name = document.createElement('input');
				productImage_Box.appendChild(hidden_info_name);
				//hidden_info_name.classList.add('p_name');
				hidden_info_name.name = 'product_name';
				hidden_info_name.value = i+":-->> "+window.globallist[id].data[i].name;
				hidden_info_name.hidden = true;

				// Add other hidden input elements here
				const product_profile_Btn = document.createElement('a');
				var cil3s_id = window.globallist[id].data[i].at_shop;
				product_profile_Btn.href = 'Template/shop/Shop_page.php?shop_pag_name='+cil3s_id;

				
				productImage_Box.appendChild(product_profile_Btn);
				//product_profile_Btn.style.width = '100%';
				//product_profile_Btn.style.display = 'flex';
				//product_profile_Btn.style.position = 'absolute';
				product_profile_Btn.style.textAlign = 'center';
				product_profile_Btn.style.fontSize = '8px';
				//product_profile_Btn.style.padding = '16px';
				//product_profile_Btn.style.bottom ='-13px';
				
				product_profile_Btn.innerText = window.globallist[id].data[i].id+":-->>>"+window.globallist[id].data[i].at_shop;

				const product_profile_Img = document.createElement('img');
				product_profile_Btn.appendChild(product_profile_Img);
				product_profile_Img.style.height = '12%';
				product_profile_Img.style.textAlign = 'center';

				product_profile_Img.style.display = "flow-root";
				product_profile_Img.style.position = 'absolute';
				
				product_profile_Img.onerror = function() {
					this.src = 'Img/error1.jpg'; //Set the error image path
				};
				
				const productImage_Btn = document.createElement('div');
				//.appendChild(productImage_Btn);
				//productImage_Btn.classList.add('product-image');;
				productImage_Btn.style.width = '50px';
				productImage_Btn.style.height = '50px';
				productImage_Btn.style.background = '#ddd';
				productImage_Btn.style.overflow = 'hidden';

				const Image_Box_Btn = document.createElement('div');
				Item_Box.appendChild(Image_Box_Btn);

				const productName = document.createElement('h3');
				productImage_Box.appendChild(productName);
				//productName.classList.add('product_name');
				//productName.name = 'product_name';
				productName.textContent =`Name : ${window.globallist[id].data[i].name}`;

				const productPrice = document.createElement('div');
				productImage_Box.appendChild(productPrice);
				// productPrice.name = 'product_price';
				//productPrice.classList.add('price');
				productPrice.textContent = `Price : R${window.globallist[id].data[i].price}`;
			}
} 
			//if(window.globallist[id].display_style.split("-")[1] == "BOX")
			 else {
			   console.log("window.globallist[id].data[i].at_shop item box = ", window.globallist[id].data[i].at_shop);
				const na = window.globallist[id].data[i].name.replaceAll(' ', '_');
				const path = `Img/Items`;
			
				// Check if the item already exists by searching for a specific attribute/value combination
				const existingItem = parent_.querySelector(`[data-item="${window.globallist[id].data[i].id}"]`);
					
				if (existingItem) {
				// If the item exists, skip creating a new one and update the counter variables
				if (window.globallist[id].offset === 0) {
					if (i === 0) break;
					else i--;
				} else {
					i++;
				}
				continue;
				}
				
				Item_Box = document.createElement('div');
				Item_Box.setAttribute('data-item', window.globallist[id].data[i].id);
				//Item_Box.style.position = 'fixed';
				//Item_Box.style.textAlign = 'center';
				//Item_Box.style.padding = '50px';
				//Item_Box.style.borderRadius = '5rem';
				//Item_Box.style.display = 'flex';
				
				// Set a data attribute to identify the item
				
				//styleing
				//Item_Box.style.textAlign = 'center';
				Item_Box.style.width = '200px'; // 'auto-fit'; 
				Item_Box.style.height = '250px'; 
				//Item_Box.style.height = '90%'; 
				//Item_Box.style.padding ='0.5rem';
				//Item_Box.style.overflow = 'hidden';
				Item_Box.style.boxShadow = 'var(--box-shadow)';
				//Item_Box.style.border = 'var(--border)';
				//Item_Box.style.borderRadius = '0.5rem';
					
				const productImage_Box = document.createElement('div');
				Item_Box.appendChild(productImage_Box);
				//productImage_Box.classList.add('img_box');
				productImage_Box.style.position = 'relative';
				//productImage_Box.style.width = '100%'; 
				//productImage_Box.style.height = '80%';
				productImage_Box.style.background = '#ddd';
				productImage_Box.style.overflow = 'hidden';
				
					
				const hidden_info_name = document.createElement('input');
				productImage_Box.appendChild(hidden_info_name);
				//hidden_info_name.classList.add('p_name');
				hidden_info_name.name = 'product_name';
				hidden_info_name.value = i+": "+window.globallist[id].data[i].name;
				hidden_info_name.hidden = true;

				// Add other hidden input elements here
				const product_profile_Btn = document.createElement('a');
				var cil3s_id = window.globallist[id].data[i].at_shop;
				product_profile_Btn.href = 'Template/shop/Shop_page.php?shop_pag_name='+cil3s_id;
				
				productImage_Box.appendChild(product_profile_Btn);
				product_profile_Btn.style.width = '100%';
				//product_profile_Btn.style.display = 'flex';
				//product_profile_Btn.style.position = 'absolute';
				product_profile_Btn.style.textAlign = 'center';
				product_profile_Btn.style.fontSize = '8px';
				//product_profile_Btn.style.padding = '16px';
				//product_profile_Btn.style.bottom ='-13px';
				
				const product_profile_Img = document.createElement('img');
				productImage_Box.appendChild(product_profile_Img);
				product_profile_Img.style.height = '12%';
				product_profile_Img.style.textAlign = 'center';
				product_profile_Img.style.zIndex = "1";
				//product_profile_Img.classList.add('profile-image');
				//product_profile_Img.style.padding = '2rem';
				//product_profile_Img.style.boxShadow = 'var(--box-shadow)';
				//product_profile_Img.style.border = 'var(--border)';
				//product_profile_Img.style.borderRadius = '.5rem';
				//product_profile_Img.style.display = 'contents';
				product_profile_Img.style.display = "flow-root";
				product_profile_Img.style.position = 'absolute';
				if (window.globallist[id].data[i].at_shop.length){
				product_profile_Btn.innerText = window.globallist[id].data[i].at_shop[0].Shop_name;

				product_profile_Img.src = "Img/Company/" + window.globallist[id].data[i].at_shop[0].Shop_Id + "/" + window.globallist[id].data[i].at_shop[0].Shop_Id + "_Logo.jpg";
				}
				else product_profile_Img.src = 'Img/error1.jpg'; //Set the error image path
				
				product_profile_Img.onerror = function() {
					this.src = 'Img/error1.jpg'; //Set the error image path
				};
				
				const productImage_Btn = document.createElement('div');
				//.appendChild(productImage_Btn);
				//productImage_Btn.classList.add('product-image');;
				productImage_Btn.style.width = '100%';
				productImage_Btn.style.height = '80%';
				productImage_Btn.style.background = '#ddd';
				productImage_Btn.style.overflow = 'hidden';

				
				const Image_Box_Btn = document.createElement('div');
				productImage_Box.appendChild(Image_Box_Btn);
				//Image_Box_Btn.classList.add('box_btns'); 
				  Image_Box_Btn.style.bottom = "0";
				Image_Box_Btn.style.width = "100%";
				Image_Box_Btn.style.height = "21%";
				Image_Box_Btn.style.zIndex = "1";
				Image_Box_Btn.style.position = 'absolute';
				  Image_Box_Btn.style.background = 'aliceblue';
				function show_mini_info() {
					if (Image_Box_Btn.style.height == "100%") {
						Image_Box_Btn.style.height = "21%";
						
					} else {
						Image_Box_Btn.style.height = "100%";
					}
					
				}
				Image_Box_Btn.addEventListener('click', (e) => { show_mini_info(); });
				
        const Quick_select_info = document.createElement('div');
				Image_Box_Btn.appendChild(Quick_select_info);
				//Quick_select_info.style.backgroundColor = 'red';
				Quick_select_info.textContent = window.globallist[id].data[i].Image;
				
				const productName = document.createElement('h3');
				Quick_select_info.appendChild(productName);
				//productName.classList.add('product_name');
				//productName.name = 'product_name';
				productName.textContent = window.globallist[id].data[i].name;
				productName.addEventListener('click', (e) => { show_mini_info(); });
				  
				const productPrice = document.createElement('div');
				Quick_select_info.appendChild(productPrice);
				Quick_select_info.style.display = 'block';
				productPrice.textContent = `R${window.globallist[id].data[i].price}`;
				
				const productShops = document.createElement('div');
				Quick_select_info.appendChild(productShops);
        productShops.style.display = 'flex';
        productShops.style.gap = '1px';
				productShops.textContent = `Shops : `;

        const productcodes = document.createElement('div');
				Quick_select_info.appendChild(productcodes);
        productcodes.style.display = 'flex';
        productcodes.style.gap = '1px';
				productcodes.textContent = `Codes : `;

        const productcolors = document.createElement('div');
				Quick_select_info.appendChild(productcolors);
				productcolors.style.display = 'flex';
				productcolors.style.gap = '1px';
				productcolors.textContent = `Color : `;
				
				const productsizes = document.createElement('div');
				Quick_select_info.appendChild(productsizes);
				productsizes.style.display = 'flex';
				productsizes.style.gap = '1px';
				productsizes.textContent = `Size : `;

				const Quick_buttons = document.createElement('div');
				Image_Box_Btn.appendChild(Quick_buttons);
				Quick_buttons.style.backgroundColor = 'green';
				Quick_buttons.style.top = "90%";
        Quick_buttons.style.display = 'flex';
				Quick_buttons.textContent = window.globallist[id].data[i].Image;
				
				const Image_Box_likeBtn = document.createElement('button');
				Quick_buttons.appendChild(Image_Box_likeBtn);
				//Image_Box_likeBtn.style.width = '30%';
				//Image_Box_likeBtn.classList.add('lcb_1btns');
				//Image_Box_likeBtn.name = 'add_to_cart';
				///Image_Box_addBtn.style.display= "block";
				//Image_Box_addBtn.style.color = "black";
				Image_Box_likeBtn.style.backgroundColor = 'var(--with)';
				//Image_Box_likeBtn.style.top = "9rem";
				//Image_Box_likeBtn.style.display = "flow-root";
				//Image_Box_likeBtn.style.position = 'absolute';
				Image_Box_likeBtn.style.color = "black";
				Image_Box_likeBtn.style.fontSize = '1rem';
				Image_Box_likeBtn.style.padding = '6%';
				Image_Box_likeBtn.style.borderRadius = '0.2rem';
				Image_Box_likeBtn.style.cursor = 'pointer';
				Image_Box_likeBtn.style.marginTop = '1rem';
				Image_Box_likeBtn.innerText = 'Like';

				const Image_Box_addBtn = document.createElement('button');
				Quick_buttons.appendChild(Image_Box_addBtn);
				//Image_Box_addBtn.classList.add('lcb_1btns');
				//Image_Box_addBtn.name = 'add_to_cart';
				Image_Box_addBtn.innerText = 'Add To Cart';
				//Image_Box_addBtn.style.width = '30%';
				//Image_Box_addBtn.style.display= "block";
				//Image_Box_addBtn.style.color = "black";
				Image_Box_addBtn.style.backgroundColor = 'var(--with)';
				
				Image_Box_addBtn.style.color = "black";
				Image_Box_addBtn.style.fontSize = '1rem';
				Image_Box_addBtn.style.padding = '6%';
				Image_Box_addBtn.style.borderRadius = '0.2rem';
				Image_Box_addBtn.style.cursor = 'pointer';
				Image_Box_addBtn.style.marginTop = '1rem';




				const productImage = document.createElement('img');
				productImage_Box.appendChild(productImage);
				productImage.style.width = '100%';
				productImage.style.height = '100%';
				productImage.style.position = 'relative';
				productImage.addEventListener('click', (e) => { show_mini_info(); });
				//productImage.style.objectFit = 'cover'; // This ensures the image covers the entire box without stretching
				productImage.onerror = function() {
					this.src = 'Img/error1.jpg'; // Set the error image path
					//this.style.width = '100%'; // Set width to match original image
					//this.style.height = '100%'; // Set height to match original image
				};

				let image_file_name = [];
				
				if(window.globallist[id].data[i].more_info != ""){
					//console.log("window.globallist[id].data[i].more_info ++++++", window.globallist[id].data[i].more_info);
					let item_infos = JSON.parse(window.globallist[id].data[i].more_info);
					//let item_infos = JSON.parse(JSON.stringify(['a',['b',[]]]));
					//console.log("item_infos ++++++", item_infos);
					var shops = [];
					var codes = [];
					var colors = [];
					var sizes = [];
					
					item_infos.forEach(shop =>{
					  shops.push(shop[0]);
					  const productShop = document.createElement('div');
          	productShops.appendChild(productShop);
          	productShop.textContent = shop[0];
					  shop[1].forEach(code =>{
					    codes.push(code[0]);
					    const productcode = document.createElement('div');
          		productcodes.appendChild(productcode);
          		productcode.textContent = code[0];
  					  code[1].forEach(color =>{
  					    if(!colors.includes(color[0])){
  					      colors.push(color[0]);
    					    const productcolor = document.createElement('div');
            			productcolors.appendChild(productcolor);
            			productcolor.textContent = color[0];
            			productcolor.style.backgroundColor = color[0];
  					    }
    					  color[1].forEach(size =>{
    					    sizes.push(size[0]);
    					    const productsize = document.createElement('div');
          				productsizes.appendChild(productsize);
          				productsizes.textContent = size[0];
    					  });
  					  });
					  });
					});
					
					function get_images(curront) {
						if(curront){
							for (let index = 0; index < curront.length; index++) {
								if(curront[index].length > 4){
									if(curront[index][4].includes(";")){
										var values = curront[index][4].split(';');
										for(let value of values) image_file_name.push(value)
									}
									else image_file_name.push(curront[index][4]); 
								}
								else get_images(curront[index][1]);
							}
						}
					}
					get_images(item_infos);
					//console.log("image_file_name : ", image_file_name);
					//console.log("item_infos +++++++++++++++++++++++++++++++++", item_infos);
					let attempts = 0;
					function displayRondomImage() {
						var randomIndex = Math.floor(Math.random() * image_file_name.length);
						var imageUrl = image_file_name[randomIndex];
						productImage.onerror = function() {
							attempts++;
							if(attempts >= image_file_name.length) this.src = 'Img/error1.jpg'; //Set the error image path
							else displayRondomImage();
						};
						productImage.src = `${path}/${imageUrl}`;
						//console.log("`${path}/${imageUrl}` : ", `${path}/${imageUrl}`);
						productImage.onload = function() {
							attempts = 0;
						};
					}
					displayRondomImage();
					// TODO MAKE USER OR OWNAR CHOOHES HOW TO CHANGE IMG 
					// change img whan mouse move on top
					function changeImageOnHover() {
						var timeout;
						productImage_Box.addEventListener('mousemove', (e) => {
							timeout = setTimeout(function () {
								displayRondomImage();
							}, 5000);
						});
						productImage_Box.addEventListener('mouseout', (e) => {
							clearTimeout(timeout);
						});
					}
					changeImageOnHover();
					// CHANGE WITH IN GIVE TODO: MAKE USER OR OWNAER CHOOSE TIME 
					//setInterval(displayRondomImage, 10 * 1000); // 10 second
				}
				  
				let b0 = window.globallist[id].data[i].id;
				let b1 = window.globallist[id].data[i].name;
				let b2 = window.globallist[id].data[i].price;
				let b3 = image_file_name;
				let b4 = window.globallist[id].data[i].description;
				let b5 = window.globallist[id].data[i].at_shop;
				let b6 = window.globallist[id].data[i].type;
				let b7 = window.globallist[id].data[i].code;
				let b8 = window.globallist[id].data[i].more_info;
				let b9 = window.globallist[id].data[i].more_info;
				productImage.addEventListener('click', function() {
		
					let a0 = b9;
					let a1 = b0;
					let a2 = b1;
					let a3 = b2;
					let a4 = b3;
					let a5 = b4;
					let a6 = b5;
					let a7 = b6;
					let a8 = b7;
					let a9 = path;
					let a10 = b8;
					View_Selected(a0, a1, a2, a3, a4, a5, a6, a7, a8, a9, a10);
				});
			}
		  }
		}
		else if(window.globallist[id].list_what == "SHOPS") {
		  console.log("dddddddddddddddddddddddddddddddmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmwwwwwwwwwwwwwwwwwwwwwweeeeeewwwwwwwjjjjjjjjjjjkkkkkkkdsssssssssssssssslsslllkkkwwkeeekeeekekekekejejejehrhrhevrhdhr");
			Item_Box = document.createElement('div');
			Item_Box.setAttribute('data-item', window.globallist[id].data[i].Shop_Id);
			//styleing
			Item_Box.style.textAlign = 'center';
			Item_Box.style.width = '200px'; // = 'auto-fit'; 
			Item_Box.style.height = '200px'; 
			Item_Box.style.border = 'var(--border)';
			Item_Box.style.borderRadius = '50%';
			Item_Box.style.overflow = 'hidden';
			
			const shopName = document.createElement('h3');
			Item_Box.appendChild(shopName);
			//shopName.classList.add('shop_name');
			//shopName.name = 'shop_name';
			shopName.style.textAlign = 'center';
			//shopName.style.position = 'absolute';
			shopName.style.top = "50%";
			shopName.textContent = window.globallist[id].data[i].Shop_name+": "+window.globallist[id].data[i].Shop_brand_name;

			const productImage = document.createElement('img');
			Item_Box.appendChild(productImage);
			productImage.style.width = '100%';
			productImage.style.height = '100%';
			//productImage.style.objectFit = 'cover'; // This ensures the image covers the entire box without stretching
			productImage.onerror = function() {
				this.src = 'Img/error1.jpg'; // Set the error image path
				//this.style.width = '100%'; // Set width to match original image
				//this.style.height = '100%'; // Set height to match original image
			};
			//productImage.src = `${path}/${window.globallist[id].data[i].Shop_profile_img[0]}`;
		}
		else if(window.globallist[id].list_what == "BANNERS") {
			console.log("window.globallist[id].data[i].at_shop BANNERS = ", window.globallist[id].data[i].at_shop);
			const shop_name = window.globallist[id].data[i].at_shop;
			const na = window.globallist[id].data[i].name.replaceAll(' ', '_');
			const path = `Img/${shop_name}/products/${window.globallist[id].data[i].type}/${na}/${window.globallist[id].data[i].code}`;
		
			// Check if the item already exists by searching for a specific attribute/value combination
			const existingItem = parent_.querySelector(`[data-item="${window.globallist[id].data[i].id}"]`);
			//styleing slide_section
			parent_.style.padding = '0';
			parent_.style.width = '100%'; // = 'auto-fit'; 
			parent_.style.height = '100%'; // = 'auto-fit'; 
			parent_.style.borderRadius = '10PX';
			parent_.style.overflow = 'hidden';
			parent_.style.display = 'contents'; 
			
			slide_Box.style.width = '100%'; // = 'auto-fit'; 
			slide_Box.style.height = '100%'; // = 'auto-fit'; 
			slide_Box.style.overflow = 'hidden';
			slide_Box.style.display = '-webkit-box'; 

			const st = document.createElement('div');
			slide_Box.appendChild(st);
			
			st.style.width = '100%'; // = 'auto-fit'; 
			st.style.height = '100%'; // = 'auto-fit'; 
			st.id = 'banner'+id+'st'+i; 	
			st.classList.add("banner_st");

			const BannerImage = document.createElement('img');
			st.appendChild(BannerImage);
			BannerImage.style.width = '100%';
			BannerImage.style.height = '100%';
			//BannerImage.style.objectFit = 'cover'; // This ensures the image covers the entire box without stretching
			BannerImage.onerror = function() {
				if(def_banner_count == 3) def_banner_count = 1;
				else def_banner_count++;
				this.src = './Img/banner/Banner'+def_banner_count+'.jpg'; // Set the error image path
			};
			BannerImage.src = `${path}/${window.globallist[id].data[i].images[0]}`;
			

			const radio = document.createElement('input');
			nav_m.appendChild(radio);
			radio.type = 'radio';
			radio.id = 'banner'+id+'radio'+i; 
			radio.classList.add("banner_radio");
			radio.name = 'radio-btn'; 
			radio.style.border = '2px solid #23e3c2';
			radio.style.marginRight = '1%';
			radio.style.padding = '1%';
			radio.style.borderRadius = '10px';
			radio.style.pointer = '10px';
			radio.style.transition = '1s';
			radio.style.fontSize = 'x-small';
			let oi = i;
			radio.addEventListener('click', (e) => {
				let index = oi;
				let insb = slide_Box;
				const st0 = insb.querySelectorAll('.banner_st');
				if(st0[0]) st0[0].style.marginLeft = '-'+(index*100)+'%';
				this.checked = true;
			});
		}
		//COLLECTION
		else if(window.globallist[id].list_what == "COLLECTIONS") {
			console.log("window.globallist[id].data[i].at_shop collec= ", window.globallist[id].data[i].at_shop);
			const shop_name = window.globallist[id].data[i].at_shop;
			const na = window.globallist[id].data[i].name.replaceAll(' ', '_');
			const path = `Img/${shop_name}/products/${window.globallist[id].data[i].type}/${na}/${window.globallist[id].data[i].code}`;
		
			// Check if the item already exists by searching for a specific attribute/value combination
			const existingItem = parent_.querySelector(`[data-item="${window.globallist[id].data[i].id}"]`);
			//styleing
			const Btn = document.createElement('button');
			parent_.appendChild(Btn);
			parent_.style.padding = '0';
			parent_.style.width = '100%'; // = 'auto-fit'; 
			parent_.style.height = '100%'; // = 'auto-fit'; 
			parent_.style.borderRadius = '10PX';
			//parent_.style.overflow = 'hidden';
			//parent_.style.display = 'contents'; 

			parent_.addEventListener('mousemove', (e) => {
			const containerRect = parent_.getBoundingClientRect();
		
			if (e.clientX <= containerRect.left + 200) {
				parent_.scrollBy({
				left: -200,
				behavior: 'smooth',
				});
			} else if (e.clientX >= containerRect.right - 200) {
				parent_.scrollBy({
				left: 200,
				behavior: 'smooth',
				});
			}
			});

			Btn.style.textAlign = 'center';
			Btn.style.width = '200px'; // = 'auto-fit'; 
			Btn.style.height = '50px'; 
			Btn.style.border = 'var(--border)';
			Btn.style.overflow = 'hidden';
			Btn.style.border = '1px solid #ccc';
			Btn.style.marginRight = '10px';
			Btn.style.flexShrink = '0';
			Btn.style.display = 'flex';
			Btn.style.alignItems = 'center';
			Btn.style.justifyContent = 'center';
			Btn.style.fontSize = '24px';
			Btn.style.fontWeight = 'bold';

			
			Btn.style.backgroundColor = '#ff990094';
			Btn.style.textAlign = 'center';
			Btn.style.border = 'none';
			Btn.style.color = 'white';
			Btn.style.padding = '12px 24px';
			Btn.style.fontSize = '16px';
			Btn.style.cursor = 'pointer';
			Btn.style.borderRadius = '8px';
			Btn.style.transition = 'background-color 0.3s ease';


			Btn.textContent = window.globallist[id].data[i].id+": "+window.globallist[id].data[i].at_shop;

			Btn.addEventListener('mouseenter', function(){
				Btn.style.transform = 'scale(1.2)';
				Btn.style.borderRadius = '.7rem';
				Btn.style.backgroundColor = '#3e8e41';
				
			});
			Btn.addEventListener('mouseleave', function(){
				Btn.style.transform = 'scale(1)';
				Btn.style.borderRadius = '8px';
				Btn.style.backgroundColor = '#ff990094';
				
			});
		}

		if(Item_Box){
			if(window.globallist[id].offset === 0){
				// Get the first child of the parent element
				var firstChild = parent_.firstChild;
				parent_.insertBefore(Item_Box, firstChild);
			}
			else if(window.globallist[id].offset === 1)  parent_.appendChild(Item_Box);
		}
		itemCount = parent_.childElementCount;
	}

	if(window.globallist[id].list_what == "BANNERS" && slide_Box) {
		var counter=-1;
		let sb = slide_Box;
		let nvm = nav_m;
		setInterval(function(){
			let insb = sb;
			let innvm= nvm;
			const f = nvm.querySelectorAll('.banner_radio');
			let index = 0;
			for (; index < f.length; index++) {
				const element = f[index];
				if(element.checked) break;
			}
			index++;
			if(index >= f.length) index = 0;
			if (f[index]) f[index].checked=true;

			const st0 = insb.querySelectorAll('.banner_st');
			if(st0[0]) st0[0].style.marginLeft = '-'+(index*100)+'%';
		},5000);
	}
}

// Function to handle scroll event
function handle_itrms_box_Scroll(items_container, Items_Box, id) {
	//console.log('in Scrolling......');
	const containerScrollTop = Items_Box.scrollTop;
	const containerScrollLeft = Items_Box.scrollLeft;
	const scrollToplength = Items_Box.scrollHeight - Items_Box.clientHeight;
	const scrollLeftlength = Items_Box.scrollWidth - Items_Box.clientWidth;
	
	console.log('info containerScrollTop = '+containerScrollTop+' <= containerScrollLeft = '+containerScrollLeft);
	console.log('info scrollToplength = '+scrollToplength+' <= scrollLeftlength = '+scrollLeftlength);
	// Check if the scroll position is within the threshold distance from the top
	if (containerScrollLeft == 0 && containerScrollTop <= 2 || scrollToplength == 0 && containerScrollLeft <= 2 && window.globallist[id].display_style.split("-")[1] != "TABLE") {
			window.globallist[id].offset = 0;
		  //const scrollermid = scrolllength/2;
		  // Set the threshold distance from the top and bottom positions
		  //const threshold = (scrolllength/3)-10;

		  console.log('Scroll about to reach top of target element');
		  //console.log('Tbefore offset=' + offset + '  &limit=' + limit + '  &firstset=' + firstset + '  &lastset=' + lastset);
		  //Items_Box.removeEventListener('scroll', function() { handle_itrms_box_Scroll(items_container, Items_Box, data, data_leght, offset, limit, window.globallist[id].itemlimit, firstset, lastset)});
			  
		  readhtmtable(Items_Box, id);

		  if(containerScrollLeft != 0) Items_Box.scrollTop = 10;
		  else if(scrollToplength != 0) Items_Box.scrollTop = 10;
		  //console.log('Tafter offset=' + offset + '  &limit=' + limit + '  &firstset=' + firstset + '  &lastset=' + lastset);
		  //Items_Box.addEventListener('scroll', function() { handle_itrms_box_Scroll(items_container, Items_Box, data, data_leght, offset, limit, window.globallist[id].itemlimit, firstset, lastset)});
	}
	
	// Check if the scroll position is within the threshold distance from the bottom
	if (containerScrollLeft == 0 && containerScrollTop >= scrollToplength - 2 || scrollToplength == 0 && containerScrollLeft  >= scrollLeftlength - 2 && window.globallist[id].display_style.split("-")[1] != "TABLE") {
		  //console. log(">>", targetElementBottomPosition);
		  console.log('Scroll about to reach bottom of target element');
		  window.globallist[id].offset = 1;
		  ///console.log('Bbefore offset=' + offset + '  &limit=' + limit + '  &firstset=' + firstset + '  &lastset=' + lastset);
		  //Items_Box.removeEventListener('scroll', function() { handle_itrms_box_Scroll(items_container, Items_Box, data, data_leght, offset, limit, window.globallist[id].itemlimit, firstset, lastset)});
		  
		  readhtmtable(Items_Box, id);
		  if(containerScrollLeft != 0) Items_Box.scrollTop = containerScrollLeft-10;
		  else if(scrollToplength != 0) Items_Box.scrollTop = scrollToplength-10;
		  //console.log('Bafter offset=' + offset + '  &limit=' + limit + '  &firstset=' + firstset + '  &lastset=' + lastset);
		  //Items_Box.addEventListener('scroll', function() { handle_itrms_box_Scroll(items_container, Items_Box, data, data_leght, offset, limit, window.globallist[id].itemlimit, firstset, lastset)});
	}
}

function create_list(parent_b, title, display_t_on, list_box_weidth, list_box_hight, display_style, list_what, def_search_info, allwo_edit, Company_Id) {
  
	if (!window.globallist){
		window.globallist = [];
	}
	window.globallist.push({
				data: [],
				data_leght : 0,
				offset : 0,
				limit : 10,
				itemlimit : 50,
				firstset : 0,
				lastset : 0,
				list_box_hight : list_box_hight, 
				list_box_weidth : list_box_weidth, 
				display_style : display_style, 
				def_search_info : def_search_info,

				list_what : list_what, 
				list_type_value : [],
				list_clumens : [],
				Company_Id : Company_Id
				}); 
	var id = window.globallist.length-1;

	console.log('id=' + id);  

	console.log('display_style=' + display_style);  
	const items_list_container = document.createElement('div');
	items_list_container.classList.add("List_container");
	items_list_container.value = "List_container";

	

	//items_list_container.id = contenur_n;
	parent_b.appendChild(items_list_container);
	//items_list_container.classList.add(contenur_n);
	//items_list_container.style.gap = '1.5rem';
	//items_list_container.style.justifyContent = 'left';
	//items_list_container.style.overflowX = 'hidden';
	//items_list_container.style.overflowY = 'hidden';
	//items_list_container.style.marginRight = 'auto';
	items_list_container.style.textAlign = 'center';
	//items_list_container.style.display = 'grid';
	//items_list_container.style.padding ='0.5rem';
	//items_list_container.style.boxShadow = 'var(--box-shadow)';
	//items_list_container.style.border = 'var(--border)';
	//items_list_container.style.borderRadius = '1.5rem';
	//items_list_container.style.alignItems = 'center';
	//items_list_container.style.alignContent = 'space-between';
	//items_list_container.style.position ='relative'; // off for search item to be on top

	if  (list_box_hight != "") items_list_container.style.height = list_box_hight; 
	if(list_box_weidth != "") items_list_container.style.width = list_box_weidth; 
	
	console.log('allwo_edit=' + allwo_edit);  
	if(allwo_edit == 1){
		let btns = ["ITEMS", "BANNERS", "SHOPS", "COLLECTIONS"];
		function send_page_update(dh, item_index, setteing_data) {
			let formData = new FormData();
			if(btns.includes(dh)){
				formData.append('Add_New_Page_Info', 'Add_New_Page_Info');
			}
			else if(dh == "Remove"){
				formData.append('Remove_Page_Info', 'Remove_Page_Info');
			}
			else if(dh == "Move Up" || dh == "Move Down"){
				formData.append('move_Page_Info', 'move_Page_Info');
			}
			else if(dh == "Save"){
				formData.append('Save_Page_Info', 'Save_Page_Info');
				
				var dataobject = { data : setteing_data};
				formData.append('setteing_data', JSON.stringify(dataobject));
			}
			
			 
			formData.append('Add_Item_of', dh);
			formData.append('Index', item_index);
			
			fetchAjaxRequest('server/Company/Page/Company_page.php', "POST", formData, 
			function (data){
				console.log('send_page_update fetchAjaxRequest data', data);
				
			}, function (error) { alert("error send_page_update" + error); } );
		}
		const edit_container = document.createElement('div');
		items_list_container.appendChild(edit_container);
		edit_container.style.textAlign = 'center';
		edit_container.style.boxShadow = 'var(--box-shadow)';
		edit_container.style.border = 'var(--border)';
		edit_container.style.borderRadius = '1.5rem';
		edit_container.style.marginRight = 'auto';
		//edit_container.style.position ='relative';
		edit_container.style.justifyContent = 'center';
		//edit_container.style.alignItems = 'center';
		//edit_container.style.alignContent = 'space-between';
		//edit_container.style.flexWrap = 'wrap';
		edit_container.style.height = 'auto'; 
		edit_container.style.flexDirection = 'column';
		edit_container.style.flexWrap = 'wrap';
		//edit_container.style.gap = '1.5rem';
		//edit_container.style.overflowX = 'auto';
		//edit_container.style.overflowY = 'hidden';
		edit_container.style.width = '100%';
		edit_container.style.height = '0';
		edit_container.style.behavior = 'smooth';
		//edit_container.style.display = 'flex';
		//edit_container.style.flexDirection = 'row';
		//edit_container.style.flexWrap = 'wrap';
		
		const show_edit_container = document.createElement('button');
		edit_container.appendChild(show_edit_container);
		show_edit_container.textContent = "Edit";
		show_edit_container.style.placeItems = 'center';
		show_edit_container.style.backgroundColor = '#ff990094';
		show_edit_container.style.bottom = '-11px';
		show_edit_container.style.left = '1px';
		show_edit_container.style.color = 'Blue';
		show_edit_container.style.width = '50px';
		show_edit_container.style.height = '17px';
		show_edit_container.style.position = 'relative';
		show_edit_container.style.display = 'flex';
		show_edit_container.style.boxShadow = 'var(--box-shadow)';
		show_edit_container.style.border = 'var(--border)';
		show_edit_container.style.borderRadius = '1.5rem';

		
		const container_Manu = document.createElement('div');
		edit_container.appendChild(container_Manu);
		container_Manu.style.textAlign = 'center';
		container_Manu.style.boxShadow = 'var(--box-shadow)';
		container_Manu.style.border = 'var(--border)';
		container_Manu.style.borderRadius = '1.5rem';
		container_Manu.style.marginRight = 'auto';
		//container_Manu.style.position ='relative';
		container_Manu.style.justifyContent = 'center';
		container_Manu.style.gap = '5rem';
		//container_Manu.style.alignItems = 'center';
		container_Manu.style.alignContent = 'space-between';
		//container_Manu.style.flexWrap = 'wrap';
		container_Manu.style.height = 'auto'; 

		container_Manu.style.display = 'none';
		container_Manu.style.flexWrap = 'wrap';
		container_Manu.style.gap = '1.5rem';
		container_Manu.style.overflowX = 'auto';
		container_Manu.style.overflowY = 'hidden';
		container_Manu.style.width = '100%';
		container_Manu.style.behavior = 'smooth';
		container_Manu.style.flexDirection = 'row';
		container_Manu.style.flexWrap = 'wrap';
		
		
		show_edit_container.addEventListener('click', (e) => {
			if(show_edit_container.textContent == "Edit"){
				show_edit_container.textContent = "Done";
				edit_container.style.height = 'auto';
				container_Manu.style.display = 'flex';
			}else if(show_edit_container.textContent == "Done"){
				show_edit_container.textContent = "Edit";
				edit_container.style.height = '0';
				container_Manu.style.display = 'none';
			}
		});

		items_list_container.addEventListener('mousemove', (e) => {
			const containerRect = items_list_container.getBoundingClientRect();
			if (e.clientX <= containerRect.left + 20 || e.clientX >= containerRect.right - 20 ||
				e.clientX <= containerRect.top + 20 || e.clientX >= containerRect.bottom - 20) {
					container_Manu.style.width = '100%';
			} else if (e.clientX >= containerRect.left + 20 && e.clientX <= containerRect.right - 20 &&
					e.clientX >= containerRect.top + 20 && e.clientX <= containerRect.bottom - 20) {
			}
		});

		const container_Remove = document.createElement('button');
		container_Manu.appendChild(container_Remove);
		container_Remove.textContent = "Remove";
		//show_edit_container.style.backgroundColor = '#ff990094';
		//show_edit_container.style.top = '1px';
		//show_edit_container.style.laft = '1px';
		//show_edit_container.style.color = 'blue';
		//show_edit_container.style.width = '50px';
		//show_edit_container.style.height = '17px';
		//show_edit_container.style.position = 'absolute';
		//show_edit_container.style.display = 'flex';
		//show_edit_container.style.boxShadow = 'var(--box-shadow)';
		//show_edit_container.style.border = 'var(--border)';
		//show_edit_container.style.borderRadius = '1.5rem';
		container_Remove.addEventListener('click', (e) => {
			let index = Array.prototype.indexOf.call(parent_b.children, items_list_container);
			send_page_update("Remove", index-1, []);
			items_list_container.remove();
		});

		const container_Move_up = document.createElement('button');
		container_Manu.appendChild(container_Move_up);
		container_Move_up.textContent = "Move Up";
		//show_edit_container.style.backgroundColor = '#ff990094';
		//show_edit_container.style.top = '1px';
		//show_edit_container.style.laft = '1px';
		//show_edit_container.style.color = 'blue';
		//show_edit_container.style.width = '50px';
		//show_edit_container.style.height = '17px';
		//show_edit_container.style.position = 'absolute';
		//show_edit_container.style.display = 'flex';
		//show_edit_container.style.boxShadow = 'var(--box-shadow)';
		//show_edit_container.style.border = 'var(--border)';
		//show_edit_container.style.borderRadius = '1.5rem';

		container_Move_up.addEventListener('click', (e) => {
			let index = Array.prototype.indexOf.call(parent_b.children, items_list_container);
			let n = index-1;
			console.log('move up - index=' + index);
			if(n < 0) n =  parent_b.children.length;
			console.log('n=' + n);
			parent_b.insertBefore(items_list_container, parent_b.children[n]);
			send_page_update("Move Up", index-1, []);
		});

		const container_Move_Down = document.createElement('button');
		container_Manu.appendChild(container_Move_Down);
		container_Move_Down.textContent = "Move Down";
		//show_edit_container.style.backgroundColor = '#ff990094';
		//show_edit_container.style.top = '1px';
		//show_edit_container.style.laft = '1px';
		//show_edit_container.style.color = 'blue';
		//show_edit_container.style.width = '50px';
		//show_edit_container.style.height = '17px';
		//show_edit_container.style.position = 'absolute';
		//show_edit_container.style.display = 'flex';
		//show_edit_container.style.boxShadow = 'var(--box-shadow)';
		//show_edit_container.style.border = 'var(--border)';
		//show_edit_container.style.borderRadius = '1.5rem';

		container_Move_Down.addEventListener('click', (e) => {
			let index = Array.prototype.indexOf.call(parent_b.children, items_list_container);
			let n = index + 2;
			console.log('move down + index=', index);
			if(n == parent_b.children.length) n =  0;
			console.log('n=' + n);
			parent_b.insertBefore(items_list_container, parent_b.children[n]);
			send_page_update("Move Down", index-1, []);
		});

		const container_Setting = document.createElement('button');
		container_Manu.appendChild(container_Setting);
		container_Setting.textContent = "Setting";
		//show_edit_container.style.backgroundColor = '#ff990094';
		//show_edit_container.style.top = '1px';
		//show_edit_container.style.laft = '1px';
		//show_edit_container.style.color = 'blue';
		//show_edit_container.style.width = '50px';
		//show_edit_container.style.height = '17px';
		//show_edit_container.style.position = 'absolute';
		//show_edit_container.style.display = 'flex';
		//show_edit_container.style.boxShadow = 'var(--box-shadow)';
		//show_edit_container.style.border = 'var(--border)';
		//show_edit_container.style.borderRadius = '1.5rem';

		const setting_contener = document.createElement('div');
		edit_container.appendChild(setting_contener);
		setting_contener.style.textAlign = 'center';
		setting_contener.style.boxShadow = 'var(--box-shadow)';
		setting_contener.style.border = 'var(--border)';
		setting_contener.style.borderRadius = '1.5rem';
		setting_contener.style.marginRight = 'auto';
		//setting_contener.style.position ='relative';
		setting_contener.style.justifyContent = 'center';
		setting_contener.style.gap = '5rem';
		//setting_contener.style.alignItems = 'center';
		setting_contener.style.alignContent = 'space-between';
		//setting_contener.style.flexWrap = 'wrap';
		setting_contener.style.height = '90%'; 

		setting_contener.style.display = 'flex';
		setting_contener.style.flexDirection = 'column';
		setting_contener.style.flexWrap = 'wrap';
		setting_contener.style.gap = '1.5rem';
		setting_contener.style.overflowX = 'auto';
		setting_contener.style.overflowY = 'hidden';
		setting_contener.style.width = '100%';
		setting_contener.style.height = 'auto';
		setting_contener.style.behavior = 'smooth';
		setting_contener.style.display = 'None';
		setting_contener.style.flexDirection = 'column';
		//setting_contener.style.flexWrap = 'wrap';

		container_Setting.addEventListener('click', (e) => {
			if(container_Setting.textContent == "Setting"){
				container_Setting.textContent = "Done";
				setting_contener.style.display = 'flex';
			}else if(container_Setting.textContent == "Done"){
				container_Setting.textContent = "Setting";
				setting_contener.style.display = 'None';
			}
		});

		// Check if title display is enabled
		var doTitleDisplay = document.createElement('label');
		doTitleDisplay.textContent = 'Title:';
		doTitleDisplay.style.fontSize = 'small';
		var doTitleInput = document.createElement('input');
		doTitleInput.type = 'text';
		doTitleInput.value = title;
		doTitleInput.style.boxShadow = 'var(--box-shadow)';
		doTitleInput.style.border = 'var(--border)';
		doTitleInput.style.borderRadius = '1.5rem';
		doTitleDisplay.appendChild(doTitleInput);
		setting_contener.appendChild(doTitleDisplay);

		// Create a label and input for changing the title
		var titleLabel = document.createElement('label');
		titleLabel.textContent = 'Show Title:';
		titleLabel.style.fontSize = 'small';
		var titleInput = document.createElement('input');
		titleInput.type = 'checkbox';
		titleInput.checked = parseInt(display_t_on);
		titleInput.style.boxShadow = 'var(--box-shadow)';
		titleInput.style.border = 'var(--border)';
		titleInput.style.borderRadius = '1.5rem';
		titleLabel.appendChild(titleInput);
		setting_contener.appendChild(titleLabel);
		
		// Create a label and input for changing the width
		var widthLabel = document.createElement('label');
		widthLabel.textContent = 'Width:';
		widthLabel.style.fontSize = 'small';
		var widthInput = document.createElement('input');
		widthInput.type = 'number';
		widthInput.value = list_box_weidth;
		widthInput.style.boxShadow = 'var(--box-shadow)';
		widthInput.style.border = 'var(--border)';
		widthInput.style.borderRadius = '1.5rem';
		widthLabel.appendChild(widthInput);
		setting_contener.appendChild(widthLabel);
		
		// Create a label and input for changing the height
		var heightLabel = document.createElement('label');
		heightLabel.textContent = 'Height:';
		heightLabel.style.fontSize = 'small';
		var heightInput = document.createElement('input');
		heightInput.type = 'number';
		heightInput.value = list_box_hight;
		heightInput.style.boxShadow = 'var(--box-shadow)';
		heightInput.style.border = 'var(--border)';
		heightInput.style.borderRadius = '1.5rem';
		heightLabel.appendChild(heightInput);
		setting_contener.appendChild(heightLabel);
		
		// Create a label and select for choosing display type (H or V)
		var displayLabel = document.createElement('label');
		displayLabel.textContent = 'Display Type:';
		displayLabel.style.fontSize = 'small';
		var displaySelect = document.createElement('select');
		var optionH = document.createElement('option');
		optionH.value = 'H';
		optionH.textContent = 'Horizontal';
		var optionV = document.createElement('option');
		optionV.value = 'V';
		optionV.textContent = 'Vertical';
		displaySelect.appendChild(optionH);
		displaySelect.appendChild(optionV);
		displaySelect.value = display_style;
		displayLabel.appendChild(displaySelect);
		setting_contener.appendChild(displayLabel);
		
		// Create a label and input for list type
		var listLabel = document.createElement('label');
		listLabel.textContent = 'List What:';
		listLabel.style.fontSize = 'small';
		var listInput = document.createElement('input');
		listInput.type = 'text';
		listInput.value = list_what;
		listInput.style.boxShadow = 'var(--box-shadow)';
		listInput.style.border = 'var(--border)';
		listInput.style.borderRadius = '1.5rem';
		listLabel.appendChild(listInput);
		setting_contener.appendChild(listLabel);
		
		// Create a label and input for default search
		var searchLabel = document.createElement('label');
		searchLabel.textContent = 'Default Search:';
		searchLabel.style.fontSize = 'small';
		var searchInput = document.createElement('input');
		searchInput.type = 'text';
		searchInput.value = def_search_info;
		searchInput.style.boxShadow = 'var(--box-shadow)';
		searchInput.style.border = 'var(--border)';
		searchInput.style.borderRadius = '1.5rem';
		searchLabel.appendChild(searchInput);
		setting_contener.appendChild(searchLabel);

		// Create a label and input for default search
		var searchLabel = document.createElement('label');
		searchLabel.textContent = 'Default Css:';
		searchLabel.style.fontSize = 'small';
		var searchInput = document.createElement('input');
		searchInput.type = 'text';
		searchInput.value = "";
		searchInput.style.boxShadow = 'var(--box-shadow)';
		searchInput.style.border = 'var(--border)';
		searchInput.style.borderRadius = '1.5rem';
		searchLabel.appendChild(searchInput);
		setting_contener.appendChild(searchLabel);

		const Done_changening = document.createElement('button');
		setting_contener.appendChild(Done_changening);
		Done_changening.textContent = "Save";
		//show_edit_container.style.backgroundColor = '#ff990094';
		//show_edit_container.style.top = '1px';
		//show_edit_container.style.laft = '1px';
		//show_edit_container.style.color = 'blue';
		//show_edit_container.style.width = '50px';
		//show_edit_container.style.height = '17px';
		//show_edit_container.style.position = 'absolute';
		//show_edit_container.style.display = 'flex';
		//show_edit_container.style.boxShadow = 'var(--box-shadow)';
		//show_edit_container.style.border = 'var(--border)';
		//show_edit_container.style.borderRadius = '1.5rem';

		Done_changening.addEventListener('click', (e) => {
			let infos = [doTitleInput.value, titleInput.checked, widthInput.value, heightInput.value, displaySelect.value, listInput.value, searchInput.value, searchInput.value];
			let index = Array.prototype.indexOf.call(parent_b.children, items_list_container);
			send_page_update("Save", index-1, infos);
		});


		const Next_Add_New = document.createElement('button');
		container_Manu.appendChild(Next_Add_New);
		Next_Add_New.textContent = "Next Add New";
		//show_edit_container.style.backgroundColor = '#ff990094';
		//show_edit_container.style.top = '1px';
		//show_edit_container.style.laft = '1px';
		//show_edit_container.style.color = 'blue';
		//show_edit_container.style.width = '50px';
		//show_edit_container.style.height = '17px';
		//show_edit_container.style.position = 'absolute';
		//show_edit_container.style.display = 'flex';
		//show_edit_container.style.boxShadow = 'var(--box-shadow)';
		//show_edit_container.style.border = 'var(--border)';
		//show_edit_container.style.borderRadius = '1.5rem';

		
		const Next_Add_New_container = document.createElement('div');
		edit_container.appendChild(Next_Add_New_container);
		Next_Add_New_container.style.textAlign = 'center';
		Next_Add_New_container.style.boxShadow = 'var(--box-shadow)';
		Next_Add_New_container.style.border = 'var(--border)';
		Next_Add_New_container.style.borderRadius = '1.5rem';
		Next_Add_New_container.style.marginRight = 'auto';
		//Next_Add_New_container.style.position ='relative';
		Next_Add_New_container.style.justifyContent = 'center';
		Next_Add_New_container.style.gap = '5rem';
		//Next_Add_New_container.style.alignItems = 'center';
		Next_Add_New_container.style.alignContent = 'space-between';
		//Next_Add_New_container.style.flexWrap = 'wrap';
		Next_Add_New_container.style.height = '90%'; 

		Next_Add_New_container.style.display = 'flex';
		Next_Add_New_container.style.flexDirection = 'column';
		Next_Add_New_container.style.flexWrap = 'wrap';
		Next_Add_New_container.style.gap = '1.5rem';
		Next_Add_New_container.style.overflowX = 'auto';
		Next_Add_New_container.style.overflowY = 'hidden';
		Next_Add_New_container.style.width = '100%';
		Next_Add_New_container.style.height = 'auto';
		Next_Add_New_container.style.behavior = 'smooth';
		Next_Add_New_container.style.display = 'None';
		Next_Add_New_container.style.flexDirection = 'column';
		//Next_Add_New_container.style.flexWrap = 'wrap';

		Next_Add_New.addEventListener('click', (e) => {
			if(Next_Add_New.textContent == "Next Add New"){
				Next_Add_New.textContent = "Done";
				Next_Add_New_container.style.display = 'flex';
			}else if(Next_Add_New.textContent == "Done"){
				Next_Add_New.textContent = "Next Add New";
				Next_Add_New_container.style.display = 'None';
			}
		});

		btns.forEach(btn =>{
			// Check if title display is enabled
			const btn0 = document.createElement('button');
			Next_Add_New_container.appendChild(btn0);
			btn0.textContent = btn;
			btn0.style.backgroundColor = '#ff990094';
			btn0.style.fontSize = 'small';
			//btn0.style.laft = '1px';
			btn0.style.color = 'blue';
			btn0.addEventListener('click', (e) => {
				let index = Array.prototype.indexOf.call(parent_b.children, items_list_container);
				send_page_update(btn, index, []);
			});
		});
	}

	























	if(display_t_on > 0 || display_t_on == true){
		const title_t = document.createElement('h1');
		//title_t.classList.add('heading');
		title_t.textContent = title;
		items_list_container.appendChild(title_t);
	}
	
	const Items_Box = document.createElement('div');
	
	items_list_container.myfc = function fc(params) {
		if(window.globallist[id].def_search_info != "")window.globallist[id].def_search_info += ";"+params;
		else window.globallist[id].def_search_info += params;
		while (Items_Box.firstChild) Items_Box.removeChild(Items_Box.firstChild);
		while(window.globallist[id].data.length) window.globallist[id].data.pop(); // Remove the last item from the data array
		window.globallist[id].firstset = 0;
		window.globallist[id].lastset = 0;
		console.log("-----------------------------------------------------------/////params changed "+params);
		readhtmtable(Items_Box, id);
	};

	//"H-TABLE-LIST"
	//"V-TABLE-LIST"
	if(display_style){
		var dse = display_style.split("-");
		if (dse &&  dse[0] == "V"){
			// styling
			//Items_Box.style.textAlign = 'center';
			//Items_Box.style.boxShadow = 'var(--box-shadow)';
			//Items_Box.style.border = 'var(--border)';
			//Items_Box.style.borderRadius = '1.5rem';
			//Items_Box.style.marginRight = 'auto';
			//Items_Box.style.padding = '0.5rem';
			//Items_Box.style.position ='relative'; // off for search item to be on top
			Items_Box.style.justifyContent = 'center';
			//Items_Box.style.gap = '2rem';
			//Items_Box.style.alignItems = 'center';
			//Items_Box.style.alignContent = 'space-between';
			Items_Box.style.width = 'auto'; 
			Items_Box.style.height = '90%';
			Items_Box.style.display = 'flex';
			Items_Box.style.flexWrap = 'wrap';
			Items_Box.style.gap = '10.5rem 2.5rem';
			Items_Box.style.overflow = 'auto';
			console.log('going to save Scrolling Y......');
		}
		else {
			// styling
			if  (list_box_hight == "") items_list_container.style.height = "100%"; 
			Items_Box.style.textAlign = 'center';
			//Items_Box.style.boxShadow = 'var(--box-shadow)';
			//Items_Box.style.border = 'var(--border)';
			//Items_Box.style.borderRadius = '1.5rem';
			Items_Box.style.marginRight = 'auto';
			Items_Box.style.padding = '2rem';
			//Items_Box.style.position ='relative'; // off for search item to be on top
			Items_Box.style.justifyContent = 'center';
			Items_Box.style.gap = '2rem';
			Items_Box.style.alignItems = 'center';
			Items_Box.style.alignContent = 'space-between';
			//Items_Box.style.flexWrap = 'wrap';
			Items_Box.style.height = '90%'; 

			Items_Box.style.display = 'flex';
			Items_Box.style.flexDirection = 'column';
			Items_Box.style.flexWrap = 'wrap';
			Items_Box.style.gap = '1.5rem';
			Items_Box.style.overflowX = 'auto';
			Items_Box.style.overflowY = 'hidden';
			console.log('going to save Scrolling X......');
		}
	}
	items_list_container.appendChild(Items_Box);
	
	readhtmtable(Items_Box, id);

	Items_Box.addEventListener('scroll', function() { handle_itrms_box_Scroll(items_list_container, Items_Box, id)});
	//
}

//productGrid_container.addEventListener('scroll', handleScroll);
