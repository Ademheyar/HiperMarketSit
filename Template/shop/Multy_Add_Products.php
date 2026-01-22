<?php

   // TODO: price include tax and allowe price change is not working tinke about it
   // TODO: 
   // TODO: what if it is update $p_shop
   // TODO: how what to fill this $p_qty
   if(file_exists("config.php")) include("config.php");
   if(file_exists("../../config.php")) include("../../config.php");
   if(session_id() == "") { session_start(); }


?>
<div class="add_container">
   <section>
   <form class="add-product-form" enctype="multipart/form-data"  method="POST">
      <?php if(session_id() == "") { session_start(); } ?>
      <h3 name="hh3">Multy Add products Form</h3>
      <!--required-->
      <div class="input_table">
         <input type="hidden" name="p_id" class="p_id">
         <div id='Multy_Add_Lists' class='stepform-class'>
            
         </div>
         <button type='button'onclick='Add_new_Form();'class='add_form_btn'>Add</button> 
         <button type='button'onclick='Done_Form();' name="add_product" class='dobtn'>Add All products</button>
         <input type="hidden" value="Add product" name="product_do" class="product_do">
      </div>
      <h3>  </h3>
      <h3><?php echo "\n\n\n"; ?></h3>
      <h3><?php echo "\n\n\n"; ?></h3>
   </form>

   </section>
</div>


<script>
   let Multy_new_productes = [];
   function Done_Form() {
      // frame, new_p_name, new_p_code, p_barcode, p_qty, p_price_sale, p_price_cost, p_disc, p_type, p_active_l, p_change_allowed_l, p_Def_qty
      for(var i = 0; i < Multy_new_productes.length; i++){
         const new_p = Multy_new_productes[i];

         const p_more_info = "";
         let type_s = [];
         let created_type_infos = [];
         if(new_p[4].value && new_p[4].value != "") type_s = JSON.parse(new_p[4].value);
   
         if(type_s == []) created_type_infos = [["", new_p[3].value, new_p[8].value, new_p[6].value, new_p[6].value, "", "", "", "", "", ""]]; 
         else {
            const each_sale_price =   (new_p[8].value)/type_s.length;
            for(let ts=0; ts < type_s.length; ts++){
               // TODO : give deffrent barcode for earch item or same
               created_type_infos.push([type_s[ts], new_p[3].value, each_sale_price, new_p[6].value, new_p[6].value, "", "", "", "", "", ""]);
            }
         }
         let more_info_for = [];
         <?php 
            if ($_SESSION['selected_company_id'] != -1){ 
               $shop = $_SESSION['User_Shops'][$_SESSION['selected_company_id']];?>
               
               const shop_id = '<?php echo $shop['Shop_Id']; ?>';
               const shop_name = '<?php echo $shop['Shop_name']; ?>';
               
               more_info_for.push([shop_id, shop_name, [[shop_name, [[new_p[2].value, [["Def_Color", [["Def_Size", created_type_infos]]]]]]]]]);
            <?php } else {
            foreach ($_SESSION['User_Shops'] as $shop) { ?>         
               const shop_id = '<?php echo $shop['Shop_Id']; ?>';
               const shop_name = '<?php echo $shop['Shop_name']; ?>';
                                                        
               more_info_for.push([shop_id, shop_name, [[shop_name, [[new_p[2].value, [["Def_Color", [["Def_Size", created_type_infos]]]]]]]]]);
         <?php } 
            }
         ?>

         for(let m = 0; m < more_info_for.length; m++){
            
         let formData = new FormData();
            formData.append('add', 'add');
            formData.append('dataobject', {});
            formData.append('product_do', 'Add product');
   
            formData.append('new_p_name', new_p[1].value); // new_p_name
            formData.append('new_p_code', new_p[2].value); // new_p_code
            formData.append('p_barcode', new_p[3].value); // p_barcode
            formData.append('new_p_type', new_p[4].value); // p_type
            formData.append('p_disc', new_p[5].value); // $p_disc
            formData.append('p_qty', new_p[6].value); // $p_qty
            formData.append('p_price_cost', new_p[7].value); // p_price_cost
            formData.append('p_price_sale', new_p[8].value); // p_price_sale
            
            formData.append('p_active', new_p[9].value); // p_active
            formData.append('p_change_allowed', new_p[10].value); // p_change_allowed
            formData.append('p_Def_qty', new_p[11].value); // p_Def_qty
   
            
            //formData.append('p_Service', new_p[12].value); // p_Service
            formData.append('p_more_info', JSON.stringify(more_info_for[m][2])); // p_more_info
            
            console.log('more_info_for[m]  :', more_info_for[m][2]);
            console.log('formData.append  :', formData);
            
            fetch('../../server/Products/Product.php', {
               method: 'POST',
               body: formData
            })
            .then(response => response.json())
            .then(data => {
               console.log("0 fetched data", data);
               if (data.result) {
                  // todo cear new added item
               } else alert("Errormulty_add_product 0data1: " + error);
            })
            .catch(error => {
               fetch('../server/Products/Product.php', {
                  method: 'POST',
                  body: formData
               })
               .then(response => response.json())
               .then(data => {
                  console.log("1 fetched data", data);
                  if (data.result) {
                     // todo cear new added item
                  } else alert("Errormulty_add_product 0data1: " + error);
               })
               .catch(error => {
                  fetch('server/Products/Product.php', {
                     method: 'POST',
                     body: formData
                  })
                  .then(response => response.json())
                  .then(data => {
                     console.log("2 fetched data", data);
                     if (data.result) {
                        // todo cear new added item
                     } else alert("Errormulty_add_product 0data1: " + error);
                  })
                  .catch(error => {
                     console.error("Errormulty_add_product 0file1: ", error);
                     alert("Errormulty_add_product 0file1: " + error);
                  });
               });
            });



            
         }
      }
   }
   
   function Add_new_Form()
   {
      const add_btn = document.querySelector('.Multy_New_form .add_container .add-product-form .input_table .add_form_btn');
      const Multy_Add_Lists = document.querySelector('#Multy_Add_Lists');
      
      const Multy_Add_Form = document.createElement('div');
      Multy_Add_Form.style.left = '0%';
      Multy_Add_Form.style.color = 'white';
      Multy_Add_Form.style.display = 'inline-flex';
      Multy_Add_Form.style.gap = '2.25rem';
      Multy_Add_Form.style.padding = '1.2rem 1.4rem';
      Multy_Add_Form.style.borderRadius = '2.5rem';
      //Multy_Add_Form.style.overflowX = 'scroll';
      Multy_Add_Lists.appendChild(Multy_Add_Form);
      
      const Buttons_muly_Add_Form = document.createElement('div');
      Buttons_muly_Add_Form.style.left = '0%';
      Buttons_muly_Add_Form.style.color = 'white';
      Buttons_muly_Add_Form.style.display = 'grid';
      Buttons_muly_Add_Form.style.gap = '1.25rem';
      Buttons_muly_Add_Form.style.padding = '1.2rem 1.4rem';
      //Buttons_muly_Add_Form.style.overflowX = 'scroll';
      Buttons_muly_Add_Form.textContent = 'Buttons_muly_Add_Form';
      Multy_Add_Form.appendChild(Buttons_muly_Add_Form);
      
      const Remove_add_form = document.createElement('button');
      Remove_add_form.textContent = 'x';
      Remove_add_form.style.marginLeft = '5px';
      Remove_add_form.style.border = 'none';
      Remove_add_form.style.color = 'red';
      Remove_add_form.addEventListener('click', function() {
         Multy_Add_Form.remove();
         // TODO : even remove it from list of products
         
      });
      Buttons_muly_Add_Form.appendChild(Remove_add_form);

      const copy_add_form = document.createElement('button');
      copy_add_form.textContent = 'Copy';
      copy_add_form.style.marginLeft = '5px';
      copy_add_form.style.border = 'none';
      copy_add_form.style.color = 'blue';
      copy_add_form.addEventListener('click', function() {
         Multy_Add_Form.remove();
         // TODO : even remove it from list of products
         
      });
      Buttons_muly_Add_Form.appendChild(copy_add_form);

      const new_p_name = document.createElement('input');
      new_p_name.type = 'text';
      new_p_name.name = 'new_p_name';
      new_p_name.id = 'item_name';
      new_p_name.value = '';
      new_p_name.placeholder = 'product name';
      new_p_name.class = 'box p_name';
      new_p_name.style.width = '250px';
      new_p_name.style.textTransform = 'none';
      new_p_name.style.padding = '1.2rem 1.4rem';
      new_p_name.style.borderRadius = '2.5rem';
      new_p_name.style.color = 'var(--black)';
      new_p_name.style.backgroundColor = 'var(--white)';
      new_p_name.style.margin = '1rem 0';
      Multy_Add_Form.appendChild(new_p_name);

      const new_p_code = document.createElement('input');
      new_p_code.type = 'text';
      new_p_code.name = 'new_p_code';
      new_p_code.id = 'item_name';
      new_p_code.value = '';
      new_p_code.placeholder = 'product Code';
      new_p_code.class = 'box p_name';
      new_p_code.style.width = '250px';
      new_p_code.style.textTransform = 'none';
      new_p_code.style.padding = '1.2rem 1.4rem';
      new_p_code.style.borderRadius = '2.5rem';
      new_p_code.style.color = 'var(--black)';
      new_p_code.style.backgroundColor = 'var(--white)';
      new_p_code.style.margin = '1rem 0';
      Multy_Add_Form.appendChild(new_p_code);

      const p_barcode = document.createElement('input');
      p_barcode.type = 'text';
      p_barcode.name = 'p_barcode';
      p_barcode.id = 'item_name';
      p_barcode.value = '';
      p_barcode.placeholder = 'product Barcode';
      p_barcode.class = 'box p_name';
      p_barcode.style.width = '250px';
      p_barcode.style.textTransform = 'none';
      p_barcode.style.padding = '1.2rem 1.4rem';
      p_barcode.style.borderRadius = '2.5rem';
      p_barcode.style.color = 'var(--black)';
      p_barcode.style.backgroundColor = 'var(--white)';
      p_barcode.style.margin = '1rem 0';
      Multy_Add_Form.appendChild(p_barcode);
      
      const p_qty = document.createElement('input');
      p_qty.type = 'number';
      p_qty.name = 'p_qty';
      p_qty.id = 'item_name';
      p_qty.value = '';
      p_qty.min="0";
      p_qty.placeholder = 'product QTY';
      p_qty.class = 'box p_qty';
      p_qty.style.width = '150px';
      p_qty.style.textTransform = 'none';
      p_qty.style.padding = '1.2rem 1.4rem';
      p_qty.style.borderRadius = '2.5rem';
      p_qty.style.color = 'var(--black)';
      p_qty.style.backgroundColor = 'var(--white)';
      p_qty.style.margin = '1rem 0';
      Multy_Add_Form.appendChild(p_qty);
      
      //<input type="hidden" name="old_p_name" class="old_p_name">
      
      const p_price_cost = document.createElement('input');
      p_price_cost.type = 'number';
      p_price_cost.name = 'p_price_cost';
      p_price_cost.id = 'item_name';
      p_price_cost.value = '';
      p_price_cost.min="0";
      p_price_cost.placeholder = 'product cost';
      p_price_cost.class = 'box p_price_cost';
      p_price_cost.style.width = '150px';
      p_price_cost.style.textTransform = 'none';
      p_price_cost.style.padding = '1.2rem 1.4rem';
      p_price_cost.style.borderRadius = '2.5rem';
      p_price_cost.style.color = 'var(--black)';
      p_price_cost.style.backgroundColor = 'var(--white)';
      p_price_cost.style.margin = '1rem 0';
      Multy_Add_Form.appendChild(p_price_cost);

      
      const p_price_sale = document.createElement('input');
      p_price_sale.type = 'number';
      p_price_sale.name = 'p_price_sale';
      p_price_sale.id = 'item_name';
      p_price_sale.value = '';
      p_price_sale.min="0";
      p_price_sale.placeholder = 'product Sale price';
      p_price_sale.class = 'box p_price_sale';
      p_price_sale.style.width = '150px';
      p_price_sale.style.textTransform = 'none';
      p_price_sale.style.padding = '1.2rem 1.4rem';
      p_price_sale.style.borderRadius = '2.5rem';
      p_price_sale.style.color = 'var(--black)';
      p_price_sale.style.backgroundColor = 'var(--white)';
      p_price_sale.style.margin = '1rem 0';
      Multy_Add_Form.appendChild(p_price_sale);
      
      const multy_search_box = document.createElement('div');
      multy_search_box.style.left = '0%';
      multy_search_box.style.color = 'white';
      multy_search_box.style.gap = '2.25rem';
      multy_search_box.classList.add('multy_search_box');
      Multy_Add_Form.appendChild(multy_search_box);

      const p_disc = document.createElement('input');
      p_disc.type = 'text';
      p_disc.name = 'p_disc';
      p_disc.id = 'item_name';
      p_disc.value = '';
      p_disc.placeholder = 'product description';
      p_disc.class = 'box_1 p_disc';
      p_disc.style.width = '250px';
      p_disc.style.textTransform = 'inherit';
      //p_disc.style.padding = '6.1rem 3.1rem';
      p_disc.style.borderRadius = '2.5rem';
      p_disc.style.color = 'var(--black)';
      p_disc.style.backgroundColor = 'var(--white)';
      p_disc.style.margin = '1rem 0';
      Multy_Add_Form.appendChild(p_disc);


      const search_box_input = document.createElement('div');
      search_box_input.style.left = '0%';
      search_box_input.style.color = 'white';
      search_box_input.style.display = 'none';
      search_box_input.style.gap = '2.25rem';
      search_box_input.classList.add('search_box_input');
      multy_search_box.appendChild(search_box_input);

      const p_type = document.createElement('input');
      p_type.type = 'hidden';
      p_type.name = 'new_p_type';
      p_type.id = 'item_name';
      p_type.placeholder = 'product type';
      p_type.class = 'box p_type';
      p_type.style.padding = '1.2rem 1.4rem';
      p_type.style.borderRadius = '2.5rem';
      p_type.style.color = 'var(--black)';
      p_type.style.backgroundColor = 'var(--white)';
      p_type.style.margin = '1rem 0';
      search_box_input.appendChild(p_type);
      
      const p_type_box = document.createElement('input');
      p_type_box.type = 'text';
      p_type_box.name = 'p_type_box';
      p_type_box.id = 'item_name';
      p_type_box.value = '';
      p_type_box.placeholder = 'product type';
      p_type_box.class = 'box p_type_box';
      p_type_box.style.padding = '1.2rem 1.4rem';
      p_type_box.style.borderRadius = '2.5rem';
      p_type_box.style.color = 'var(--black)';
      p_type_box.style.backgroundColor = 'var(--white)';
      p_type_box.style.margin = '1rem 0';
      search_box_input.appendChild(p_type_box);

      const results = document.createElement('ul');
      results.classList.add('results');
      multy_search_box.appendChild(results);

      const search_box_results = document.createElement('div');
      search_box_results.style.width = 'auto';
      search_box_results.style.color = 'white';
      search_box_results.style.display = 'inline-flex';
      search_box_results.style.gap = '2.25rem';
      search_box_results.classList.add('search_box_results');
      multy_search_box.appendChild(search_box_results);

      
      const search_box_button = document.createElement('input');
      search_box_button.type = 'button';
      search_box_button.name = 'search_box_button';
      search_box_button.value = 'Add Type';
      search_box_button.class = 'btn search_box_button';
      search_box_button.style.width = '150px';
      search_box_button.style.textTransform = 'none';
      search_box_button.style.padding = '1.2rem 1.4rem';
      search_box_button.style.borderRadius = '2.5rem';
      search_box_button.style.color = 'var(--black)';
      search_box_button.style.backgroundColor = 'var(--white)';
      search_box_button.style.margin = '1rem 0';
      multy_search_box.appendChild(search_box_button);
      
      const p_active_l = document.createElement('label');
      p_active_l.class = 'toggle';
      p_active_l.style.color = 'black';
      p_active_l.style.fontSize = 'medium';
      p_active_l.textContent = 'Active';
      Multy_Add_Form.appendChild(p_active_l);

      const p_active = document.createElement('input');
      p_active.type = 'checkbox';
      p_active.name = 'p_active';
      p_active.id = 'item_name';
      p_active.class = 'checkbox p_active';
      p_active.style.width = '100%';
      p_active_l.appendChild(p_active);

      const p_change_allowed_l = document.createElement('label');
      p_change_allowed_l.class = 'toggle';
      p_change_allowed_l.style.color = 'black';
      p_change_allowed_l.style.fontSize = 'medium';
      p_change_allowed_l.textContent = 'price change allowed';
      Multy_Add_Form.appendChild(p_change_allowed_l);
      
      const p_change_allowed = document.createElement('input');
      p_change_allowed.type = 'checkbox';
      p_change_allowed.name = 'p_change_allowed';
      p_change_allowed.id = 'item_name';
      p_change_allowed.class = 'checkbox p_change_allowed';
      p_change_allowed.style.width = '100%';
      p_change_allowed_l.appendChild(p_change_allowed);
      
      const p_Def_qty_l = document.createElement('label');
      p_Def_qty_l.class = 'toggle';
      p_Def_qty_l.style.color = 'black';
      p_Def_qty_l.style.fontSize = 'medium';
      p_Def_qty_l.textContent = 'Default quantity';
      Multy_Add_Form.appendChild(p_Def_qty_l);

      const p_Def_qty = document.createElement('input');
      p_Def_qty.type = 'checkbox';
      p_Def_qty.name = 'p_Def_qty';
      p_Def_qty.id = 'item_name';
      p_Def_qty.class = 'checkbox p_Def_qty';
      p_Def_qty.style.width = '100%';
      p_Def_qty_l.appendChild(p_Def_qty);


      // Add a new div with a remove button and update the hidden label
      function addNewDiv(word, textBox, divList, resultList) {
         //const textBox = document.querySelector('#Multy_Add_Lists .search_box .search_box_input .p_type_box');
         //const divList = document.querySelector('#Multy_Add_Lists .search_box .search_box_input');
         //const resultList = document.querySelector('#Multy_Add_Lists .search_box .search_box_results');
         const blueDiv = document.createElement('div');
         blueDiv.className = "bluetypeDiv";
         blueDiv.style.backgroundColor = 'blue';
         blueDiv.style.color = 'white';
         blueDiv.style.display = 'flex';
         blueDiv.style.padding = '5px';
         blueDiv.style.marginRight = '5px';
         blueDiv.value = word;
         blueDiv.textContent = word;
   
         const removeBtn = document.createElement('button');
         removeBtn.textContent = 'x';
         removeBtn.style.marginLeft = '5px';
         removeBtn.style.border = 'none';
         removeBtn.style.color = 'red';
         removeBtn.addEventListener('click', function() {
            blueDiv.remove();
            updateHiddenLabel(resultList, textBox);
         });
         blueDiv.appendChild(removeBtn);
   
         divList.insertBefore(blueDiv, textBox);
         updateHiddenLabel(resultList, textBox);
      }
      // new_p_name, p_qty, p_price_sale, p_price_cost, p_disc, p_type, p_active_l, p_change_allowed_l, p_Def_qty
      Multy_new_productes.push([Multy_Add_Form, new_p_name, new_p_code, p_barcode, p_type, p_disc, p_qty, p_price_cost, p_price_sale, p_active_l, p_change_allowed_l, p_Def_qty]);
      
      function get_selected_type(divList) {
         //const divList = document.querySelector('#Multy_Add_Lists .search_box .search_box_input');
         var fileinput = divList.querySelectorAll('.bluetypeDiv');
         let inputpotr = [];
         for(var i = 0; i < fileinput.length; i++){
            inputpotr.push(fileinput[i].value);
         }
         return inputpotr;
      }
   
      function chack_query_type(searchBox, query, divList, results, result_box) {
         const words = ['apple', 'banana', 'cherry', 'orange', 'pear', 'pineapple'];
         //const results = document.querySelector('#Multy_Add_Lists .search_box .results');
         //const text = getList([], first_list); //sortWords(query, first_list);
         
         let selected = get_selected_type(divList);
         console.log('chack_query_type seleced :', selected);
         const list = get_curront_type_List(selected, first_list); //findHierarchy((text+" ").replace(',', ' '), );
         console.log('chack_query_type first_list :', first_list);
         console.log('chack_query_type list :', list);
   
         if (list.length > 0) {
            results.style.display = 'block';
            results.innerHTML = '';
   
            list.forEach(word => {
               const li = document.createElement('li');
               li.textContent = word;
               li.style.color = 'black';
   
               li.addEventListener('click', function() {
                  const word = li.textContent;
                  searchBox.value = word;
                  let search_box_input = divList;
                  addNewDiv(word, searchBox, search_box_input, result_box);
   
                  searchBox.value = '';
                  results.innerHTML = '';
                  results.style.display = 'none';
               });
   
               results.appendChild(li);
            });
         } else  results.style.display = 'none';
      }

      p_type_box.addEventListener('input', function() {
         const searchQuery = this.value.toLowerCase();
         let hiddenLabel = p_type;
         let divList = search_box_input;
         chack_query_type(this, hiddenLabel.value, divList, results, search_box_results);
      });
      
   
      search_box_button.addEventListener('click', function() {Multy_search_box_button_func(p_type_box, search_box_input, search_box_button, search_box_results, p_type);});
     
	}
   
   // Update the hidden label with the collected first_list
   function updateHiddenLabel(resultList, hiddenLabel) {
      const divList = resultList.querySelectorAll('div');
      if(divList){
      const first_listList = [...divList].map(div => div.textContent.split('x')[0]).join(' ');
      //hiddenLabel.value = sortWords(first_listList, first_list)
      }
   }

   function addNewresultDiv(word, textBox, divList, search_box_btn, resultList) {
      //const textBox = document.querySelector('#Multy_Add_Lists .search_box .search_box_input .p_type_box');
      //const divList = document.querySelector('#Multy_Add_Lists .search_box .search_box_input');
      //const resultList = document.querySelector('#Multy_Add_Lists .search_box .search_box_results');
      const blueDiv = document.createElement('div');
      blueDiv.style.backgroundColor = 'blue';
      blueDiv.style.color = 'white';
      blueDiv.style.display = 'flex';
      blueDiv.style.padding = '5px';
      blueDiv.style.marginRight = '5px';
      blueDiv.textContent = word;

      const removeBtn = document.createElement('button');
      removeBtn.textContent = 'x';
      removeBtn.style.marginLeft = '5px';
      removeBtn.style.border = 'none';
      removeBtn.style.background = 'transparent';
      removeBtn.style.color = 'red';
      removeBtn.addEventListener('click', function() {
         blueDiv.remove();
         updateHiddenLabel(resultList, textBox);
      });
      blueDiv.appendChild(removeBtn);
      resultList.appendChild(blueDiv);
      updateHiddenLabel(resultList, textBox);
   }

   function Display_type(Type_code, textBox, divList, search_box_btn, resultList) {
      for (let index = 0; index < Type_code.length; index++) {
         const div_word = [...Type_code[index]].map(words => words.replace(' ', '_')).join(' ');
         if(div_word != "") addNewresultDiv(div_word, textBox, divList, search_box_btn, resultList);
      }
   }
   
   //create first new form
   Add_new_Form();

   function Multy_search_box_button_func(textBox, search_box_input, search_box_btn, resultList, p_type){
      //const textBox = document.querySelector('#Multy_Add_Lists .search_box .search_box_input .p_type_box');
      //const search_box_input = document.querySelector('#Multy_Add_Lists .search_box .search_box_input');
      //const search_box_btn = document.querySelector('#Multy_Add_Lists .search_box .search_box_button');
      //const resultList = document.querySelector('#Multy_Add_Lists .search_box .search_box_results');
      
      var fileinput = search_box_input.querySelectorAll('.bluetypeDiv');
      if(search_box_btn.value == "Done"){
         let inputpotr = [];
         for(var i = 0; i < fileinput.length; i++){
            inputpotr.push(fileinput[i].value);
            fileinput[i].remove();
         }
         if (inputpotr != []){
            let Type_code = [];
            if(p_type.value && p_type.value != "") Type_code = JSON.parse(p_type.value);
            Type_code.push(inputpotr);
            p_type.value = JSON.stringify(Type_code);
            Display_type(Type_code, textBox, search_box_input, search_box_btn, resultList);
         }
         resultList.style.display = "flex";
         search_box_input.style.display = "none";
         search_box_btn.value = "Add Type";
      }
      else if(search_box_btn.value == "Add Type"){ 
         resultList.style.display = "none";
         search_box_input.style.display = "flex";
         search_box_btn.value = "Done";
      }
   }






   let Multy_myListholder = [];
   let Multy_myList = [];
   let Multy_image_to_be_Deleted = [];

   let Multy_selectedValues = [];

   var z=document.querySelector('.add-product-form .button-box .button-box-btn');
   
   var Multy_s1=document.querySelector('#Multy_Add_Lists');
   var Multy_s3=document.querySelector('#step3form');
	var Multy_z1=document.querySelector('.add-product-form .button-box-1 .button-box-1-btn');

   const Multy_form = document.querySelector('form');
   const Multy_imagesInput = document.getElementById('images');
   const Multy_imageList = document.getElementById('image-list');
   //const //imgdis = document.getElementById('output');
   const Multy_a = FileList;

   let Multy_allImages = []; // keep track of all selected images
   let Multy_Images_new_names = []; // keep track of images already added to the list
   let Multy_previousFiles = [];
   const Multy_hiddenLabel = document.querySelector('#Multy_Add_Lists .search_box .search_box_input .p_type');
   const Multy_searchBox = document.querySelector('#Multy_Add_Lists .search_box .search_box_input .p_type_box');
   // search founcions

   
   function get_curront_type_List(paths, nestedList) {
      let ret = [];
      let select_l = paths.length;
      function chacke_nestedlist(curront, selected_id) {
         for(var i = 0; i < curront.length; i++){
            if(select_l > 0){
               if (curront[i][0] == paths[selected_id] && select_l == selected_id+1) {
                  for(var j = 0; j < curront[i][1].length; j++){
                     ret.push(curront[i][1][j][0]);
                  }
               }
               else chacke_nestedlist(curront[i][1], selected_id+1);
            }
            else ret.push(curront[i][0]);
         }
      }
      chacke_nestedlist(nestedList, 0);
      return ret;
   }


   



   // end of search founcions


</script>
<style>
      
#Multy_Add_Lists {
   left: 0%;
    gap: 2.5rem;
    overflow-y: scroll;
}
   
   /*
.add-product-form{
    max-width: 90rem;
    background-color: var(--bg-color);
    border-radius: .5rem;
    padding:2rem;
    margin:0 auto;
    margin-top: 2rem;
 }
 
 .add-product-form .form_box {
   display: flex;
 }
 


#Multy_Add_Lists .p_type_box {
   border: aqua;
   width: 100%;
   padding: 10px;
   box-sizing: border-box;
}

#Multy_Add_Lists .search_box .search_box_input {
  position: relative;
  display: flex;
  justify-content: flex-start;
  align-items: center;
  border: 2px solid #ccc;
  padding: 5px;
  margin-top: 10px;
}

#Multy_Add_Lists .search_box .results {
  display: none;
  background-color: white;
  border: 2px solid #ccc;
  padding: 5px;
  position: absolute;
}

#Multy_Add_Lists .search_box .results li:hover {
  background-color: #999;
}

#Multy_Add_Lists .search_box .search_box_input > div {
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #3f51b5;
  color: #fff;
  font-size: 14px;
  font-weight: bold;
  padding: 8px 12px;
  margin-right: 5px;
  margin-bottom: 5px;
  border-radius: 5px;
}

#Multy_Add_Lists .search_box .search_box_input > div > button {
  margin-left: 5px;
  color: #ff1744;
  font-weight: bold;
  font-size: 14px;
  background-color: transparent;
  border: none;
  cursor: pointer;
}

#step3form{
   position: relative;
   width: 100%;
   height: 100%;
   display: flex;
   flex-direction: column;
   align-items: center;
border: 1px solid #ccc;
padding: 1rem;
border-radius: 5px;
display:none;
}

#step3form h3 {
   margin: 0;
   padding: 0;
   font-size: 1.5rem;
}

#step3form .img_info_box {
   margin-top: 1rem;
   width: 100%;
   display: flex;
   flex-wrap: wrap;
}

#step3form .adding_box {
   flex: 1;
   display: flex;
   flex-direction: column;
   justify-content: center;
   align-items: center;
   margin-right: 1rem;
}

#step3form .adding_box .output {
   margin-top: 1rem;
   height: 100px;
   width: 100px;
}

#step3form .imgs_box {
      border: 1px solid #ccc;
      padding: 1rem;
      border-radius: 5px;
   flex: 2;
   display: flex;
   flex-wrap: wrap;
   align-items: center;
   overflow-x: hidden;
   overflow-y: auto;
}

#step3form .i_image {
max-width: 100%;
max-height: 200px;
object-fit: contain;
margin: 10px;
border: 1px solid black;
box-shadow: 2px 2px 5px grey;
}

#image-list .image-item {
   display: flex;
   flex-direction: column;
   align-items: center;
   margin-right: 1rem;
   margin-bottom: 1rem;
   height: 200px;
   width: 200px;
   object-fit: cover;
}


#image-list input[type="checkbox"] {
   margin-top: 0.5rem;
   font-size: 1rem;
}

 
#btn {
    top: 0; left: 0;
    position: absolute;
    width: 110px;
    height: 35px;
    background: #f3c693;
    border-radius: 30px;
    transition: .5s;
 }
 
 .add-product-form span {
   color: #f5f5f5;
   font-size: 25px;
   bottom: 69px;
   position: absolute;
 }

 #Multy_Add_Lists .checkbox:checked.toggle::after {
  left: 49px;
}

#Multy_Add_Lists .checkbox{
   width: 100px;  
   height: 34px;
}

#Multy_Add_Lists .toggle{
   font-size: 14px;
   position: center;
   top: 50%;
}


.add-product-form .input_table .dobtn{
  width: 200%;
  width: 85%;
   padding: 10px 30px;
   cursor: pointer;
   display: block;
   margin: auto;
   background: #f3c693;
   border: 0;
   outline: none;
   border-radius: 30px;
}
 /*
 
 
 
 
 
 .form-box .input-field {
	 width: 100%;
	 padding: 10px 0;
    margin: 5px 0;
    border-left: 0;
    border-right: 0;
    border-top: 0;
    border-bottom: 0;
    outline: none;
    background: transparent;
 }
 
 
 .form-box .check-box {
    margin: 30px 10px 34px 0;
 }
 
 
 
 .form-box .submit-btn {
    width: 85%;
    padding: 10px 30px;
    cursor: pointer;
    display: block;
    margin: auto;
    background: #f3c693;
    border: 0;
    outline: none;
    border-radius: 30px;
 }

 .add-product-form h3{
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color:var(--black);
    text-transform: uppercase;
    text-align: center;
 }
 
 .add-product-form .input_table{
    width: 100%;
    display: gred;
 } 

 .add-product-form .box_0{
   text-transform: inherit;
    padding: 1.1rem 3.1rem;
    font-size: 1.7rem;
    color: var(--black);
    border-radius: 2.5rem;
    background-color: var(--white);
    margin: 1rem 0;
    width: 40%;
 }


 .display-product-table table{
    width: 100%;
    text-align: center;
 }
 
 .display-product-table table thead th{
    padding:1.5rem;
    font-size: 2rem;
    background-color: var(--black);
    color:var(--white);
 }

 .display-product-table table td{
    padding:1.5rem;
    font-size: 2rem;
    color:var(--black);
 }
 .display-product-table table td .table_btns {
    display: inline-flex;
}
@media (max-width:768px) {
   .display-product-table table td .table_btns  {
    display: block;
   }
}
 .display-product-table table td:first-child{
    padding:0;
 }
 
 .display-product-table table tr:nth-child(even){
    background-color: var(--bg-color);
 }
 
 .display-product-table .empty{
    margin-bottom: 2rem;
    text-align: center;
    background-color: var(--bg-color);
    color:var(--black);
    font-size: 2rem;
    padding:1.5rem;
 }
 */

</style>