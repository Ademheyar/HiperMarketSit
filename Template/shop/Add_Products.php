<?php

   // TODO: price include tax and allowe price change is not working tinke about it
   // TODO: 
   // TODO: what if it is update $p_shop
   // TODO: how what to fill this $p_qty
   if(file_exists("config.php")) include("config.php");
   if(file_exists("../../config.php")) include("../../config.php");
   if(session_id() == "") { session_start(); }
if(isset($_POST['add'])){
   $main_p = getcwd();
   $main_ps = "{$main_p}/Img/Items/";

   // Create the new path
   if (!is_dir($main_ps)) {
      mkdir($main_ps, 0777, true);
   }
   $jsonimage_names = $_POST['dataobject'];

   $namesobject = json_decode($jsonimage_names);
   $new_names = $namesobject->names;
   $rename_images = $namesobject->rename_images; 
   $delet_image = $namesobject->delet_image; 

   $update_p_id = $_POST['p_id'];

   $p_name = $new_p_name = $_POST['new_p_name'];
   $p_code = $new_p_code = str_replace('#', '', str_replace(' ', '_', $_POST['new_p_code']));
   $p_type = $new_p_type = $_POST['new_p_type'];
   $p_barcode = $_POST['p_barcode'];
   //$p_shop = ""; TODO: what if it is update
   $p_qty = intval(0); //TODO: how what to fill this 
   $p_price_cost = intval($_POST['p_price_cost']);
   $p_markup = intval($_POST['p_markup']);
   $p_sale_price = intval($_POST['p_price_sale']);
   $p_include_tax = intval(isset($_POST['p_include_tax']));
   $p_change_allowed = intval(isset($_POST['p_change_allowed']));
   $p_info = $_POST['p_more_info'];
   $p_img_names = $_FILES['p_image']['IMG_NAME'];// $_POST['p_img_names'];
   $p_disc = $_POST['p_disc'];
   $p_Service = intval(isset($_POST['p_Service']));
   $p_Def_qty = intval(isset($_POST['p_Def_qty']));
   $p_active = intval(isset($_POST['p_active']));
   
   //'$p_include_tax' p_Def_qty 
   //$update_query = mysqli_query($conn, "UPDATE `products`(name, code, type, barcode, cost, tax, price, include_tax, price_change, image, more_info, Service, Default_Quantity, Active) VALUES('$p_name', '$p_code', '$p_type', '$p_barcode', '$p_price_cost', '$p_markup' , '$p_sale_price', '$p_include_tax', '$p_change_allowed', '$p_image', '$p_info', '$p_Service', '$p_Def_qty', '$p_active')") or die('query failed');

   $product_do = $_POST['product_do'];
   
   if ($product_do and $product_do == 'Update product') {
      // Check if any fields have changed
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         // Validate the data
         
         if (empty($p_name)) echo "Please fill in all required fields.";
         else {
            // Connect to the database
            if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
            else{
               // Insert the new product into the database
               //$sql = "UPDATE `products` SET `name`='$p_name', `code`='$p_code', `type`='$p_type', `barcode`='$p_barcode', `at_shop`='$p_shop', `quantity`=$p_qty, `cost`=$p_price_cost, `tax`=$p_markup, `price`=$p_sale_price, `include_tax`=$p_include_tax, `price_change`=$p_change_allowed, 
               $sql = "UPDATE `products` SET `name`='$p_name', `code`='$p_code', `type`='$p_type', `barcode`='$p_barcode', `quantity`=$p_qty, `cost`=$p_price_cost, `tax`=$p_markup, `price`=$p_sale_price, `include_tax`=$p_include_tax, `price_change`=$p_change_allowed, 
               `more_info`='$p_info', `images`='$p_img_names', `Description`='$p_disc', `Service`=$p_Service, `Default_Quantity`=$p_Def_qty, `Active`=$p_active";
               $sql .= " WHERE id = '$update_p_id'";
               $result = $conn->query($sql);
               if ($result === TRUE) $message[] =  "New product added successfully.";
               else $message[] =  "Error: " . $sql . "<br>" . $conn->error;
               //$conn->close();
            }
         }
      }
      
   }
   else if ($product_do and $product_do == 'Add product') {
      // Insert the product and display a success message
      // Check if the form has been submitted
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         // Validate the data
         
         if (empty($p_name)) echo "Please fill in all required fields.";
         else {
            // Connect to the database
            if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
            else{
               $new_p_shop = $_SESSION['Selected_Shop']['Shop_Id'];
               // Insert the new product into the database
               $sql = "INSERT INTO `products`(`name`, `code`, `type`, `barcode`, `at_shop`, `quantity`, `cost`, `tax`, `price`, `include_tax`, `price_change`, `more_info`, `images`, `Description`, `Service`, `Default_Quantity`, `Active`) VALUES 
               ('$p_name','$p_code', '$p_type', '$p_barcode', '$new_p_shop', $p_qty, $p_price_cost, $p_markup, $p_sale_price, $p_include_tax, $p_change_allowed, '$p_info', '$p_img_names', '$p_disc', $p_Service, $p_Def_qty, $p_active)";
               $result = $conn->query($sql);
               if ($result === TRUE) {
                  $message[] =  "New product added successfully.";
                  $newly_added_item = mysqli_fetch_assoc($result);
                  $update_p_id = $newly_added_item['id'];
               }
               else $message[] =  "Error: " . $sql . "<br>" . $conn->error;
               //$conn->close();
            }
         }
      }
   } 

   //$insert_query = mysqli_query($conn, "INSERT INTO `products`(name, code, type, barcode, cost, tax, price, include_tax, price_change, images, more_info, Description, Service, Default_Quantity, Active) VALUES('$p_name', '$p_code', '$p_type', '$p_barcode', '$p_price_cost', '$p_markup' , '$p_sale_price', '$p_include_tax', '$p_change_allowed', '$p_img_names', '$p_info', '$p_disc', '$p_Service', '$p_Def_qty', '$p_active')") or die('query failed');
   if(isset($_FILES['p_image']))
   {
      $image = $_FILES['p_image'];
      for ($i=0; $i < count($image['tmp_name']); $i++) { 
         if (isset($image['tmp_name'][$i]) && !empty($image['tmp_name'][$i])) {
            $filename = basename($image['name'][$i]);
            $new_filename = "";
            for ($j=0; $j < count($new_names); $j++) { 
               if ($new_names[$j][0] == $image['name'][$i] && $new_names[$j][2] == 0) {
                  $new_names[$j][2] = 1;
                  $new_filename = $new_names[$j][1];
                  break;
               }
            }
            $newFilePath = $main_ps.$new_filename;
            $tmpName = $image['tmp_name'][$i];
            // Generate unique filename and move file to upload directory
            if($tmpName != ""){
               if(move_uploaded_file($tmpName, $newFilePath)){
                  $message[] = "File uploaded successfully: ".$newFilePath;
               }  
            }
         }
      }
   }

   foreach($rename_images as $rename_info){
      $old_name = $rename_info[0];
      $new_name = $rename_info[1];

      rename($main_ps.$old_name, $main_ps.$new_name);
   }
   foreach($delet_image as $delete_img_info){
      if(file_exists($main_ps.$delete_img_info)){
         unlink($main_ps.$delete_img_info);
      }
   }
   /*if($update_p_id){
      $httpdata = array('Company_Items' => 'Company_Items', 
                        'Company_Id' => $_SESSION['Selected_Shop']['Shop_Id'],
                        'User_Id' => $_SESSION['loged_user_info']['User_id'],
                        'Product_Id' => $update_p_id);
      $options = array('http' => array('method' => 'POST', 'content' => http_build_query($httpdata)));
      $context = stream_context_create($options);
      file_get_contents('server/Company/Company_profile.php', false, $context);
   }*/
}

else if(isset($_POST['delete-btn'])){
   $delete_id = $_POST['p_id'];;
   $delete_query = mysqli_query($conn, "DELETE FROM `products` WHERE id = $delete_id ") or die('query failed');
   if($delete_query){
      $message[] = 'product has been deleted';
   }else{
      $message[] = 'product could not be deleted';
   };
}

?>
<div class="add_container">
   <section>
   <form class="add-product-form" enctype="multipart/form-data"  method="POST">

      <div class='button-box'>
         <div id='btn' class='button-box-btn'></div>
         <button type='button'onclick='add_func();'class='toggle-btn'>add</button>
         <button type='button'onclick='update_func();'class='toggle-btn'>update</button>            
      </div>   
      <?php if(session_id() == "") { session_start(); } ?>
      <h3 name="hh3">Add product</h3>
      
      <div class='button-box-1'>
         <button type='button'onclick='step1();'class='btn-1 toggle-btn-1'>Details</button>
         <button type='button'onclick='step3();'class='btn-3 toggle-btn-1'>Stock</button>            
      </div>
      <!--required-->
      <div class="input_table">
         <input type="hidden" name="p_id" class="p_id">
         
         
         <div id='step1form' class='stepform-class'>
            <h3>Main informations</h3>
            <input type="text" name="new_p_name" id="item_name" value="" placeholder="product name" class="box p_name" style="width: 100%;"> 
            <input type="hidden" name="old_p_name" class="old_p_name">
            <input type="text" name="p_disc" value="" placeholder="product description" class="box_1 p_disc">

            <h3>PRICE</h3>
               <input type="number" name="p_price_cost" min="0" value="" placeholder="product cost" class="box p_price_cost"style="width: 100%;">
               <input type="number" name="p_markup" min="0" value="" placeholder="Markup" class="box p_markup"style="width: 100%;">
               <input type="number" name="p_price_sale" min="0" value="" placeholder="product Sale price" class="box p_price_sale"style="width: 100%;">
               
            
               <label for="checkbox" class="toggle">
               <input type="checkbox" name="p_active"class="checkbox p_active">Active</label>
               <label for="checkbox" class="toggle">
               <input type="checkbox" name="p_Def_qty" class="checkbox p_Def_qty">Default quantity</label>
               <label for="checkbox" class="toggle">
               <input type="checkbox" name="p_Service" class="checkbox p_Service">Service</label>
               <label for="checkbox" class="toggle">
               <input type="checkbox" name="p_include_tax" class="checkbox p_include_tax">price includes tax</label>
               <label for="checkbox" class="toggle">
               <input type="checkbox"name="p_change_allowed" class="checkbox p_change_allowed">price change allowed</label>
         </div>
         
         <div id='step3form' class='stepform-class'>
             <h3>List Stock</h3>
             <div class='form-class' id="ListStockBox" style="display: flex;">
               <div class='form-class' id="mainDiv" style="width: 50%;display: grid;">
                     
               </div>
               <table id="stockinfotable">
                  <thead>
                     <tr>
                        <th>Type</th>
                        <th>Barcode</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Left</th>
                        <th>Created Date</th>
                        <th>Updated Date</th>
                     </tr>
                  </thead>
               <tbody>
                  
               </tbody>
               </table>
               <style>
                  table{
                     width:50%;
                     border-collapse:collapse;
                  margin:20px auto;
                  }
                  th, td {
                    border: 1px solid #ddd;
                     padding: 8px;
                     text-align: center;
                  }
                  th{
                  
                     background-color:#f2f2f2;
                  }
   tr:nth-child(even) {
      
                     background-color:#f9f9f9;
   }
                  tr:hover{
                     background-color:#f1f1f1;
                  }
               </style>
            </div>
            <h3>Stock</h3>
            <div>
             <input type="hidden" value="" name="p_info" class="p_info">
             <input type="hidden" value="" name="old_p_info" class="old_p_info">
            <select id="Shop_names" name="Shop_names_combobox">
                <?php foreach($_SESSION['User_Shops'] as $my_shops) { 
                      $my_shop_name = htmlspecialchars($my_shops['Shop_name']);
                     // $_SESSION['User_Shops'][$_SESSION['selected_company_id']]['Shop_name'] ?>
                     <option value="<?php echo $my_shop_name; ?>" name="new_p_at_shop" placeholder="product At Shop" id="shop_name" class="box p_at_shop">
                        <?php echo $my_shop_name; ?>
                        
                     </option>
               <?php } ?>
            </select>

               
              <input type="hidden" name="old_p_at_shop" class="old_p_at_shop">
              <input type="text" name="new_p_code" value="" placeholder="product code" id="time_code" class="box p_code">
              <input type="hidden" name="old_p_code" class="old_p_code">
              <input type="text" name="new_p_color" value="" placeholder="product Color" id="item_color"  class="box p_color">
              <input type="hidden" name="old_p_color" class="old_p_volor">
              <input type="text" name="new_p_size" id="item_size" value="" input type="combox" name="p_size" placeholder="product sizes" class="box p_size_class">
              <input type="number" name="p_qty_list" min="0" placeholder="product qty" value="0" class="box p_qty_list" id="item_qty" >
              <input type="hidden" name="old_p_qty_list" class="old_p_qty_list">
              <input type="text" name="p_barcode" value="" placeholder="product Barcode" id="item_barcode" class="box p_barcode" style="width: 100%;">
              <input type="hidden" name="old_p_barcode" class="old_p_barcode">
              <input type="text" name="itemSingleprice" value="" placeholder="product Single Price" id="itemSingleprice" class="box itemSingleprice" style="width: 100%;">
              <input type="hidden" name="old_itemSingleprice" class="old_p_barcode">
            </div>
            <div class='search_box'>
               <div class='search_box_input' style="display:none;">
                  <input type="text" value="" placeholder="product type" class="box p_type_box" style="width: 100%;">
                  <input type="hidden" id="itemtype" name="new_p_type" class="p_type">
                  <input type="hidden" name="old_p_type" class="old_p_type">
               </div>
               <ul class='results'></ul>
               <div class='search_box_results' style="width:auto;"></div>
               <input type="button"  onclick="add_product_search_box_button_func();" value="Add Type" class="btn search_box_button">
            </div>
            <h3>Images</h3>
            <div class="img_info_box">
               <div class="imgs_box" id='image-list'></div>

               <div class="adding_box">
                  <div id="imgfileInputs"> </div>
                  <input type="button"  onclick="Addimag();" value="Add img" name="Add_img" class="btn">
                  <input type="button"  onclick="Clear_item_info();createNextComboBox();" value="Clear" name="Clear_img" class="btn">
                  <input type="button"  onclick="deleteData();" value="Dele" name="Dele_data" class="btn">
                  <input type="button" value="Save Stock" class="btn" onclick="saveData();">
               </div>
               <input type="hidden" name="old_p_img_names" value="" class="old_p_img_names">
               <input type="hidden" name="p_img_names" value="" class="p_img_names">
               <input type="hidden" name="p_img_path0" value="" class="p_img_path0">
               <input type="hidden" name="p_img_path1" class="p_img_path1">
               <input type="hidden" name="p_img_path2" class="p_img_path2">
               
         </div>
         </div>
         <input type="button" value="Add product" name="add_product" onclick="add_New_item();" class="dobtn">
         <input type="hidden" value="Add product" name="product_do" class="product_do">
      </div>
      <h3>  </h3>
      <h3><?php echo "\n\n\n"; ?></h3>
      <h3><?php echo "\n\n\n"; ?></h3>
   </form>

   </section>
</div>


<script>
   let mylistholder = []
   let myList = [];
   let image_to_be_Deleted = [];

   let selectedValues = [];

   var z=document.querySelector('.add-product-form .button-box .button-box-btn');
   
   var s1=document.querySelector('#step1form');
   var s3=document.querySelector('#step3form');
	var z1=document.querySelector('.add-product-form .button-box-1 .button-box-1-btn');

   const imagesInput = document.getElementById('images');
   const imageList = document.getElementById('image-list');
   //const //imgdis = document.getElementById('output');
   const a = FileList;

   let allImages = []; // keep track of all selected images
   let Images_new_names = []; // keep track of images already added to the list
   let previousFiles = [];
   const hiddenLabel = document.querySelector('#step3form .search_box .search_box_input .p_type');
   const searchBox = document.querySelector('#step3form .search_box .search_box_input .p_type_box');
   // search founcions

   
   function step1(){
      s1.style.left='0%';
      s3.style.left='100%';
      s1.style.display='block';
      s3.style.display='none';
      document.querySelector('.add-product-form .button-box-1 .btn-1').style.backgroundColor='#f3c693';
      document.querySelector('.add-product-form .button-box-1 .btn-3').style.backgroundColor='transparent';
	}
   
   function step3()
   	{
         s1.style.left='100%';
         s3.style.left='0%';
         s1.style.display='none';
         s3.style.display='block';
         document.querySelector('.add-product-form .button-box-1 .btn-1').style.backgroundColor='transparent';
         document.querySelector('.add-product-form .button-box-1 .btn-3').style.backgroundColor='#f3c693';
   	}

   function add_product_get_curront_type_List(paths, nestedList) {
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

   // Update the hidden label with the collected first_list
   function add_product_updateHiddenLabel() {
      const divList = document.querySelectorAll('#step3form .search_box .search_box_input > div');
      const first_listList = [...divList].map(div => div.textContent.split('x')[0]).join(' ');
      //hiddenLabel.value = sortWords(first_listList, first_list)
   }

   function add_product_addNewresultDiv(word) {
      const textBox = document.querySelector('#step3form .search_box .search_box_input .p_type_box');
      const divList = document.querySelector('#step3form .search_box .search_box_input');
      const resultList = document.querySelector('#step3form .search_box .search_box_results');
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
         add_product_updateHiddenLabel(resultList, textBox);
      });
      blueDiv.appendChild(removeBtn);
      resultList.appendChild(blueDiv);
      add_product_updateHiddenLabel(resultList, textBox);
   }

   function add_product_Display_type(Type_code) {
      const resultList = document.querySelector('#step3form .search_box .search_box_results');
      resultList.innerHTML = '';
     for (let index = 0; index < Type_code.length; index++) {
         const div_word = [...Type_code[index]].map(words => words.replace(' ', '_')).join(' ');
         if(div_word != "") add_product_addNewresultDiv(div_word);
      }
   }

   function add_product_search_box_button_func(){
      const textBox = document.querySelector('#step3form .search_box .search_box_input .p_type_box');
      const p_type = document.querySelector('#step3form .search_box .search_box_input .p_type');
      const search_box_input = document.querySelector('#step3form .search_box .search_box_input');
      const search_box_btn = document.querySelector('#step3form .search_box .search_box_button');
      const resultList = document.querySelector('#step3form .search_box .search_box_results');
      
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
            console.log('unstringify(Type_code)  :', Type_code);
            p_type.value = JSON.stringify(Type_code);
            console.log('stringify(Type_code)  :', Type_code);
            add_product_Display_type(Type_code);
         }
         resultList.style.display = "flex";
         
         searchBox.value = '';
         search_box_input.style.display = "none";
         search_box_btn.value = "Add Type";
      }
      else if(search_box_btn.value == "Add Type"){ 
         resultList.style.display = "none";
         search_box_input.style.display = "flex";
         search_box_btn.value = "Done";
      }
   }

   // Add a new div with a remove button and update the hidden label
   function add_product_addNewDiv(word) {
      const textBox = document.querySelector('#step3form .search_box .search_box_input .p_type_box');
      const divList = document.querySelector('#step3form .search_box .search_box_input');
      const resultList = document.querySelector('#step3form .search_box .search_box_results');
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
      removeBtn.style.background = 'transparent';
      removeBtn.style.color = 'red';
      removeBtn.addEventListener('click', function() {
         blueDiv.remove();
         add_product_updateHiddenLabel();
      });
      blueDiv.appendChild(removeBtn);

      divList.insertBefore(blueDiv, textBox);
      add_product_updateHiddenLabel();
   }

   function add_product_get_selected_type() {
      const textBox = document.querySelector('#step3form .search_box .search_box_input .p_type_box');
      const divList = document.querySelector('#step3form .search_box .search_box_input');
      var fileinput = divList.querySelectorAll('.bluetypeDiv');
      let inputpotr = [];
      for(var i = 0; i < fileinput.length; i++){
         inputpotr.push(fileinput[i].value);
      }
      return inputpotr;
   }

   function add_product_chack_query_type(query) {
      const words = ['apple', 'banana', 'cherry', 'orange', 'pear', 'pineapple'];
      const results = document.querySelector('#step3form .search_box .results');
      //const text = getList([], first_list); //sortWords(query, first_list);
      
      let selected = add_product_get_selected_type();
      console.log('add_product_chack_query_type seleced :', selected);
      const list = add_product_get_curront_type_List(selected, first_list); //findHierarchy((text+" ").replace(',', ' '), );
      console.log('add_product_chack_query_type first_list :', first_list);
      console.log('add_product_chack_query_type list :', list);

      if (list.length > 0) {
         results.style.display = 'block';
         results.innerHTML = '';

         list.forEach(word => {
            const li = document.createElement('li');
            li.textContent = word;

            li.addEventListener('click', function() {
               const word = li.textContent;
               searchBox.value = word;
               add_product_addNewDiv(word);

               searchBox.value = '';
               results.style.display = 'none';
            });

            results.appendChild(li);
         });
      } else  results.style.display = 'none';
   }

   searchBox.addEventListener('input', function() {
      const searchQuery = searchBox.value.toLowerCase();
      add_product_chack_query_type(hiddenLabel.value);
   });

   // end of search founcions

   // stock functions

   function getList(paths, nestedList) {
      let ret = [];
      let select_l = paths.length;
      const tablebody = document.querySelector('#stockinfotable tbody');
      for(var i = 0; i < nestedList.length; i++){
         if(select_l > 0){
            let found = 0;
            let added = 0;
            for(var l = 0; l < select_l; l++) {
               if(nestedList[i][0][l] == paths[l]){
                  if(l >= 3) {
                     let type_i = 0;
                     tablebody.innerHTML = '';
                     do {
                        let type_f = "None";
                        if((nestedList[i][0][6]).length > 0) type_f = nestedList[i][0][6][type_i]
                        const row = document.createElement('tr');
                        const type = document.createElement('td');
                        type.textContent = type_f;
                        row.appendChild(type);
                        
                        const barcode = document.createElement('td');
                        barcode.textContent = nestedList[i][0][5];
                        row.appendChild(barcode);
   
                        const price = document.createElement('td');
                        price.textContent = nestedList[i][0][7];
                        row.appendChild(price);
   
                        const Qty = document.createElement('td');
                        Qty.textContent = nestedList[i][0][4];
                        row.appendChild(Qty);
   
                        const LQty = document.createElement('td');
                        LQty.textContent = nestedList[i][0][4];
                        row.appendChild(LQty);
   
                        const CDate = document.createElement('td');
                        CDate.textContent = "Date";
                        row.appendChild(CDate);
                        
                        const UDate = document.createElement('td');
                        UDate.textContent = "Date";
                        row.appendChild(UDate);
                        tablebody.appendChild(row);
                        type_i+=1;
                     }
                     while(type_i < (nestedList[i][0][6]).length);

                     Clear_item_info();
                     console.log('nestedList['+i+'][0]  :', i);
                     console.log('nestedList['+i+'][0]  :', nestedList[i][0]);
                     console.log('nestedList['+i+'][1]  :', nestedList[i][1]);
                     
                     document.getElementById('shop_name').value = nestedList[i][0][0];
                     document.getElementById('time_code').value = nestedList[i][0][1];
                     document.getElementById('item_color').value = nestedList[i][0][2];
                     document.getElementById('item_size').value = nestedList[i][0][3];
                     document.getElementById('item_qty').value = nestedList[i][0][4];
                     document.getElementById('item_barcode').value = nestedList[i][0][5];

                     for (let f = 0; f < nestedList[i][1].length; f++) {
                        const element = nestedList[i][1][f];
                        console.log('element  :', element);
                        console.log('typeof  element :', typeof element);
                        if(typeof element == "string"){
                           var newInputWrapper = document.createElement('div');
                           newInputWrapper.className = "oldimgesWrapper";
                           newInputWrapper.style.border = '1px solid #ccc';
                           newInputWrapper.style.overflow = 'hidden';
                           //newInputWrapper.style.display ='none';
                           imageList.appendChild(newInputWrapper);

                           var imagePreviews = document.createElement('div');
                           imagePreviews.className = "imagePreviews";
                           imagePreviews.style.border = '1px solid #ccc';
                           imagePreviews.style.padding = '1rem';
                           imagePreviews.style.borderRadius = '5px';
                           imagePreviews.style.flex = '2';
                           imagePreviews.style.display = 'flex';
                           imagePreviews.style.flexDirection = 'row';
                           imagePreviews.style.alignItems = 'center';
                           imagePreviews.style.overflowX = 'auto';
                           newInputWrapper.appendChild(imagePreviews);

                           const img = document.createElement('img');
                           img.src ="Img/Items/"+element;
                           img.value = element;
                           img.className = 'image-item';
   
                           newInputWrapper.appendChild(img);

                           var removebutton = document.createElement('input');
                           removebutton.type = 'button';
                           removebutton.value = 'Remove';
                           const e = i;
                           const r = f;
                           removebutton.addEventListener('click', function() {
                              (function (q, w) { 
                                 nestedList[q][1].splice(w, 1);
                                 image_to_be_Deleted.push(element);
                              })(e, r);
                              console.log('image_to_be_Deleted  :', image_to_be_Deleted);
                              console.log('nestedList  :', nestedList);
                              this.parentNode.remove();
                           });
                           newInputWrapper.appendChild(removebutton);
                        }
                        else nestedList[i][1][f].style.display = 'block';
                     }
                     added = 1;
                  }
                  else found = 1;
               }
               else {
                  found = 0;
                  break;
               }
            }
            if(found == 1){
               if(!ret.includes(nestedList[i][0][select_l])) ret.push(nestedList[i][0][select_l]);
            }
         }
         else {
            if(!ret.includes(nestedList[i][0][0])) ret.push(nestedList[i][0][0]);
         }
      }
      return ret;
   }

   function clearselecer_comboboxs() {
      const existingComboBox = document.querySelector("#mainDiv select");
      if (selectedValues.length < document.querySelectorAll("#mainDiv select").length) {
         if (existingComboBox) {
            let sibling = existingComboBox.nextElementSibling;
            while (sibling) {
               mainDiv.removeChild(sibling);
               sibling = existingComboBox.nextElementSibling;
            }
            mainDiv.removeChild(existingComboBox);
            selectedValues = [];
         }
      }
   }

   function load_more_info(more_info){
      if (more_info == "") return;
      mylistholder = [];
      console.log(' more_info ', more_info);
      let nestedList = loadList(more_info);
      let inputpotr = [];
      function chacke_nestedlist(curront, selected_id) {
         for(var i = 0; i < curront.length; i++){
            if(curront[i].length > 4){
               let imgs = [];
               if (curront[i][4].includes(';')) imgs = curront[i][4].split(';');
               else if (curront[i][4] != "") imgs = [curront[i][4]];
               mylistholder.push([[...selected_id, curront[i][1], curront[i][3]], imgs]);
            }
            else chacke_nestedlist(curront[i][1], [...selected_id, curront[i][0]]);
         }
      }
      chacke_nestedlist(nestedList, []);
      //if(inputpotr != []) mylistholder.push(inputpotr);
   
      console.log(' mylistholder ', mylistholder);
      // Display what is in the list
      createNextComboBox();

   } 

   function Clear_item_info() {
      const pre_filePreviews = imageList.querySelectorAll('.fileInputWrapper');
      if(pre_filePreviews){ 
         for(let s =0; s < pre_filePreviews.length; s++ ) {
            if (pre_filePreviews[s].align=="1") pre_filePreviews[s].style.display ='none';
            else pre_filePreviews[s].remove();
         }
      }
      
      const pre_imagePreviews = imageList.querySelectorAll('.oldimgesWrapper');
      if(pre_imagePreviews) for(let s =0; s < pre_imagePreviews.length; s++ )pre_imagePreviews[s].remove();
      
      document.getElementById('shop_name').value = "";
      document.getElementById('time_code').value = "";
      document.getElementById('item_color').value = "";
      document.getElementById('item_size').value = "";
      document.getElementById('item_qty').value = "";
      document.getElementById('item_barcode').value = "";
      document.getElementById('itemtype').value = "";
      //document.getElementById('images').value = "";
      clearselecer_comboboxs();
   }
   
   function deleteData() {
      let select_l = selectedValues.length;
      if (select_l <= 0) {
         return false;
      }
      let remove_id = 0;
      for(var i = 0; i < mylistholder.length; i++){
         let found = 0;
         for(var l = 0; l < select_l;l++){
            if( mylistholder[i][0] && mylistholder[i][0][l] && mylistholder[i][0][l] == selectedValues[l]){
               if(select_l == l+1) {
                  for(var j = 0; j < mylistholder[i][1].length; j++){
                     if(mylistholder[i][1][j]){
                        if(typeof mylistholder[i][1][j] == "string") image_to_be_Deleted.push(mylistholder[i][1][j]);
                        else mylistholder[i][1][j].remove();
                     }
                  } 
                  mylistholder.splice(i, 1);
               }
            }
            else break;
         }
      }
      Clear_item_info();
      createNextComboBox();
   }
   
   function saveData() {
      let newinfo = [];
      const new_item_price = document.querySelector('.add-product-form .input_table .p_price_sale').value;

      let shopName = ((document.getElementById('shop_name').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
      let itemCode = ((document.getElementById('time_code').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
      let itemColor = ((document.getElementById('item_color').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
      let itemSize = ((document.getElementById('item_size').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
      let itemQty = ((document.getElementById('item_qty').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
      let itemBarcode = ((document.getElementById('item_barcode').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
      let itemname = ((document.getElementById('item_name').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
      let itemtype = document.getElementById('itemtype').value;
      let itemSingleprice = ((document.getElementById('itemSingleprice').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
      
      document.getElementById('shop_name').value = shopName;
      document.getElementById('time_code').value = itemCode;
      document.getElementById('item_color').value = itemColor;
      document.getElementById('item_size').value = itemSize;
      document.getElementById('item_qty').value = itemQty;
      document.getElementById('item_barcode').value = itemBarcode;
      document.getElementById('item_name').value = itemname;
      document.getElementById('itemtype').value = itemtype;
      document.getElementById('itemSingleprice').value = itemSingleprice;
      
      let type_s = [];
      if(itemtype && itemtype != "") type_s = JSON.parse(itemtype);
      
      let each_sale_price = itemSingleprice;
      if (itemSingleprice == "") each_sale_price= (new_item_price)/type_s.length;
      
      newinfo.push([shopName, itemCode, itemColor, itemSize, itemQty, itemBarcode, type_s, each_sale_price]);

      var fileinput = imageList.children;
      let inputpotr = [];
      for(var i = 0; i < fileinput.length; i++){
         if (fileinput[i].style.display != "none" && fileinput[i].align!="1") {
            fileinput[i].align="1";
            inputpotr.push(fileinput[i]); 
         }
      }

      newinfo.push(inputpotr);

      // chacke if new info is orady saved
      let select_l = newinfo[0].length;
      if (select_l <= 0) {
         return false;
      }
      let add_newlist = 0;
      let similar_found = 0;
      var i = 0; 
      for(;i < mylistholder.length; i++){
         let found = 0;
         for(var l = 0; l < select_l;l++){
            if(mylistholder[i][0] && mylistholder[i][0][l] && mylistholder[i][0][l] == newinfo[0][l]){
               if(l+1 >= 4) {
                  similar_found = 1;
                  found = 1;
                  break; 
               }
            }
            else break;
         }
         if(found == 1) break;
         else if (similar_found == 0) { mylistholder.push(newinfo); break; }
      }
      
      if (similar_found) {
         const response = confirm("Similar Data were Found Do you whant to Marrge it?");
         if (response) {
            const response = confirm("Do you whant to use the new Quntity?");
            if (response) {
               mylistholder[i][0][4] = newinfo[0][4]; 
            }
            else {
               const response = confirm("Or Do you whant to add it with old Quntity?");
               if (response) {
                  mylistholder[i][0][4] = (parseInt(mylistholder[i][0][4]) + parseInt(newinfo[0][4])).toString();
               }
            }
            
            for(var j = 0; j < newinfo[1].length; j++){
               if(newinfo[1][j]) mylistholder[i][1].push(newinfo[1][j]);
            }
         }
         //else mylistholder.push(newinfo);
      }
      if(mylistholder.length == 0) mylistholder.push(newinfo);
   
      // Display what is in the list
      Clear_item_info();
      
      document.querySelector("#mainDiv").innerHTML = '';
      selectedValues = [];
      createNextComboBox();
   }
    
   function createNextComboBox() {
      const mainDiv = document.getElementById("mainDiv");
      clearselecer_comboboxs();
      
      const nextList = getList(selectedValues, mylistholder);
      if (nextList && nextList.length > 0 && document.querySelectorAll("#mainDiv select").length <= 3) {
         
         const newComboBox = document.createElement("select");
         newComboBox.style.textAlign = 'left';
         newComboBox.style.border = '1px solid #ddd';
         //newComboBox.id = "nextList";
         function toremakecombobox(element){
            let sibling = element.nextElementSibling;
            while (sibling) {
               mainDiv.removeChild(sibling);
               sibling = element.nextElementSibling;
               if (selectedValues.length > document.querySelectorAll("#mainDiv select").length-1) {
               selectedValues.pop(); // Remove the last selected value
               }
            }

            selectedValues.splice(mainDiv.children.length-1, selectedValues.length);
            
            selectedValues.push(element.value)
            createNextComboBox();
         }
         
         newComboBox.onchange = function () {toremakecombobox(this);};

         nextList.forEach((item) => {
            if(item){
               const option = document.createElement("option");
               option.value = item.toString();
               option.text = item.toString();
               option.style.padding = '10px';
               option.style.textAlign = 'left';
               option.style.border = '1px solid #ddd';
               option.onclick = function () {toremakecombobox(this.parentElement);};
               newComboBox.appendChild(option);
            }
         });
         newComboBox.value="";
         mainDiv.appendChild(newComboBox);
      }
  }


   // for selecteing img
   function GetImageFile(event){
      let shopName = ((document.getElementById('shop_name').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
      let itemCode = ((document.getElementById('time_code').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
      let itemColor = ((document.getElementById('item_color').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
      let itemSize = ((document.getElementById('item_size').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
      let itemQty = ((document.getElementById('item_qty').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
      let itemBarcode = ((document.getElementById('item_barcode').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
      let itemname = ((document.getElementById('item_name').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
      let itemtype = document.getElementById('itemtype').value;
      
      document.getElementById('shop_name').value = shopName;
      document.getElementById('time_code').value = itemCode;
      document.getElementById('item_color').value = itemColor;
      document.getElementById('item_size').value = itemSize;
      document.getElementById('item_qty').value = itemQty;
      document.getElementById('item_barcode').value = itemBarcode;
      document.getElementById('item_name').value = itemname;
      document.getElementById('itemtype').value = itemtype;

      const imagePreviews = event.target.parentNode.querySelector('.imagePreviews');
      while (imagePreviews.firstChild) imagePreviews.removeChild(imagePreviews.firstChild);
      // Get the new file from the input element
      const newFile = event.target.files;

      console.log('going to Add image to listbox');
      // Do something with the merged files (e.g., upload them to a server)
      [...newFile].forEach(function(image) {
         var found = 0;
         /*for(var i = 0; previousFiles[i]; i++) {
            if(image.name == previousFiles[i].name) {found = 1;break;}
         };*/

         if(found == 0){
            const img = document.createElement('img');
            img.src = URL.createObjectURL(image);
            img.value = image.name;
            img.className = 'image-item';

            console.log('files name:', image.name);        
            imagePreviews.appendChild(img);

            //previousFiles = [...previousFiles, image];
         }
      });
      
   }

   function Addimag(){
      var newInputWrapper = document.createElement('div');
      newInputWrapper.className = "fileInputWrapper";
      newInputWrapper.style.border = '1px solid #ccc';
      newInputWrapper.style.overflow = 'hidden';
      //newInputWrapper.style.display ='none';
      imageList.appendChild(newInputWrapper);

      var imagePreviews = document.createElement('div');
      imagePreviews.className = "imagePreviews";
      imagePreviews.style.border = '1px solid #ccc';
      imagePreviews.style.padding = '1rem';
      imagePreviews.style.borderRadius = '5px';
      imagePreviews.style.flex = '2';
      imagePreviews.style.display = 'flex';
      imagePreviews.style.flexDirection = 'row';
      imagePreviews.style.alignItems = 'center';
      imagePreviews.style.overflowX = 'auto';
      newInputWrapper.appendChild(imagePreviews);

      
      var newInput = document.createElement('input');
      newInput.type = 'file';
      newInput.name = 'p_image[]';
      newInput.className="p_image";
      newInput.setAttribute('onchange', 'GetImageFile(event)');
      newInput.accept="image/png, image/jpg, image/jpeg";
      newInput.multiple=true;
      newInputWrapper.appendChild(newInput);

      var removebutton = document.createElement('button');
      removebutton.type = 'button';
      removebutton.textContent = 'Remove';

      const e = mylistholder.length;
      const r = imageList.childNodes.length;
      removebutton.addEventListener('click', function() {
         if (this.parentNode.align=="1") {
            (function (q, w) { 
               if(mylistholder[q] && mylistholder[q][1] && mylistholder[q][1].length >= w) mylistholder[q][1].splice(w, 1);
            })(e, r);
         }
         this.parentNode.remove();
      });
      newInputWrapper.appendChild(removebutton);


      // Automatically trigger
      newInput.click();

      //chacke old inputs if they have file or not
   }

   
  // Listen for the change event on the input element
  function add_New_item() {
      const form = document.querySelector('.add-product-form');
      const defaultFormData = new FormData(form); // create a new form data object with default values
      const formData = new FormData(); // create a new form data object
      let p_info = "";
      let renameimages = [];
      const new_item_price = document.querySelector('.add-product-form .input_table .p_price_sale').value;
     
      
      for(var i = 0; i < mylistholder.length; i++){
         if(mylistholder[i][0]){
            console.log('mylistholder[i][0]  :', mylistholder[i][0]);
            let shopName = ((mylistholder[i][0][0]).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
            let itemCode = ((mylistholder[i][0][1]).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
            let itemColor = ((mylistholder[i][0][2]).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
            let itemSize = ((mylistholder[i][0][3]).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
            let itemQty = ((mylistholder[i][0][4]).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
            let itemBarcode = ((mylistholder[i][0][5]).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
            let itemtype = (mylistholder[i][0][6]);
            let each_sale_price = (mylistholder[i][0][7]);
            let itemname = ((document.getElementById('item_name').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');
               
            document.getElementById('shop_name').value = shopName;
            document.getElementById('time_code').value = itemCode;
            document.getElementById('item_color').value = itemColor;
            document.getElementById('item_size').value = itemSize;
            document.getElementById('item_qty').value = itemQty;
            document.getElementById('item_barcode').value = itemBarcode;
            document.getElementById('item_name').value = itemname;
            
            let sv = [shopName, itemCode, itemColor, itemSize];
            let index = 0;
            let currentList = myList;
            for (const value of sv) {
               const found = currentList.find((item) => item[0] === value);
               if (found) {
                  currentList = found[1];
                  index++;
               }
               else break;
            }
            
            let itemImageInfo = "";
            if(mylistholder[i][1]){
               console.log('mylistholder[i][1]  :', mylistholder[i][1]);
               let img_count = 0;
               for(var j = 0; j < mylistholder[i][1].length; j++){
                  let newname;
                  if(typeof mylistholder[i][1][j] == "string") 
                  {
                     newname = ((mylistholder[i][1][j]).replace(/[^\w\s.]/g, '')).replace(/\s+/g, '_');
                     const oldname = ((document.querySelector('.add-product-form .input_table .old_p_name').value).replace(/[^\w\s]/g, '')).replace(/\s+/g, '_');;
                     if(oldname != itemname){
                        console.log('oldname  :', oldname);
                        console.log('itemname  :', itemname);
                        console.log('mylistholder[i][1][j]  :', mylistholder[i][1][j]);
                        newname = newname.replace(/oldname/g, itemname);
                        renameimages.push([mylistholder[i][1][j], newname]);
                     }
                     if (itemImageInfo == "") itemImageInfo += newname;
                     else itemImageInfo += ';'+ newname;
                  }
                  else {
                     if(document.contains(mylistholder[i][1][j])){
                        const selectedimages = mylistholder[i][1][j].querySelector('.p_image');
                        console.log('const selectedimages = mylistholder[i][1][j] :', mylistholder[i][1][j]);
                        console.log('selectedimages :', selectedimages);
                        console.log('selectedimages.files :', selectedimages.files);
                        [...selectedimages.files].forEach(function(image) {
                           console.log('image file :', image);
                           let type = "";
                           if(image["type"] == "image/png")  type = ".png";
                           if(image["type"] == "image/jpg") type = ".jpg";
                           if(image["type"] == "image/jpeg") type = ".jpeg";
                           
                           newname= shopName+"_"+itemCode+"_"+itemColor+"_"+itemSize+"_"+itemname+"_"+img_count.toString()+type;
                           Images_new_names.push([image["name"], newname, 0]);
                           console.log('newname file :', newname);
                           
                           if (itemImageInfo == "") itemImageInfo += newname;
                           else itemImageInfo += ';'+ newname;
                           img_count++;
                        });
                     }
                  }
               } 
            }
            console.log('itemImageInfo :', itemImageInfo);
            
            let created_type_infos = [];
            if(itemtype == [] || itemtype == "") created_type_infos = [["", itemBarcode, new_item_price, itemQty, itemQty, "", itemImageInfo, "", "", "", ""]]; 
            else {
               for(let ts=0; ts < itemtype.length; ts++){
                  // TODO : give deffrent barcode for earch item or same
                  // TODO : give deffrent image if needed
                  created_type_infos.push([itemtype[ts], itemBarcode, each_sale_price, itemQty, itemQty, "", itemImageInfo, "", "", "", ""]);
               }
            }
            
            let pathList = [shopName, [[itemCode, [[itemColor, [[itemSize, [created_type_infos]]]]]]]];
            while(1){
               if(index <= 0) break;
               pathList = pathList[1][0];
               index--;
            }
            
            currentList.push(pathList);
            p_info = JSON.stringify(myList); // listtostring(myList);
            console.log('p_more_info :', p_info);
         }
      } 
      while(1){}
      // Add each selected image to the form data
      /*let  img_i = 0;
      Array.from(allImages).forEach(function(file) {
         formData.append('p_image[]', file);
         console.log('IMAG file :', file);
         img_i++;
      });*/

      var dataobject = { names : Images_new_names, rename_images : renameimages, delet_image : image_to_be_Deleted};
      formData.append('dataobject', JSON.stringify(dataobject));
      
      console.log('formData :', formData);

      formData.append('p_more_info', p_info);
      console.log("p_info => key : p_more_info value : ", p_info);
      formData.append('add', 'add');

      // Merge the default form data with the image data
      for (const [key, value] of defaultFormData.entries()) {
         formData.append(key, value);
         console.log("defaultFormData => key : "+key+" value : "+ value);
      }
      // Submit the form using AJAX
      const xhr = new XMLHttpRequest();
      xhr.open('POST', form.action);
      xhr.send(formData);
      
      console.log("in form list form :"+[...formData]);
      //clear_all();
   }
   

   function add_func()
   {
      document.querySelector('.add-product-form .button-box .button-box-btn').style.left='0px';
      document.querySelector('.add-product-form h3').innerText='Add product';
      document.querySelector('.add-product-form .input_table .dobtn').value='Add product';
      document.querySelector('.add-product-form .input_table .product_do').value='Add product';
      document.querySelector('.add-product-form .input_table .product_do').innerText='Add product';
   }

   function update_func()
   {
      document.querySelector('.add-product-form .button-box .button-box-btn').style.left='100px';
      document.querySelector('.add-product-form h3').innerText='Update Selected product';
      document.querySelector('.add-product-form .input_table .dobtn').value='Update product';
      document.querySelector('.add-product-form .input_table .product_do').value='Update product';
      document.querySelector('.add-product-form .input_table .product_do').innerText='Update product';
   }
   function selected_Item_updater(data)
   {
      document.querySelector('.add-product-form .input_table .p_id').value =  data.id;
      document.querySelector('.add-product-form .input_table .p_name').value = data.name;
      document.querySelector('.add-product-form .input_table .old_p_name').value = data.name;

      //add_product_chack_query_type(data.type);
      add_product_Display_type(data.type);
      //document.querySelector('.add-product-form .input_table .p_type').value = data.type;
      document.querySelector('.add-product-form .input_table .old_p_type').value = data.type;

      document.querySelector('#step1form .p_active').checked = Number(data.active);
      document.querySelector('#step1form .p_Def_qty').checked = Number(data.default_quantity);
      document.querySelector('#step1form .p_Service').checked = Number(data.service);

      document.querySelector('.add-product-form .input_table .p_disc').value = data.description;

      document.querySelector('.add-product-form .input_table .p_price_cost').value = data.cost;
      document.querySelector('.add-product-form .input_table .p_markup').value = data.tax;
      document.querySelector('.add-product-form .input_table .p_price_sale').value = data.price;

      document.querySelector('#step1form .p_include_tax').checked = Number(data.include_tax);
      document.querySelector('#step1form .p_change_allowed').checked = Number(data.price_change);
      load_more_info(data.more_info);
      document.querySelector('.add-product-form .input_table .p_info').value = data.more_info;
      document.querySelector('.add-product-form .input_table .old_p_info').value = data.more_info;


      document.querySelector('.add-product-form .input_table .p_code').value = data.code;
      document.querySelector('.add-product-form .input_table .old_p_code').value = data.code;
      document.querySelector('.add-product-form .input_table .p_img_names').value = data.images;
      //document.querySelector('.add-product-form .input_table .p_barcode').value = up_barcode;
      
      update_func();
      document.querySelector('.add_container').parentNode.style.display = "block"; 
      
      /*var list = document.querySelector('.add-product-form .input_table .img_info_box .imgs_box');
      for(var q = list.length; q >= 0; q--)
      {
         list.options.remove(q);
      }
      var img = document.createElement('image');
      img.src = up_img_path + up_img;
      img.src = up_img_path + up_img;
      img.style.width ="5%";
      img.style.height ="5%";
      list.appendChild(img);

      document.querySelector('.add-product-form .input_table .p_img_names').value = up_img;
      chang_to_list(up_info);
      
   document.addEventListener('click', function(event) {
      if (!results.contains(event.target)) {
        results.style.display = 'none';
      }
   });
      */
   }


   function getimg() 
   {
      document.querySelector('.add-product-form .input_table .img_info_box .imgs_box .i_image').src = document.querySelector('.add-product-form .input_table .box .adding_box .p_image').value;
   }

   
   
   
   var a_u_list = [];

   function list_size_info()
   {
      //clear
      var i = 0;
      var list = document.querySelector('.add-product-form .input_table .p_size_list');
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
      var i = 0;
      var list = document.querySelector('.add-product-form .input_table .p_color_list');
      for(var q = list.length; q >= 0; q--)
      {
         list.options.remove(q);
      }

      for(var x = 0; a_u_list[x]; x++)
      {
         
         if(a_u_list[x][0] == document.querySelector('.add-product-form .input_table .p_size_list').value)
         {
            for(var y = 0; a_u_list[x][1][y]; y++)
            {
               if(list.selectedIndex == -1)
               {
                  document.querySelector('.add-product-form .input_table .p_qty_list').value = a_u_list[x][1][y][1];
               }
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

</script>
<style>
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
    
#step1form {
   left: 0%;
}

#step1form .p_type_box {
   border: aqua;
   width: 100%;
   padding: 10px;
   box-sizing: border-box;
}

#step3form .search_box .search_box_input {
  position: relative;
  display: flex;
  justify-content: flex-start;
  align-items: center;
  border: 2px solid #ccc;
  padding: 5px;
  margin-top: 10px;
}

#step3form .search_box .results {
  display: none;
  background-color: white;
  border: 2px solid #ccc;
  padding: 5px;
  position: absolute;
}

#step3form .search_box .results li:hover {
  background-color: #999;
}

#step3form .search_box .search_box_input > div {
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

#step3form .search_box .search_box_input > div > button {
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

#step3form .btn {
   margin-top: 1rem;
   padding: 0.5rem 1rem;
   font-size: 1.2rem;
   font-weight: bold;
   color: white;
   background-color: #4CAF50;
   border: none;
   border-radius: 5px;
   cursor: pointer;
}

#step3form .btn:hover {
   background-color: #3e8e41;
}

#step3form .btn:active {
   background-color: #2c6220;
}
#step3form {
   left: 100%;
    display: none;
}
.add-product-form .button-box {
   gap: 0.5rem;
    align-items: center;
    display: inline-flex;
    margin: 2px auto;
    position: relative;
    box-shadow: 0 0 20px 9px#ff61241f;
    border-radius: 10px;
 }

.add-product-form .button-box .toggle-btn {
    padding: 10px 28px;
    cursor: pointer;
    background: transparent;
    border: 0;
    outline: none;
    position: relative;
 }

 .add-product-form .button-box-1 {
    width: auto;
    margin: 2px auto;
    position: relative;
    box-shadow: 0 0 20px 9px#ff61241f;
    border-radius: 1330px;
 }

.add-product-form .button-box-1 .toggle-btn-1 {
    padding: 10px 30px;
    cursor: pointer;
    background: transparent;
    border: 0;
    outline: none;
    position: relative;
 }

 .add-product-form .button-box-1 .btn-1 {
   background: #f3c693;
 }
 
#btn {
   position: absolute;
    height: 90%;
    background: #f3c693;
    border-radius: 30px;
    transition: .5s;
    padding: 10px 43px;
 }
 
 .add-product-form span {
   color: #f5f5f5;
   font-size: 25px;
   bottom: 69px;
   position: absolute;
 }

 #step1form .checkbox:checked.toggle::after {
  left: 49px;
}

#step1form .checkbox{
   width: 100px;  
   height: 34px;
}

#step1form .toggle{
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
 
 */
 
 
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

 .add-product-form .box{
    text-transform: none;
    padding:1.2rem 1.4rem;
    border-radius: 2.5rem;
    color:var(--black);
    border-radius: 2.5rem; 
    background-color: var(--white);
    margin:1rem 0;
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

 .add-product-form .box_1{
    text-transform: inherit;
    padding:6.1rem 3.1rem;
    font-size: 1.7rem;
    color:var(--black);
    border-radius: 2.5rem;
    background-color: var(--white);
    margin:1rem 0;
    width: 100%;
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

</style>
<script src="js/Typelistscript.js"> </script>

<!-- custom js file link  -->
<script src="js/script.js"></script>