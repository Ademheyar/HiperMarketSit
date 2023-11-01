<?php

   // TODO: price include tax and allowe price change is not working tinke about it
   // TODO: if path changed get all images to new path
   // TODO: if image deleted
   // TODO: 

@include 'config.php';

//mysqli_query($conn, "INSERT INTO `products`(`name`, `code`, `type`, `barcode`, `at_shop`, `quantity`, `cost`, `tax`, `price`, `include_tax`, `price_change`, `more_info`, `images`, `Description`, `Service`, `Default_Quantity`, `Active`) VALUES ('[value-2]','[value-3]','[value-4]','[value-5]','shop',7,8,9, 10,11,12,'[value-13]','[value-14]','[value-15]',16,17,18)") or die('query failed');


/*function get_select($up_id,$p_name,$up_type,$up_code,$up_barcode,$up_price_cost,$up_markup,$up_price_sale,$up_include_tax,$up_change_allowed,$up_info,$up_img,$up_img_path,$up_disc,$up_Server,$up_Default_quantity,$up_Active)
{

   if(session_id() == "") session_start();
   $_COOKIE['std_name'] = $_POST['p_name'];
   $_SESSION['std_type'] = $up_type;
   $_SESSION['std_code'] = $up_code;
   $_SESSION['std_barcode'] = $up_barcode;
   $_SESSION['std_active'] = $up_Active;
   $_SESSION['std_def_qty'] = $up_Default_quantity;
   $_SESSION['std_service'] = $up_Server;
   $_SESSION['std_disc'] = $up_disc;
   //$up_img,$up_img_path,
   $_SESSION['std_price_cost'] = $up_price_cost;
   $_SESSION['std_markup'] = $up_markup;
   $_SESSION['std_price_sale'] = $up_price_sale;
   $_SESSION['std_include_tax'] = $up_include_tax;
   $_SESSION['std_allowed'] = $up_change_allowed;

   $_SESSION['std_info'] = $up_info;
}*/
/*
function get_select()
{
   if(session_id() == "") session_start();
   $_SESSION['std_name'] = $_POST['p_name'];
   $_SESSION['std_type'] = $_POST['p_type'];
   $_SESSION['std_code'] = str_replace(' ', '_', $_POST['p_code']);
   $_SESSION['std_barcode'] = $_POST['p_barcode'];
   $_SESSION['std_active'] =isset($_POST['p_active']);
   $_SESSION['std_def_qty'] = isset($_POST['p_Def_qty']);
   $_SESSION['std_service'] = isset($_POST['p_Service']);
   $_SESSION['std_disc'] = $up_disc;
   //$up_img,$up_img_path,
   $_SESSION['std_price_cost'] = $_POST['p_price_cost'];
   $_SESSION['std_markup'] = $_POST['p_markup'];
   $_SESSION['std_price_sale'] = $_POST['p_price_sale'];
   $_SESSION['std_include_tax'] = isset($_POST['p_include_tax']);
   $_SESSION['std_allowed'] = isset($_POST['p_change_allowed']);

   $_SESSION['std_info'] =  $_POST['p_info'];
}*/

if(isset($_POST['add'])){
   $main_p = getcwd();
   $p_name = $new_p_name = $_POST['new_p_name'];
   $p_code = $new_p_code = str_replace('#', '', str_replace(' ', '_', $_POST['new_p_code']));
   $p_type = $new_p_type = $_POST['new_p_type'];
   
   $p_image_folder = $main_p."/img/products/".$p_ptype."/".$p_path_name."/".$p_code;
   
   $p_image_path = $p_image_folder."/".$p_image; 
   
   $new_ppath_name = str_replace(' ', '_', $new_p_name);
   $new_ppath_type = str_replace(' ', '/', $new_p_type);
   $new_path = "{$main_p}/img/products/{$new_ppath_type}/{$new_ppath_name}/{$new_p_code}/";
   // Create the new path
   if (!is_dir($new_path)) {
      mkdir($new_path, 0777, true);
   }
   // Create the old path
   $old_p_name = $_POST['old_p_name'];
   $old_ppath_name = str_replace(' ', '_', $old_p_name);
   $old_p_type = $_POST['old_p_type'];
   $old_ppath_type = str_replace(' ', '/', $old_p_type);
   $old_p_code = str_replace(' ', '_', $_POST['old_p_code']);
   $old_ppath_type = str_replace('#', '', $old_p_code);
   $old_path = "{$main_p}/img/products/{$old_ppath_type}/{$old_ppath_name}/{$old_p_code}/";
   
   /*$p_image = $p_img_names;
   if($_FILES['p_image']['name'])
   $p_image = str_replace(' ', '_', $_FILES['p_image']['name'])." ".$p_img_names;
   $p_path_name = str_replace(' ', '_', $p_name);
   $p_image_folder = $main_p.'/img/products/'.$p_ptype."/".$p_path_name."/".str_replace('#', '', $p_code);
   $p_image_path = $p_image_folder."/".$p_image;
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   */
   if (is_dir($old_path)) {
      $same_name = ($new_p_name == $old_p_name);
      $same_code = ($new_p_code == $old_p_code);
      $same_type = ($new_p_type == $old_p_type);
      
      // Move the files if the strings are different
      if (!$same_name || !$same_code || !$same_type) {
         $files = glob($old_path . "*.*");
         foreach ($files as $file) {
            $filename = basename($file);
            rename($file, $new_path . $filename);
         }
         //rmdir($old_path); // THIS WILL REMOVE OLD DIR
      }
   }
   
   $update_p_id = $_POST['p_id'];

   $p_barcode = $_POST['p_barcode'];
   $p_shop = ""; //TODO: how to give this 
   $p_qty = intval(0); //TODO: how what to fill this 
   $p_price_cost = intval($_POST['p_price_cost']);
   $p_markup = intval($_POST['p_markup']);
   $p_sale_price = intval($_POST['p_price_sale']);
   $p_include_tax = intval(isset($_POST['p_include_tax']));
   $p_change_allowed = intval(isset($_POST['p_change_allowed']));
   $p_info = $_POST['p_info'];
   $p_img_names = $_POST['p_img_names'];
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
               $sql = "UPDATE `products` SET `name`='$p_name', `code`='$p_code', `type`='$p_type', `barcode`='$p_barcode', `at_shop`='$p_shop', `quantity`=$p_qty, `cost`=$p_price_cost, `tax`=$p_markup, `price`=$p_sale_price, `include_tax`=$p_include_tax, `price_change`=$p_change_allowed, 
               `more_info`='$p_info', `images`='$p_img_names', `Description`='$p_disc', `Service`=$p_Service, `Default_Quantity`=$p_Def_qty, `Active`=$p_active";
               $sql .= " WHERE id = '$update_p_id'";
               if ($conn->query($sql) === TRUE) $message[] =  "New product added successfully.";
               else $message[] =  "Error: " . $sql . "<br>" . $conn->error;
               //$conn->close();
            }
         }
      }
      /*$changes = array();
      
      $fields = array(`name`, `code`, `type`, `barcode`, `at_shop`, `quantity`, `cost`, `tax`, `price`, `include_tax`, `price_change`, `more_info`, `images`, `Description`, `Service`, `Default_Quantity`, `Active`);
      $fieldvlaues = array($p_name,$p_code, $p_type, $p_barcode, $p_shop, $p_qty, $p_price_cost, $p_markup, $p_sale_price, $p_include_tax, $p_change_allowed, $p_info, $p_img_names, $p_disc, $p_Service, $p_Def_qty, $p_active);
      $query = "";
      $int = 0;
      foreach ($fields as $field) {
         //if ($fieldvlaues[$int] != $_POST['old_'.$field]) {
            $changes[$field] = $fieldvlaues[$int];
            $query .= "`".$field."` = '".$fieldvlaues[$int]."', ";
         //}
         $int+=1;
      }
      // Remove the last comma and space
      $query = rtrim($query, ", ");
      // Add the WHERE clause to update the correct product
      
      // Execute the query
      $update_query = mysqli_query($conn, $query) or die('query failed');
      // Display the changes
      echo "The following changes have been made:<br>";
      foreach ($changes as $field => $value) {
         echo $field.": ".$_POST['old_'.$field]." -> ".$value."<br>";
      }*/
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
               // Insert the new product into the database
               $sql = "INSERT INTO `products`(`name`, `code`, `type`, `barcode`, `at_shop`, `quantity`, `cost`, `tax`, `price`, `include_tax`, `price_change`, `more_info`, `images`, `Description`, `Service`, `Default_Quantity`, `Active`) VALUES 
               ('$p_name','$p_code', '$p_type', '$p_barcode', '$p_shop', $p_qty, $p_price_cost, $p_markup, $p_sale_price, $p_include_tax, $p_change_allowed, '$p_info', '$p_img_names', '$p_disc', $p_Service, $p_Def_qty, $p_active)";
               
               if ($conn->query($sql) === TRUE) $message[] =  "New product added successfully.";
               else $message[] =  "Error: " . $sql . "<br>" . $conn->error;
               //$conn->close();
            }
         }
      }
   } 

   //$insert_query = mysqli_query($conn, "INSERT INTO `products`(name, code, type, barcode, cost, tax, price, include_tax, price_change, images, more_info, Description, Service, Default_Quantity, Active) VALUES('$p_name', '$p_code', '$p_type', '$p_barcode', '$p_price_cost', '$p_markup' , '$p_sale_price', '$p_include_tax', '$p_change_allowed', '$p_img_names', '$p_info', '$p_disc', '$p_Service', '$p_Def_qty', '$p_active')") or die('query failed');
   if(count($_FILES['p_image']['name']) > 0)
   {
      foreach($_FILES['p_image']['name'] as $key=>$name) {
         $tmpName = $_FILES['p_image']['tmp_name'][$key];
         // Generate unique filename and move file to upload directory
         if($tmpName != ""){
            $newFilePath = $new_path.$name;
            if(move_uploaded_file($tmpName, $newFilePath)){
               $message[] = "File uploaded successfully: ".$new_path.$newFilePath;
            }
         }
      }
   }
   else $message[] =  "Error: image not given";
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
         <button type='button'onclick='step2();'class='btn-2 toggle-btn-1'>Price & tax</button>  
         <button type='button'onclick='step3();'class='btn-3 toggle-btn-1'>Comments</button>  
         <button type='button'onclick='step4();'class='btn-4 toggle-btn-1'>Image</button>  
         <button type='button'onclick='step5();'class='btn-5 toggle-btn-1'>Stock</button>            
      </div>
      <!--required-->
      <div class="input_table">
         <input type="hidden" name="p_id" class="p_id">
         <div id='step1form' class='stepform-class'>
            <h3>Main informations</h3>
            <input type="text" name="new_p_name" value="<?php echo $_COOKIE["std_name"];?>" placeholder="product name" class="box p_name" style="width: 100%;"> 
            <input type="hidden" name="old_p_name" class="old_p_name">
            <div class='search_box'>
               <div class='search_box_input'>
                  <input type="text" value="<?php echo $_COOKIE["std_type"];?>" placeholder="product type" class="box p_type_box" style="width: 100%;">
                  <input type="hidden" name="new_p_type" class="p_type">
                  <input type="hidden" name="old_p_type" class="old_p_type">
               </div>
               <ul class='results'></ul>
            </div>
 
            <input type="checkbox" name="p_active"class="checkbox p_active" <?php if($_COOKIE['std_active']){;?>checked<?php }?>>
            <label for="checkbox" class="toggle">Active</label>
            <input type="checkbox" name="p_Def_qty" class="checkbox p_Def_qty" <?php if($_COOKIE['std_def_qty']){;?>checked<?php }?>>
            <label for="checkbox" class="toggle">Default quantity</label>
            <input type="checkbox" name="p_Service" class="checkbox p_Service" <?php if($_COOKIE['std_service']){;?>checked<?php }?>>
            <label for="checkbox" class="toggle">Service(not using stock)</label>
            <input type="text" name="p_disc" value="<?php echo $_COOKIE['std_disc'];?>" placeholder="product description" class="box_1 p_disc">
         </div>

         <div id='step2form' class='stepform-class'>
               <h3>PRICE</h3>
               <input type="number" name="p_price_cost" min="0" value="<?php echo $_COOKIE['std_price_cost'];?>" placeholder="product cost" class="box p_price_cost"style="width: 100%;">
               <input type="number" name="p_markup" min="0" value="<?php echo $_COOKIE['std_markup'];?>" placeholder="Markup" class="box p_markup"style="width: 100%;">
               <input type="number" name="p_price_sale" min="0" value="<?php echo $_COOKIE['std_price_sale'];?>" placeholder="product Sale price" class="box p_price_sale"style="width: 100%;">
               <input type="checkbox" name="p_include_tax" class="checkbox p_include_tax" <?php if($_COOKIE['std_include_tax']){;?>checked<?php }?>>
               <label for="checkbox" class="toggle">price includes tax</label>
               <input type="checkbox"name="p_change_allowed" class="checkbox p_change_allowed" <?php if($_COOKIE['std_allowed']){;?>checked<?php }?>>
               <label for="checkbox"  class="toggle">price change allowed</label>
         </div>

         <div id='step3form' class='stepform-class'>
            <h3>Likes & Comments</h3>
            
         </div>

         <div id='step4form' class='stepform-class'>
            
         </div>

         <div id='step5form' class='stepform-class'>
            <h3>SIZE AND COLOR</h3>
            <div>
            <input type="text" name="new_p_code" value="<?php echo $_COOKIE["std_code"];?>" placeholder="product code" class="box p_code">
            <input type="hidden" name="old_p_code" class="old_p_code">
            
            <input type="text" name="p_barcode" value="<?php echo $_COOKIE['std_barcode'];?>" placeholder="product Barcode" class="box p_barcode" style="width: 100%;">
            </div>
            <h3>Images</h3>
            <div class="img_info_box">
               <div class="imgs_box" id='image-list'></div>
               <div class="adding_box">
                  <input type="file" id='images' name="p_image[]" multiple accept="image/png, image/jpg, image/jpeg" class="box p_image">
            <!-- >onchange='openFile(event);'-->
                  <!--<input type="submit" value="Add" name="Add_img" class="btn">-->
                  <img id='output' class="output" style="height: 100px; width: 100px;" src="" alt="">
                  <input onclick="Deleimag();" value="Dele" name="Dele_img" class="btn">
                  <input onclick="Clearimag();" value="Clear" name="Clear_img" class="btn">
               </div>
               <input type="hidden" name="old_p_img_names" value="<?php echo $_COOKIE['std_img_names'];?>" class="old_p_img_names">
               <input type="hidden" name="p_img_names" value="<?php echo $_COOKIE['std_img_names'];?>" class="p_img_names">
               <input type="hidden" name="p_img_path0" value="<?php echo $_COOKIE['std_img_path'];?>" class="p_img_path0">
               <input type="hidden" name="p_img_path1" class="p_img_path1">
               <input type="hidden" name="p_img_path2" class="p_img_path2">
            </div>
            <div class="qty_box" style="width: 100%;">
               <input type="combox" name="p_size" placeholder="product sizes" class="box p_size_class" style="width: 40%;" >
               <input type="combox" name="p_color" placeholder="product colors" class="box p_color_class" style="width: 40%;" >   
               <input type="number" name="p_qty" min="0" placeholder="product qty" class="box p_qty_class">
               
               <input type="button" value="Add" class="qty_btn" onclick="add_new_info();" style="width: 20%;">
               <input type="button" value="remove" class="qty_btn" onclick="remove_new_info();" style="width: 20%;">
            </div>
            
            <select name="p_size_list" id="combox1" class="combox1 box p_size_list" style="width: 40%;" onclick="list_size_info();">product sizes</select>
            <select name="p_color_list" id="combox1" class="combox1 box p_color_list" style="width: 40%;" onclick="list_color_info();">product colors</select>   
            <input type="number" name="p_qty_list" min="0" placeholder="product qty" class="box p_qty_list">
            <input type="hidden" value="<?php echo $_COOKIE['std_info'];?>" name="p_info" class="p_info">
         </div>
         <input type="submit" value="Add product" name="add_product" class="dobtn">
         <input type="hidden" value="Add product" name="product_do" class="product_do">
      </div>
      <h3>  </h3>
      <h3><?php echo "\n\n\n"; ?></h3>
      <h3><?php echo "\n\n\n"; ?></h3>
   </form>

   </section>
<!--
   <section class="display-product-table">

      <table>

         <thead>
            <th>product image</th>
            <th>product name</th>
            <th>product price</th>
            <th>action</th>
         </thead>

         <tbody>
            <?php
            
               $select_products = mysqli_query($conn, "SELECT * FROM `products`");
               if(mysqli_num_rows($select_products) > 0){
                  while($row = mysqli_fetch_assoc($select_products)){
                     $shop_name = explode(' ', $row['at_shop']." ");
                     $path = "img/".$shop_name[0]."/products/".str_replace(' ', '/', $row['type'])."/".str_replace(' ', '_', $row['name'])."/".str_replace('#', '', $row['code']);
                     $name = explode('~', $row['images'])[0];
                     $img_path = $path."/".$name;
            ?>

            <tr>
               <td><img src='<?php echo $img_path; ?>' height="100" alt=""></td>
               <td><?php echo $row['name']; ?></td>
               <td>R<?php echo $row['price']; ?></td>
               <td>
                  <form class="table_btns" method="POST">
                     <input type="hidden" name="p_id" value='<?php echo $row['id']; ?>'>
                     <input type="submit" name="delete-btn" class="delete-btn" value="delete">
                     <a onclick="select_update('<?php echo $row['id']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['type']; ?>', '<?php echo $row['code']; ?>', '<?php echo $row['barcode']; ?>', '<?php echo $row['cost']; ?>', '<?php echo $row['tax']; ?>', '<?php echo $row['price']; ?>', '<?php echo $row['include_tax']; ?>', '<?php echo $row['price_change']; ?>', '<?php echo $row['more_info']; ?>', '<?php echo $row['images']; ?>', '<?php echo $path.'/'; ?>', '<?php echo $row['Description']; ?>', '<?php echo $row['Service']; ?>', '<?php echo $row['Default_Quantity']; ?>', '<?php echo $row['Active']; ?>');" class="update_btn option-btn"> UPDATE </a>
                  </form>
               </td>
            </tr>

            <?php
               };    
               }else{
                  echo "<div class='empty'>no product added</div>";
               };
            ?>
         </tbody>
      </table>

   </section>
   <section class="edit-form-container">

      <?php
      
      if(isset($_GET['edit'])){
         $edit_id = $_GET['edit'];
         $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $edit_id");
         if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_assoc($edit_query)){
      ?>

      <form action="" method="post" enctype="multipart/form-data">
         <img src="uploaded_img/<?php echo $fetch_edit['images']; ?>" height="200" alt="">
         <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
         <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['name']; ?>">
         <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['price']; ?>">
         <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
         <input type="submit" value="update the prodcut" name="update_product" class="btn">
         <input type="reset" value="cancel" id="close-edit" class="option-btn">
      </form>

      <?php
               };
            };
            echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
         };
      ?>

   </section>
   -->
</div>
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

#step1form .search_box .search_box_input {
  position: relative;
  display: flex;
  justify-content: flex-start;
  align-items: center;
  border: 2px solid #ccc;
  padding: 5px;
  margin-top: 10px;
}

#step1form .search_box .results {
  display: none;
  background-color: white;
  border: 2px solid #ccc;
  padding: 5px;
  position: absolute;
}

#step1form .search_box .results li:hover {
  background-color: #999;
}

#step1form .search_box .search_box_input > div {
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

#step1form .search_box .search_box_input > div > button {
  margin-left: 5px;
  color: #ff1744;
  font-weight: bold;
  font-size: 14px;
  background-color: transparent;
  border: none;
  cursor: pointer;
}


#step2form {
   left: 100%;
    display: none;
}

#step3form {
   left: 100%;
    display: none;
}
#step5form {
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

#step5form h3 {
   margin: 0;
   padding: 0;
   font-size: 1.5rem;
}

#step5form .img_info_box {
   margin-top: 1rem;
   width: 100%;
   display: flex;
   flex-wrap: wrap;
}

#step5form .adding_box {
   flex: 1;
   display: flex;
   flex-direction: column;
   justify-content: center;
   align-items: center;
   margin-right: 1rem;
}

#step5form .adding_box .output {
   margin-top: 1rem;
   height: 100px;
   width: 100px;
}

#step5form .imgs_box {
      border: 1px solid #ccc;
      padding: 1rem;
      border-radius: 5px;
   flex: 2;
   display: flex;
   flex-wrap: wrap;
   align-items: center;
}

#step5form .i_image {
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

#step5form .btn {
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

#step5form .btn:hover {
   background-color: #3e8e41;
}

#step5form .btn:active {
   background-color: #2c6220;
}
#step5form {
   left: 100%;
    display: none;
}
.add-product-form .button-box {
    width: 220px;
    margin: 2px auto;
    position: relative;
    box-shadow: 0 0 20px 9px#ff61241f;
    border-radius: 10px;
 }

.add-product-form .button-box .toggle-btn {
    padding: 10px 30px;
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
    top: 0; left: 0;
    position: absolute;
    width: 110px;
    height: 35px;
    background: #f3c693;
    border-radius: 30px;
    transition: .5s;
 }
 
 span {
   color: #f5f5f5;
   font-size: 25px;
   bottom: 69px;
   position: absolute;
 }

 #step1form .checkbox:checked,#step2form .checkbox:checked + .toggle::after {
  left: 49px;
}

#step1form .checkbox,#step2form .checkbox{
   width: 100px;  
   height: 34px;
}

#step1form .toggle, #step2form .toggle{
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

<script>

//const tt = reverseNestedList(nestedListElement);
//console.log(tt);
   const words = ['apple', 'banana', 'cherry', 'orange', 'pear', 'pineapple'];
    const searchBox = document.querySelector('#step1form .search_box .search_box_input .p_type_box');
    const results = document.querySelector('#step1form .search_box .results');
    const hiddenLabel = document.querySelector('#step1form .search_box .search_box_input .p_type');

   // Update the hidden label with the collected first_list
   function updateHiddenLabel() {
   const divList = document.querySelectorAll('#step1form .search_box .search_box_input > div');
   const first_listList = [...divList].map(div => div.textContent.split('x')[0]).join(' ');
   hiddenLabel.value = sortWords(first_listList, first_list)
   }

   // Add a new div with a remove button and update the hidden label
   function addNewDiv(word) {
      const textBox = document.querySelector('#step1form .search_box .search_box_input .p_type_box');
      const divList = document.querySelector('#step1form .search_box .search_box_input');
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
         updateHiddenLabel();
      });
      blueDiv.appendChild(removeBtn);

      divList.insertBefore(blueDiv, textBox);
      updateHiddenLabel();
   }


   searchBox.addEventListener('input', function() {
      const searchQuery = searchBox.value.toLowerCase();
      const text = sortWords(hiddenLabel.value, first_list);
      const list = findHierarchy((text+" ").replace(',', ' '), first_list);

      if (list.length > 0) {
         results.style.display = 'block';
         results.innerHTML = '';

         list.forEach(word => {
            const li = document.createElement('li');
            li.textContent = word;

            li.addEventListener('click', function() {
            const word = li.textContent;
            searchBox.value = word;
            addNewDiv(word);
            searchBox.value = '';
            results.style.display = 'none';
            });

            results.appendChild(li);
         });
      } else {
         results.style.display = 'none';
      }
      });

   /*searchBox.addEventListener('input', function() {
      const searchQuery = searchBox.value.toLowerCase();
      const matchingWords = words.filter(word => word.includes(searchQuery));

      if (matchingWords.length > 0) {
        results.style.display = 'block';
        results.innerHTML = '';

        matchingWords.forEach(word => {
          const li = document.createElement('li');
          li.textContent = word;
          li.addEventListener('click', function() {
            const word = li.textContent;
            searchBox.value = word;
            addNewDiv(word);
            searchBox.value = '';
            results.style.display = 'none';
          });
          results.appendChild(li);
        });
      } else {
        results.style.display = 'none';
      }
    });*/

    document.addEventListener('click', function(event) {
      if (!results.contains(event.target)) {
        results.style.display = 'none';
      }
    });


   function getimg() 
   {
      document.querySelector('.add-product-form .input_table .img_info_box .imgs_box .i_image').src = document.querySelector('.add-product-form .input_table .box .adding_box .p_image').value;
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

   function select_update(up_id, up_name, up_type, up_code, up_barcode, up_price_cost, up_markup, up_price_sale, up_include_tax, up_change_allowed, up_info, up_img, up_img_path, up_disc, up_Server, up_Default_quantity, up_Active)
   {

      
      document.cookie = escape("std_img_names") + "=" + escape(up_img) + ";";
      document.querySelector('.add-product-form .input_table .p_img_names').value = up_img;
      document.cookie = escape("std_img_path") + "=" + escape(up_img_path) + ";";
      document.querySelector('.add-product-form .input_table .p_img_path0').value = up_img_path;

      document.querySelector('.add-product-form .input_table .p_id').value =  up_id;
      document.cookie = escape("std_name") + "=" + escape(up_name) + ";";
      document.querySelector('.add-product-form .input_table .p_name').value = up_name;
      document.querySelector('.add-product-form .input_table .old_p_name').value = up_name;
      document.cookie = escape("std_type") + "=" + escape(up_type) + ";";
      document.querySelector('.add-product-form .input_table .p_type').value = up_type;
      document.querySelector('.add-product-form .input_table .old_p_type').value = up_type;
      document.cookie = escape("std_code") + "=" + escape(up_code) + ";";
      document.querySelector('.add-product-form .input_table .p_code').value = up_code;
      document.querySelector('.add-product-form .input_table .old_p_code').value = up_code;
      document.cookie = escape("std_barcode") + "=" + escape(up_barcode) + ";";
      document.querySelector('.add-product-form .input_table .p_barcode').value = up_barcode;
      document.cookie = escape("std_active") + "=" + escape(up_Active) + ";";
      document.querySelector('#step1form .p_active').checked = Number(up_Active);
      document.cookie = escape("std_def_qty") + "=" + escape(up_Default_quantity) + ";";
      document.querySelector('#step1form .p_Def_qty').checked = Number(up_Default_quantity);
      document.cookie = escape("std_service") + "=" + escape(up_Server) + ";";
      document.querySelector('#step1form .p_Service').checked = Number(up_Server);
      document.cookie = escape("std_disc") + "=" + escape(up_disc) + ";";
      document.querySelector('.add-product-form .input_table .p_disc').value = up_disc;

      document.cookie = escape("std_price_cost") + "=" + escape(up_price_cost) + ";";
      document.querySelector('.add-product-form .input_table .p_price_cost').value = up_price_cost;
      document.cookie = escape("std_markup") + "=" + escape(up_markup) + ";";
      document.querySelector('.add-product-form .input_table .p_markup').value = up_markup;
      document.cookie = escape("std_price_sale") + "=" + escape(up_price_sale) + ";";
      document.querySelector('.add-product-form .input_table .p_price_sale').value = up_price_sale;
      document.cookie = escape("std_include_tax",up_include_tax) + ";";
      document.querySelector('#step2form .p_include_tax').checked = Number(up_include_tax);
      document.cookie = escape("std_allowed") + "=" + escape(up_change_allowed) + ";";
      document.querySelector('#step2form .p_change_allowed').checked = Number(up_change_allowed);
      
      document.cookie = escape("std_info") + "=" + escape(up_info) + ";";
      document.querySelector('.add-product-form .input_table .p_info').value = up_info;
      
      
      document.querySelector('.add-product-form .input_table .p_img_path1').value = up_img_path;
      //document.querySelector('.add-product-form .input_table .box .adding_box .p_image').value = up_img_path + up_img;
      var list = document.querySelector('.add-product-form .input_table .img_info_box .imgs_box');
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
      update_func();
   }

	var z=document.querySelector('.add-product-form .button-box .button-box-btn');
   
   var s1=document.querySelector('#step1form');
   var s2=document.querySelector('#step2form');
   var s3=document.querySelector('#step3form');
   var s4=document.querySelector('#step4form');
   var s5=document.querySelector('#step5form');
	var z1=document.querySelector('.add-product-form .button-box-1 .button-box-1-btn');
	
	function step1()
	{
      s1.style.left='0%';
      s2.style.left='100%';
      s3.style.left='100%';
      s4.style.left='100%';
      s5.style.left='100%';
      s1.style.display='block';
      s2.style.display='none';
      s3.style.display='none';
      s4.style.display='none';
      s5.style.display='none';
      document.querySelector('.add-product-form .button-box-1 .btn-1').style.backgroundColor='#f3c693';
      document.querySelector('.add-product-form .button-box-1 .btn-2').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-3').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-4').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-5').style.backgroundColor='transparent';
	}
   function step2()
	{
      s1.style.left='100%';
      s2.style.left='0%';
      s3.style.left='100%';
      s4.style.left='100%';
      s5.style.left='100%';
      s1.style.display='none';
      s2.style.display='block';
      s3.style.display='none';
      s4.style.display='none';
      s5.style.display='none';
      document.querySelector('.add-product-form .button-box-1 .btn-1').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-2').style.backgroundColor='#f3c693';
      document.querySelector('.add-product-form .button-box-1 .btn-3').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-4').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-5').style.backgroundColor='transparent';
	}
   function step3()
	{
      s1.style.left='100%';
      s2.style.left='100%';
      s3.style.left='0%';
      s4.style.left='100%';
      s5.style.left='100%';
      s1.style.display='none';
      s2.style.display='none';
      s3.style.display='block';
      s4.style.display='none';
      s5.style.display='none';
      document.querySelector('.add-product-form .button-box-1 .btn-1').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-2').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-3').style.backgroundColor='#f3c693';
      document.querySelector('.add-product-form .button-box-1 .btn-4').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-5').style.backgroundColor='transparent';
	}
   function step4()
	{
      s1.style.left='100%';
      s2.style.left='100%';
      s3.style.left='100%';
      s4.style.left='0%';
      s5.style.left='100%';
      s1.style.display='none';
      s2.style.display='none';
      s3.style.display='none';
      s4.style.display='block';
      s5.style.display='none';
      document.querySelector('.add-product-form .button-box-1 .btn-1').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-2').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-3').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-4').style.backgroundColor='#f3c693';
      document.querySelector('.add-product-form .button-box-1 .btn-5').style.backgroundColor='transparent';
	}
   function step5()
	{
      s1.style.left='100%';
      s2.style.left='100%';
      s3.style.left='100%';
      s4.style.left='100%';
      s5.style.left='0%';
      s1.style.display='none';
      s2.style.display='none';
      s3.style.display='none';
      s4.style.display='none';
      s5.style.display='block';
      document.querySelector('.add-product-form .button-box-1 .btn-1').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-2').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-3').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-4').style.backgroundColor='transparent';
      document.querySelector('.add-product-form .button-box-1 .btn-5').style.backgroundColor='#f3c693';
	}

   function add_func()
	{
      document.querySelector('.add-product-form .button-box .button-box-btn').style.left='0px';
      document.querySelector('.add-product-form h3').innerText='Add product';
      document.querySelector('.add-product-form .input_table .dobtn').value='Add product';
		document.querySelector('.add-product-form .input_table .product_do').value='Add product';
		document.querySelector('.add-product-form .input_table .product_do').innerText='Add product';
      document.querySelector('.display-product-table table td .table_btns .update_btn').text = "UPDATE";
	}

	function update_func()
	{
      document.querySelector('.add-product-form .button-box .button-box-btn').style.left='100px';
      document.querySelector('.add-product-form h3').innerText='Update Selected product';
      document.querySelector('.add-product-form .input_table .dobtn').value='Update product';
		document.querySelector('.add-product-form .input_table .product_do').value='Update product';
		document.querySelector('.add-product-form .input_table .product_do').innerText='Update product';
      document.querySelector('.display-product-table table td .table_btns .update_btn').text = "SELECT";
	}
   
   var openFile = function(file) {
      var input = file.target;
      /*var reader = new FileReader();
      alert("hhhhhhhhhhhhhhh");

      reader.onload = function(){
         var dataURL = reader.result;
         document.querySelector('#step4form .img_info_box .adding_box .output').src = dataURL;
         var src1 = document.querySelector('.add-product-form .input_table .p_img_path1');
         var src2 = document.querySelector('.add-product-form .input_table .p_img_path2');
         src1.value = dataURL;
         src2.value = src2.value + document.querySelector('.add-product-form .input_table .box .adding_box .p_image').value + "~";
         var list = document.querySelector('.add-product-form .input_table .img_info_box .imgs_box');
         
         var img = document.createElement('image');
         img.src = dataURL;
         img.style.width ="100px";
         img.style.height ="100px";
         img.style.color ="black";
         img.value = dataURL;
         list.appendChild(img);
         
         document.querySelector('.add-product-form h3').textContent = src2.value;
      }
      //document.querySelector('#step4form .img_info_box .adding_box .output').src = input.files[0];
      
      alert(input.value);
      alert(document.querySelector('#step4form .img_info_box .adding_box .output').src);*/
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
   function chang_to_text(){
      var text = "";
      for(var x = 0; a_u_list[x]; x++)
      {
         text = text + "{";
         text = text + a_u_list[x][0];
         text = text + ",[";
         for(var y = 0; a_u_list[x][1][y]; y++)
         {
            text = text + "|";
            text = text + a_u_list[x][1][y][0];
            text = text + ",";
            text = text + a_u_list[x][1][y][1];
            text = text + "|";
            if(a_u_list[x][1][y]) text = text + ",";
         }
         text = text + "]";
         text = text + "}";
         if(a_u_list[x]) text = text + ",";
      }
      document.querySelector('.add-product-form .input_table .p_info').value = text;
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
   const form = document.querySelector('form');
const imagesInput = document.getElementById('images');
const imageList = document.getElementById('image-list');
const imgdis = document.getElementById('output');
const addedImages = []; // keep track of images already added to the list
const allImages = []; // keep track of all selected images
const a = FileList;
let previousFiles = [];


form.addEventListener('submit', function(e) {
  e.preventDefault(); // prevent the form from submitting normally

  const defaultFormData = new FormData(form); // create a new form data object with default values
  const formData = new FormData(); // create a new form data object
 
  // Add each selected image to the form data
  var img_names = "";
  Array.from(previousFiles).forEach(function(file) {
    formData.append('p_image[]', file);
    if(img_names != "") img_names = img_names + "~" + file.name
    else img_names = file.name
  });
  formData.append('p_img_names', img_names);
  formData.append('add', 'add');

  // Merge the default form data with the image data
  for (const [key, value] of defaultFormData.entries()) {
    formData.append(key, value);
  }
  // Submit the form using AJAX
  const xhr = new XMLHttpRequest();
  xhr.open('POST', form.action);
  xhr.send(formData);
  
   console.log("in form list form :"+[...formData]);

  // Clear the image list and input field
  previousFiles.splice(0,previousFiles.length);
  imageList.innerHTML = '';
  imagesInput.value = '';
  imgdis.src = "";
  imgdis.innerHTML = '';
});

// Listen for the change event on the input element
function uploadFiles(files) {
    // Add each selected image to the 'allImages' array
  files.forEach(function(image) {
    const img = document.createElement('img');
    img.src = URL.createObjectURL(image);
    img.value = image.name;
    img.className = 'image-item';

    // Set the source of the 'output' object to the clicked image
    imgdis.src = URL.createObjectURL(image);
    imgdis.value = image.name;
    
    const src = img.getAttribute('src');
    img.addEventListener('click', (event) => {
      imgdis.src = event.target.src;
      imgdis.value = event.target.value;
   });
    imageList.appendChild(img);
  });
  
  // This is where you would upload the files to a server
  console.log('Uploading files:', files);
}

function Deleimag(){
    for(var i = 0; previousFiles[i]; i++) {
         console.log(previousFiles[i].name +"==" +imgdis.value);
        if(previousFiles[i] && imgdis) {
         if(previousFiles[i].name == imgdis.value){
                previousFiles.splice(i,1);      
            imageList.innerHTML = '';
            imagesInput.value = '';
            uploadFiles(previousFiles);
            imgdis.src = "";
            imgdis.innerHTML = '';
            if(i-1 < 0) i = previousFiles.length-1;
            else i-=1;
            if(i <  previousFiles.length) { 
            imgdis.src = URL.createObjectURL(previousFiles[i]);
            imgdis.value = previousFiles[i].name;
            }
         }
      }
    };
}

function Clearimag(){
   previousFiles.splice(0,previousFiles.length);
  imageList.innerHTML = '';
  imagesInput.value = '';
  imgdis.src = "";
  imgdis.innerHTML = '';
}
function openFile(event){}

imagesInput.addEventListener('change', (event) => {
  // Get the new file from the input element
  const newFile = event.target.files;

  // Do something with the merged files (e.g., upload them to a server)
  [...newFile].forEach(function(image) {
    var found = 0;
    for(var i = 0; previousFiles[i]; i++) {
       if(image.name == previousFiles[i].name) {found = 1;break;}
    };
    if(found == 0){
        const img = document.createElement('img');
        img.src = URL.createObjectURL(image);
        img.value = image.name;
        img.className = 'image-item';

        // Set the source of the 'output' object to the clicked image
        imgdis.src = URL.createObjectURL(image);
        imgdis.value = img.value;
        console.log('files name:', image.name);        
        const src = img.getAttribute('src');
        img.addEventListener('click', (event) => {
          imgdis.src = event.target.src;
          imgdis.value = event.target.value;
       });
        imageList.appendChild(img);
        previousFiles = [...previousFiles, image];
        console.log('Uploading files:', previousFiles);
    }
  });
    
});

</script>

<!-- custom js file link  -->
<script src="js/script.js"></script>