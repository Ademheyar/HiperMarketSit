
function give_result_to_list(path, search_value) {
	var values = "";
	const result_box = document.querySelector(path);
	let items = result_box.children; // .querySelectorAll('*');
	for(var i=0; i < items.length; i++){
	   //item
	   if(items[i].classList.contains("List_container")){
			console.log('mian .item.classList '+items[i].classList);
			console.log('mian .item.value '+items[i].value);
			console.log('mian .item.id '+items[i].id);
			console.log('mian .item.tagName '+items[i].tagName);
			//console.log('mian items[i].myFunction ', items[i].myFunction());
			items[i].myfc(search_value);
			//let v = ;
			//console.log('going to save v .'+ v);
	   }
	}
	return values;
 }

function create_Search(parent_b, lists_container, search_what, search_weidth, search_height, title, display_t_on, select_show, select_type, select_weidth, select_height) {
  let selectedItems = [];
  let tempSelectedDocument = [];
  let tempSelectedUsers = [];
  let tempSelectedItems = [];
    
  
   let items_columens = ['id', 'name', 'code', 'type', 'barcode', 'at_shop', 'quantity', 'cost', 'tax', 'price', 'include_tax', 'price_change', 'more_info', 'images', 'description', 'service', 'default_quantity', 'active'];
   let shops_columens = ['Shop_Id', 'Shop_name', 'Shop_brand_name', 'shop_type', 'Shop_oweners_id', 'Shop_linke', 'shop_email', 'shop_phone_no', 'Shop_location', 'Shop_about', 'Shop_rate', 'Shop_likes', 'Shop_followers', 'Shop_items', 'Shop_workers', 'Shop_password', 'Shop_contry', 'Shop_settings', 'Shop_profile_img', 'Shop_banner_imgs', 'Shop_payment_r', 'Shop_balance', 'Shop_payment_info', 'Shop_isenable'];
   
   parent_b.style.backgroundColor = "white";
   parent_b.style.border = "1px solid #ddd";
   parent_b.style.borderRadius = "8px";
   parent_b.style.marginBottom = "2px";
   parent_b.style.alignItems = 'center';
	parent_b.style.alignContent = 'space-between';
   parent_b.style.padding = "0px";
   parent_b.style.boxShadow = "0 2px 4px rgba(0, 0, 0, 0.1)";
   
	const searchInput = document.createElement('input');
   searchInput.type = 'search'; 
   searchInput.autocapitalize = 'none'; 
   searchInput.autocomplete = 'none'; 
   searchInput.autocorrect = 'none'; 
   searchInput.placeholder = "Search...";
   
   
   if(display_t_on){
      searchInput.placeholder = title;
   }
   //searchInput.id = contenur_n;
	//searchInput.classList.add(contenur_n);
	//searchInput.style.gap = '1.5rem';
	//searchInput.style.justifyContent = 'left';
	//searchInput.style.overflowX = 'hidden';
	//searchInput.style.overflowY = 'hidden';
	//searchInput.style.marginRight = 'auto';
	searchInput.style.textAlign = 'center';
	searchInput.style.padding ='5px';
	//searchInput.style.boxShadow = 'var(--box-shadow)';
	searchInput.style.border = '1px solid #ccc';
	searchInput.style.borderRadius = '4px';
	//searchInput.style.alignItems = 'center';
	//searchInput.style.alignContent = 'space-between';
	//searchInput.style.position ='relative';
  searchInput.style.width = '100%';
  searchInput.style.height = '100%'; 
  //searchInput.style.boxSizing = "border-box";
            
	//if(search_height != "") searchInput.style.height = search_height; 
	//if(search_weidth != "") searchInput.style.width = search_weidth; 
   
   	parent_b.appendChild(searchInput);
   	
   if(select_type == 1)
   {

     const resulet_list = document.createElement('div');
     resulet_list.style.position = 'absolute';
     //resulet_list.style.width = '100%'
     resulet_list.style.height = '300px';
     resulet_list.style.backgroundColor = 'white';
     resulet_list.style.display = 'none';
     resulet_list.style.zIndex = "1"; 
     resulet_list.style.border = "1px solid #ddd";
     resulet_list.style.borderRadius = "8px";
     resulet_list.style.marginBottom = "20px";
     resulet_list.style.padding = "15px";
     resulet_list.style.boxShadow = "0 2px 4px rgba(0, 0, 0, 0.1)";
     resulet_list.style.marginRight = "0"; 
     parent_b.appendChild(resulet_list);          
   
     const resulet_ul = document.createElement('ul');
     resulet_ul.style.height = '100%';
     //resulet_ul.style.width = '100%';
     resulet_ul.style.overflowY = 'auto';
     resulet_ul.style.overflowX = 'hidden';
     //resulet_ul.style.left = "20px"; 
     //resulet_ul.style.zIndex = "1"; 
     resulet_ul.style.backgroundColor = 'white';
     //resulet_ul.style.border = "1px solid #ddd";
     //resulet_ul.style.borderRadius = "8px";
     //resulet_ul.style.marginBottom = "20px";
    // resulet_ul.style.padding = "15px";
     //resulet_ul.style.boxShadow = "0 2px 4px rgba(0, 0, 0, 0.1)";
     //resulet_ul.style.marginRight = "0"; 
     
     resulet_list.appendChild(resulet_ul);        
     
     const done_selecting_btn = document.createElement('button');
     //done_selecting_btn.style.display = 'None';
     done_selecting_btn.value = 'Done Qty : 0 And Price : 0 User : 0 Document : 0';
     done_selecting_btn.textContent = 'Done Qty : 0 And Price : 0 User : 0 Document : 0';
     done_selecting_btn.addEventListener('click', () => {
       var SelectedUsers = localStorage.getItem('SelectedUsers');
      SelectedUsers = !SelectedUsers ? [] :  JSON.parse(SelectedUsers);
		 tempSelectedUsers.forEach((selectedUser, sindex) => {
	   var newItem = {
		  id: selectedUser.id,
		  user_name: selectedUser.user.user_name,
		  user: selectedUser.user
	  };

	  SelectedUsers.push(newItem);
       });
     localStorage.setItem('SelectedUsers', JSON.stringify(SelectedUsers));

      var activeChartData = localStorage.getItem('ActiveChartData');
        var activeChartData = activeChartData ? JSON.parse(activeChartData) : [];
        
       var activeChartIndex = localStorage.getItem('activeChartIndex');
      activeChartIndex = !activeChartIndex || activeChartIndex < 0 || activeChartIndex >= activeChartData.length ? 0 : activeChartIndex;
          var payments = localStorage.getItem('Payment_Lists');
          var paymentList = payments ? JSON.parse(payments) : [];
		 
        var iscartData = activeChartData[activeChartIndex];
        var cartData = iscartData ? iscartData : [];

		 console.log("tempSelectedItems :", tempSelectedItems);		 
   tempSelectedItems.forEach((selectedItem, sindex) => {
         let ext = selectedItem.exinfo;
         ext.forEach((extvalue, extindex) => {
           var newItem = {
              id: selectedItem.id,
              name: selectedItem.item.name,
              price: selectedItem.price,
              Images: [],
              
              shop: extvalue[0],
              code: extvalue[1],
              color: extvalue[2],
              size: extvalue[3],
              quantity: extvalue[4],
			   tax:"",
			   barcode:"",
              
              discount: 0,
              Price: selectedItem.item.price,
              Quantity: extvalue[4],
			  ex_doc: ""
          };
          cartData.push(newItem);
         });
       });
	 
	 tempSelectedDocument.forEach((selectedDocument, sindex) => {
		 console.log("doc selectedDocument : ", selectedDocument);
		 let more_info = JSON.parse(selectedDocument.DOCUMENT.item);
		console.log("doc more_info : ", more_info);
		more_info.forEach((extvalue, extindex) => {
           var newItem = {
              id: extvalue[0],
              name: extvalue[3],
              price: extvalue[8],
              Images: [],
              
              shop: extvalue[4],
              code: extvalue[1],
              color: extvalue[5],
              size: extvalue[6],
              quantity: extvalue[7],
			   tax:extvalue[10],
			   barcode:extvalue[2],
              
              discount: extvalue[9],
              Price: extvalue[8],
              Quantity: extvalue[7],
			  ex_doc: selectedDocument.DOCUMENT.document_barcode
          };
		  console.log("doc newItem : ", newItem);
  
          cartData.push(newItem);
         });
		
		 let payments = JSON.parse(selectedDocument.DOCUMENT.payments);
		 console.log("doc payments : ", payments);

		   payments.forEach((extvalue, extindex) => {
			   
		  let newpayment = {
                name: extvalue[1],
                method: extvalue[2],
				Paid:extvalue[3],
                date: extvalue[4],
                expirydate: extvalue[5],
                updateddate: extvalue[6],
                user:extvalue[7],
				// ispayment tool marked as pid [8]
                isPaid: extvalue[9],  // Assuming all payments are marked as paid initially
                external_doc: selectedDocument.DOCUMENT.document_barcode
            };
		  console.log("doc newpayment : ", newpayment);
		   
		 paymentList.push(newpayment);
         });
		   
		   
		   
			   
		 //  
         /*let ext = selectedItem.exinfo;
         */
       });
		 console.log("activeChartIndex :", activeChartIndex);	
     activeChartData[activeChartIndex] = cartData;
    localStorage.setItem('activeChartIndex', activeChartIndex);
    console.log("activeChartData :", activeChartData);		 
      localStorage.setItem('ActiveChartData', JSON.stringify(activeChartData));
		 localStorage.setItem('Payment_Lists', JSON.stringify(paymentList));
      console.log("add_to_cart :", cartData);
      
      updte_chat_lenght();
      updateCartDisplay();
      searchInput.value = ''; // Clear the search text
      tempSelectedItems = [];
		  tempSelectedUsers = [];
		  tempSelectedDocument = [];
     resulet_list.style.display = 'none'; // Hide selling items
        });
        
     function update_total_info(){
       var tqty = 0;
       var tprice = 0;
       tempSelectedItems.forEach((selectedItem, sindex) => {
         let ext = selectedItem.exinfo;
         let sqty = 0;
         ext.forEach((extvalue, extindex) => {
           sqty += parseInt(extvalue[4]);
         });
         tqty += sqty;
         tprice += sqty * selectedItem.price;
       });
		 
       done_selecting_btn.textContent = 'Done Qty : ' + tqty + ' And Price : ' + tprice + ' ' + ' Users : ' + tempSelectedUsers.length + "Document : " + tempSelectedDocument.length;   
     }
     
     resulet_list.appendChild(done_selecting_btn);   
     
     const cancel_btn = document.createElement('button');
     //cancel_btn.style.display = 'None';
     cancel_btn.value = 'Cancel';
     cancel_btn.textContent = 'Cancel';
     cancel_btn.addEventListener('click', () => {
            searchInput.value = ''; // Clear the search text
            //renderSellingItems([]); // Hide selling items
            tempSelectedItems = []; // Reset temporary selected items
		 tempSelectedUsers=[];
    });
     resulet_list.appendChild(cancel_btn);   
     
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
        
     function toggleTempSelectedItem(item, index) {
            const itemIndex = tempSelectedItems.findIndex(i => i.name === item.name);
            if (itemIndex > -1) {
                tempSelectedItems.splice(itemIndex, 1);
            } else {
                const code = document.querySelectorAll('.code')[index].value;
                const color = document.querySelectorAll('.color')[index].value;
                const size = document.querySelectorAll('.size')[index].value;
                const qty = document.querySelectorAll('.combobox[type="number"]')[index].value;
                tempSelectedItems.push({ ...item, code, color, size, qty: parseInt(qty, 10) });
            }
        }
        
     function renderSellingItems(items) {
        
        console.log("renderSellingItems items ", items);
        items.forEach((result, index) => {
			if(result[0] == "DOCUMENT"){
				let document_r = result[1];
				const listItem = document.createElement("li");
		          listItem.style.display = "flex"; 
		          listItem.style.overflow = "hidden"; 
				  listItem.style.alignContent = 'space-evenly';
				  listItem.style.justifyContent  = 'flex-start';
				  listItem.style.borderBottom = "var(--border)";
			

          const productImage = document.createElement('img');
			productImage.style.width = '50px';
			productImage.style.height = '50px';
			//productImage.style.objectFit = 'cover'; // This ensures the image covers the entire box without stretching
			productImage.onerror = function() {
				this.src = 'Img/error1.jpg'; // Set the error image path
				//this.style.width = '100%'; // Set width to match original image
				//this.style.height = '100%'; // Set height to match original image
			};
			
          const checkbox = document.createElement("input");
          checkbox.type = "checkbox";
  			
  			  const info0 = document.createElement("div");
  			  info0.className = "document_r-info";
  			  info0.style.display = "block";

			
    			const info1 = document.createElement("div");
    			info1.className = "document_r-info";
    			info1.style.display = "block";
    			
    			const name = document.createElement("p");
    			name.textContent = 'Document  : '+document_r.document_barcode;
    			name.style.fontSize = "12px";
			    name.style.textOverflow = 'ellipsis';
			    name.style.width = '90%';
			    name.style.whiteSpace = 'nowrap';
			    name.style.overflow = 'hidden';
    
    
    			
				listItem.appendChild(productImage);
    			listItem.appendChild(checkbox);
    			listItem.appendChild(name);
    
    		  checkbox.addEventListener('click', () => {
    		    if(checkbox.checked == true){
      					let newdocumentinfo = {
      					  'doc_barocode' : document_r.id,
      					  'exinfo' : [],
      					  'DOCUMENT' : document_r
      					};
					tempSelectedDocument.push(newdocumentinfo);
					}
				  else {
	    		      tempSelectedDocument.forEach((selecteddocument, sindex) => {
		                if(selecteddocument.doc_barocode == document_r.doc_barocode){
		                  tempSelectedDocument.splice(sindex, 1);
		                  //break;
		                }
	    		      });
	    		    }
				update_total_info();
				});
				resulet_ul.appendChild(listItem);
				update_total_info();
			}
			if(result[0] == "USER"){
				let user_r = result[1];
				const listItem = document.createElement("li");
		          listItem.style.display = "flex"; 
		          listItem.style.overflow = "hidden"; 
				  listItem.style.alignContent = 'space-evenly';
				  listItem.style.justifyContent  = 'flex-start';
				  listItem.style.borderBottom = "var(--border)";
			

          const productImage = document.createElement('img');
			productImage.style.width = '50px';
			productImage.style.height = '50px';
			//productImage.style.objectFit = 'cover'; // This ensures the image covers the entire box without stretching
			productImage.onerror = function() {
				this.src = 'Img/error1.jpg'; // Set the error image path
				//this.style.width = '100%'; // Set width to match original image
				//this.style.height = '100%'; // Set height to match original image
			};
			
          const checkbox = document.createElement("input");
          checkbox.type = "checkbox";
  			
  			  const info0 = document.createElement("div");
  			  info0.className = "user_r-info";
  			  info0.style.display = "block";

			
    			const info1 = document.createElement("div");
    			info1.className = "user_r-info";
    			info1.style.display = "block";
    			
    			const name = document.createElement("p");
    			name.textContent = `${user_r.user_name}`;
    			name.style.fontSize = "12px";
			    name.style.textOverflow = 'ellipsis';
			    name.style.width = '90%';
			    name.style.whiteSpace = 'nowrap';
			    name.style.overflow = 'hidden';
    			const Barcode_lable = document.createElement("p");
    			Barcode_lable.textContent = `Barcode`;
    			Barcode_lable.style.fontSize = "7px";
    
    			
    			const info2 = document.createElement("div");
    			info2.className = "user_r-info";
    			info2.style.display = "flex";
    
    			
    			const info3 = document.createElement("div");
    			info3.className = "user_r-info";
    			info3.style.display = "block";
    			
    		    const itemtotalpricelabel = document.createElement('p');
    			itemtotalpricelabel.textContent = 'User Name : '+user_r.user_name;
    			itemtotalpricelabel.style.fontSize = "10px";
    			
				listItem.appendChild(productImage);
    			listItem.appendChild(checkbox);
    			listItem.appendChild(info0);
    
    			info0.appendChild(info1);
    			info1.appendChild(name);
    			
    			info0.appendChild(info2);
    			
    			info2.appendChild(info3);
    			info3.appendChild(itemtotalpricelabel);
    		  checkbox.addEventListener('click', () => {
    		    if(checkbox.checked == true){
      					let newuserinfo = {
      					  'id' : user_r.id,
      					  'exinfo' : [],
      					  'user' : user_r
      					};
					tempSelectedUsers.push(newuserinfo);
					}
				  else {
	    		      tempSelectedUsers.forEach((selecteduser, sindex) => {
		                if(selecteduser.id == user_r.id){
		                  tempSelectedUsers.splice(sindex, 1);
		                  //break;
		                }
	    		      });
	    		    }
				update_total_info();
				});
				resulet_ul.appendChild(listItem);
				update_total_info();
			}
			
			if(result[0] == "ITEM"){
				
			let item = result[1];
	          const listItem = document.createElement("li");
	          listItem.style.display = "flex"; 
	          listItem.style.overflow = "hidden"; 
			  listItem.style.alignContent = 'space-evenly';
			  listItem.style.justifyContent  = 'flex-start';
			  listItem.style.borderBottom = "var(--border)";
				
	
	          const productImage = document.createElement('img');
				productImage.style.width = '50px';
				productImage.style.height = '50px';
				//productImage.style.objectFit = 'cover'; // This ensures the image covers the entire box without stretching
				productImage.onerror = function() {
					this.src = 'Img/error1.jpg'; // Set the error image path
					//this.style.width = '100%'; // Set width to match original image
					//this.style.height = '100%'; // Set height to match original image
				};
				
	          const checkbox = document.createElement("input");
	          checkbox.type = "checkbox";
	  			
	  			  const info0 = document.createElement("div");
	  			  info0.className = "item-info";
	  			  info0.style.display = "block";
	
				
	    			const info1 = document.createElement("div");
	    			info1.className = "item-info";
	    			info1.style.display = "block";
	    			
	    			const name = document.createElement("p");
	    			name.textContent = `${item.name}`;
	    			name.style.fontSize = "12px";
				    name.style.textOverflow = 'ellipsis';
				    name.style.width = '90%';
				    name.style.whiteSpace = 'nowrap';
				    name.style.overflow = 'hidden';
	    			const Barcode_lable = document.createElement("p");
	    			Barcode_lable.textContent = `Barcode`;
	    			Barcode_lable.style.fontSize = "7px";
	    
	    			
	    			const info2 = document.createElement("div");
	    			info2.className = "item-info";
	    			info2.style.display = "flex";
	    
	    			
	    			const info3 = document.createElement("div");
	    			info3.className = "item-info";
	    			info3.style.display = "block";
	    			
	    		    const itemtotalpricelabel = document.createElement('p');
	    			itemtotalpricelabel.textContent = 'Price : '+item.price;
	    			itemtotalpricelabel.style.fontSize = "10px";
	    			
					listItem.appendChild(productImage);
	    			listItem.appendChild(checkbox);
	    			listItem.appendChild(info0);
	    
	    			info0.appendChild(info1);
	    			info1.appendChild(name);
	    			
	    			info0.appendChild(info2);
	    			
	    			info2.appendChild(info3);
	    			info3.appendChild(itemtotalpricelabel);
	    		  checkbox.addEventListener('click', () => {
	    		    if(checkbox.checked == true){
	      	      let loaded_info =  JSON.parse(item.more_info);
	      	      
	      				if(loaded_info && loaded_info.length > 0){
	      					let newinfo = {
	      					  'id' : item.id,
	      					  'price' : item.price,
	      					  'loaded_info' : loaded_info,
	      					  'exinfo' : [],
	      					  'item' : item
	      					};
	      					tempSelectedItems.push(newinfo);
	      					const editInfo = document.createElement("div");
	      					editInfo.className = "item-info";
	      					editInfo.style.display = "flex";
	      					//editInfo.style.justifyContent = 'center';
	      					//editInfo.style.alignItems = 'center';
	      					//editInfo.style.alignContent = 'space-between';
	      					//sellingInfosList.style.flexWrap = 'wrap';
	      					editInfo.style.flexDirection = 'row';
	      					editInfo.style.flexWrap = 'wrap';
					        editInfo.style.gap = "1px";
	      					const shopSelect = document.createElement("select");
	      					shopSelect.value = item.shop;
	      					const codeSelect = document.createElement("select");
	      					codeSelect.value = item.code;
	      					const colorSelect = document.createElement("select");
	      					colorSelect.value = item.color;
	      					const sizeSelect = document.createElement("select");
	      					sizeSelect.value = item.size;
	      					const qtyInputlabel = document.createElement('p');
	      					qtyInputlabel.textContent = "QTY : \nLeft : ?";
	      					qtyInputlabel.style.fontSize = "10px";
					        qtyInputlabel.style.display = "flex"; 
					        qtyInputlabel.style.gap = "5px";
							qtyInputlabel.style.alignItems = 'baseline';
	      					qtyInputlabel.style.alignContent = 'space-between';
	      					const qtyInput = document.createElement("input");
	      					qtyInput.type = "number";
	      					qtyInput.value = 1;
	      					qtyInput.style.width = "50px";
	      					qtyInput.min = 1
	      					
	      					const Add_info_btn = document.createElement('button');
	                 //Add_info_btn.style.display = 'None';
	                 Add_info_btn.value = 'Add';
	                 Add_info_btn.textContent = 'Add';
					 Add_info_btn.style.backgroundColor = 'green';
					 Add_info_btn.style.color = 'white';
					Add_info_btn.style.border = 'none';
					Add_info_btn.style.borderRadius = '4px';
					Add_info_btn.style.cursor = 'pointer';
					Add_info_btn.style.padding = '5px 10px';
	                 Add_info_btn.addEventListener('click', () => {
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
	                });
	              				
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
							
	                 remove_info_btn.addEventListener('click', () => {
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
	      								snames[sn] = loaded_info[sn][0];
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
	      					/*itemprice.addEventListener('input', (e) => {
	      						itemtotalprice.value = (parseInt(itemprice.value) * parseInt(qtyInput.value));
	      					});    */  
	      					
	      					
	      					get_next_value(shopSelect.value, codeSelect.value, colorSelect.value, sizeSelect.value);
	      					editInfo.appendChild(shopSelect);
	      					editInfo.appendChild(codeSelect);
	      					editInfo.appendChild(colorSelect);
	      					editInfo.appendChild(sizeSelect);
	      					editInfo.appendChild(qtyInputlabel);
	      					qtyInputlabel.appendChild(qtyInput);
	      					editInfo.appendChild(Add_info_btn);
	      					editInfo.appendChild(remove_info_btn);
	      					
	                 
	      					//editInfo.appendChild(itempricelabel);
	      					//itempricelabel.appendChild(itemprice);
	      					
	      					info3.appendChild(Barcode_lable);
	      					info2.appendChild(editInfo);
	      					//listItem.selecters = [shopSelect, codeSelect, colorSelect, sizeSelect, qtyInput];
	      				}
	  			      //updateSelectedItemProperty(shopSelect);
	    		    }
	    		    else {
	    		      tempSelectedItems.forEach((selectedItem, sindex) => {
	                if(selectedItem.id == item.id){
	                  tempSelectedItems.splice(sindex, 1);
	                  //break;
	                }
	    		      });
	    		      if(info2.children.length > 1){
	    		      info2.removeChild(info2.children[1]);
	    		      }
	    		    }
	    		    update_total_info();
	  	      });
				resulet_ul.appendChild(listItem);
				update_total_info();
   }
			
		});
    }
    
   const Items_Box = document.createElement('div');
   Items_Box.style.display = 'None';

	searchInput.addEventListener("input", function(){
      let searchQuery = this.value.trim();
      let searchresults = resulet_list;
    
      if(searchQuery.length > 0){
         resulet_list.style.display = 'grid';
         var datasent = 'Search_Like_Query=Search_Like_Query&Search_Query_value=' + searchQuery + '&search_what=' + search_what + '&limit=100';
            // Make an AJAX request to your PHP API
        //console.log(datasent);
		  resulet_ul.innerHTML = '';
        sendAjaxRequest('server/Products/Product.php', 'POST', datasent, function(responseText) {
               //console.log(responseText + '<< responsesearch');
               var response = JSON.parse(responseText);
               renderSellingItems(response.result);
		        if(response.result.length ) resulet_list.style.display = 'block';
        }, function(errorStatus) { console.log('Error: ' + errorStatus);});

		  
		// Make an AJAX request to your PHP API
        //console.log(datasent);
        sendAjaxRequest('server/Documents/Document.php', 'POST', datasent, function(responseText) {
               //console.log(responseText + '<< responsesearch');
               var response = JSON.parse(responseText);
               renderSellingItems(response.result);
              if(response.result.length ) resulet_list.style.display = 'block';
        }, function(errorStatus) { console.log('Error: ' + errorStatus);});
      }
      else{
         resulet_list.style.display = 'none';
         //give_result_to_list(lists_container, get_search_vlaues());
      }
   });
   }
  else 
  {
     const resulet_list = document.createElement('div');
     resulet_list.style.position = 'absolute';
     resulet_list.style.width = '45%';
     resulet_list.style.height = '50%';
     resulet_list.style.backgroundColor = 'white';
     resulet_list.style.display = 'none';
     resulet_list.style.overflowY = 'auto';
     
  
    parent_b.appendChild(resulet_list);          
     
     const Items_Box = document.createElement('div');
     Items_Box.style.display = 'None';
  
     function get_search_vlaues() {
        var values = ""
        let items = Items_Box.querySelectorAll('*');
        items.forEach(function(item) {
           //item
           if(values == "") values = item.textContent;
           else values = values+";"+item.textContent;
        });
        return values;
     }
  
     if(select_show){
        parent_b.appendChild(Items_Box);
        Items_Box.style.gap = '1.5rem';
        Items_Box.style.justifyContent = 'left';
        Items_Box.style.overflowX = 'hidden';
        Items_Box.style.overflowY = 'hidden';
        Items_Box.style.marginRight = 'auto';
        Items_Box.style.textAlign = 'center';
        //Items_Box.style.padding ='5px 15px';
        //Items_Box.style.boxShadow = 'var(--box-shadow)';
        //Items_Box.style.border = '1px solid #ccc';
        //Items_Box.style.borderRadius = '20px';
        Items_Box.style.alignItems = 'center';
        Items_Box.style.alignContent = 'space-between';
        Items_Box.style.width = '100%';
  
        // styling
        Items_Box.style.textAlign = 'center';
        Items_Box.style.marginRight = 'auto';
        Items_Box.style.position ='static';
        Items_Box.style.justifyContent = 'center';
        Items_Box.style.gap = '5rem';
        Items_Box.style.alignItems = 'center';
        Items_Box.style.alignContent = 'space-between';
        //Items_Box.style.flexWrap = 'wrap';
        Items_Box.style.flexDirection = 'column';
        Items_Box.style.flexWrap = 'wrap';
        Items_Box.style.gap = '1.5rem';
        Items_Box.style.overflowX = 'auto';
        Items_Box.style.overflowY = 'hidden';
        console.log('going to save Scrolling X......');
        Items_Box.style.textAlign = 'center';
        Items_Box.style.marginRight = 'auto';
        Items_Box.style.justifyContent = 'center';
        Items_Box.style.gap = '5rem';
        Items_Box.style.alignItems = 'center';
        Items_Box.style.alignContent = 'space-between';
        Items_Box.style.width = '100%'; 
        Items_Box.style.height = '50%'; 
        Items_Box.style.display = 'flex';
        Items_Box.style.gap = '1.5rem';
        Items_Box.style.overflow = 'auto';
        
        if(select_height != "") Items_Box.style.height = select_height; 
        if(select_weidth != "") Items_Box.style.width = select_weidth;
  
     }
     
  	searchInput.addEventListener("input", function(){
        let searchQuery = this.value.trim();
        let searchresults = resulet_list;
        
        
        function display(results){
           let srearResults = resulet_list
           srearResults.innerHTML = '';
           results.forEach(result => {
              let item = document.createElement('div');
              item.style.fontSize = 'medium';
              item.textContent = result;
              item.addEventListener("click", function() {
                 if(this.style.backgroundColor != "blue") this.style.backgroundColor = "blue";
                 else{
                    if(searchInput.value.includes(':')){
                       let value = searchInput.value.split(':');
                       const Btn = document.createElement('button');
                       Items_Box.appendChild(Btn);
                       Btn.textContent = value[0]+":"+this.textContent;
                       Btn.addEventListener("click", function(){
                          if(this.style.backgroundColor != "red") this.style.backgroundColor = "red";
                          else{
                             this.parentNode.removeChild(this);
                          }
                       });
                       Btn.style.textAlign = 'center';
                       Btn.style.width = 'auto'; // = 'auto-fit'; 
                       Btn.style.height = '99%'; 
                       Btn.style.border = 'var(--border)';
                       Btn.style.overflow = 'hidden';
                       //Btn.style.border = '1px solid #ccc';
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
                       Btn.style.color = 'blue';
                       Btn.style.padding = '12px 24px';
                       Btn.style.fontSize = '10px';
                       Btn.style.cursor = 'pointer';
                       Btn.style.borderRadius = '8px';
                       Btn.style.transition = 'background-color 0.3s ease';
                       searchInput.value = "";
                       resulet_list.style.display = 'none';
  
                       give_result_to_list(lists_container, get_search_vlaues());
                    }
                    else { searchInput.value = this.textContent+":"; resulet_list.style.display = 'none';}
                 }
              });
              srearResults.appendChild(item);
           });
        }
  
        if(searchQuery.length > 0){
           resulet_list.style.display = 'grid';
           let dt = [];
           if(searchQuery.includes(':')){
              let q = searchQuery.split(':');
              var url = 'get_search.php'; // The PHP script that fetches items from the database
  
              var datasent = 'Type=' + q[0] + '&query=' + q[1]+ '&limit=100';
              // Make an AJAX request to your PHP API
              //console.log(datasent);
              sendAjaxRequest(url, 'POST', datasent, function(responseText) {
                 console.log(responseText + '<< responsesearch');
                 var response = JSON.parse(responseText);
                 items = response.items;
                 //console.log(items);
                 ra = response.a;
                 // Process the response and add the items to the itemContainer
                 for (var i = 0; i < items.length; i++) {
                    dt.push(items[i]); 
                 }
                 display(dt);
              }, function(errorStatus) { console.log('Error: ' + errorStatus);});
           }
           else{
  			dt = shops_columens.concat(items_columens).filter(item => item.includes(searchQuery));
              display(dt);
           }
           //console.log("out fetchresult");
        }
        else{
           resulet_list.style.display = 'none';
           give_result_to_list(lists_container, get_search_vlaues());
        }
     });
  }
  
}

//productGrid_container.addEventListener('scroll', handleScroll);
