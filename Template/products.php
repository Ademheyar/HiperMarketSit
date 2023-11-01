<?php

   // TODO: price include tax and allowe price change is not working tinke about it
   // TODO: if path changed get all images to new path
   // TODO: if image deleted
   // TODO: 
@include 'config.php';
if(isset($_POST['add_product'])){
   $main_p = getcwd();
   $p_name = $_POST['p_name'];
   $p_code = str_replace(' ', '_', $_POST['p_code']);
   $p_type = $_POST['p_type'];
   $p_info = $_POST['p_info'];
   $p_barcode = $_POST['p_barcode'];
   $p_Service = isset($_POST['p_Service']); 
   $p_Def_qty = isset($_POST['p_Def_qty']);
   $p_active = isset($_POST['p_active']);
   $p_ptype = str_replace(' ', '/', $p_type);
   $p_price_cost = $_POST['p_price_cost'];
   $p_markup = $_POST['p_markup'];
   $p_sale_price = $_POST['p_price_sale'];
   // TODO: price include tax and allowe price change is not working tinke about it
   $p_include_tax = isset($_POST['p_include_tax']);
   $p_change_allowed = isset($_POST['p_change_allowed']);
   $p_image = str_replace(' ', '_', $_FILES['p_image']['name']);
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_path_name = str_replace(' ', '_', $p_name);
   $p_image_folder = $main_p."/img/products/".$p_ptype."/".$p_path_name."/".$p_code;
   $p_image_path = $p_image_folder."/".$p_image; 
   $p_disc = $_POST['p_disc'];
   $p_info = $_POST['p_info'];
   
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_path_name = str_replace(' ', '_', $p_name);
   $p_image_folder = $main_p.'/img/products/'.$p_ptype."/".$p_path_name."/".str_replace('#', '', $p_code);
   $p_image_path = $p_image_folder."/".$p_image;

   $insert_query = mysqli_query($conn, "INSERT INTO `products`(name, code, type, barcode, cost, tax, price, include_tax, price_change, images, more_info, Description, Service, Default_Quantity, Active) VALUES('$p_name', '$p_code', '$p_type', '$p_barcode', '$p_price_cost', '$p_markup' , '$p_sale_price', '$p_include_tax', '$p_change_allowed', '$p_image', '$p_info', '$p_disc', '$p_Service', '$p_Def_qty', '$p_active')") or die('query failed');
  
   if($insert_query){
      mkdir($p_image_folder, 0777, true);
      if(is_dir($p_image_folder))
      {
         if(!file_exists($p_image_path))
         {
            move_uploaded_file($p_image_tmp_name, $p_image_path);
            $message[] = 'product add succesfully'.$p_image_path;
         }
      } 
   }else{
      $message[] = 'could not add the product';
   }
};

if(isset($_POST['delete-btn'])){
   $delete_id = $_POST['p_id'];;
   $delete_query = mysqli_query($conn, "DELETE FROM `products` WHERE id = $delete_id ") or die('query failed');
   if($delete_query){
      $message[] = 'product has been deleted';
   }else{
      $message[] = 'product could not be deleted';
   };
};

if(isset($_POST['update_product'])){
   $main_p = getcwd();
   $update_p_id = $_POST['p_id'];
   $p_name = $_POST['p_name'];
   $p_code = str_replace(' ', '_', $_POST['p_code']);
   $p_type = $_POST['p_type'];
   $p_info = $_POST['p_info'];
   $p_barcode = $_POST['p_barcode'];
   $p_Service = isset($_POST['p_Service']); 
   $p_Def_qty = isset($_POST['p_Def_qty']);
   $p_active = isset($_POST['p_active']);
   $p_ptype = str_replace(' ', '/', $p_type);
   $p_price_cost = $_POST['p_price_cost'];
   $p_markup = $_POST['p_markup'];
   $p_sale_price = $_POST['p_price_sale'];
   $p_include_tax = isset($_POST['p_include_tax']);
   $p_change_allowed = isset($_POST['p_change_allowed']);
   $p_img_names = $_POST['p_img_names'];
   $p_image = $p_img_names;
   if($_FILES['p_image']['name'])
   $p_image = str_replace(' ', '_', $_FILES['p_image']['name'])." ".$p_img_names;
   $p_path_name = str_replace(' ', '_', $p_name);
   $p_image_folder = $main_p.'/img/products/'.$p_ptype."/".$p_path_name."/".str_replace('#', '', $p_code);
   $p_image_path = $p_image_folder."/".$p_image;
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_disc = $_POST['p_disc'];
   $p_info = $_POST['p_info'];
   //$update_query = mysqli_query($conn, "UPDATE `products`(name, code, type, barcode, cost, tax, price, include_tax, price_change, image, more_info, Service, Default_Quantity, Active) VALUES('$p_name', '$p_code', '$p_type', '$p_barcode', '$p_price_cost', '$p_markup' , '$p_sale_price', '$p_include_tax', '$p_change_allowed', '$p_image', '$p_info', '$p_Service', '$p_Def_qty', '$p_active')") or die('query failed');

   $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$p_name', code = '$p_code', type = '$p_type', barcode = '$p_barcode', cost = '$p_price_cost', tax = '$p_markup', price = '$p_sale_price', include_tax = '$p_include_tax', price_change = '$p_change_allowed', images = '$p_img_names', more_info = '$p_info', Service = '$p_Service', Default_Quantity = '$p_Def_qty', Active = '$p_active' WHERE id = '$update_p_id'");
   
   if($update_query){
      //mkdir($p_image_folder, 0777, true);
      if(is_dir($p_image_folder))
      {
         if(!file_exists($p_image_path))
         {
            move_uploaded_file($p_image_tmp_name, $p_image_path);
            $message[] = 'product add succesfully'.$p_image_path;
         }
      } 
   }else{
      $message[] = 'could not add the product';
   }
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>

   <!-- font awesome cdn link  -->
   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">-->

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style.css"> 

</head>


<body>
   
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};
   function saveimage($a){
      
            move_uploaded_file($a, "uploaded_img/");
            $message[] = 'product add succesfully'.$p_image_path;
   }
?>

<?php include 'header.php'; ?>

<div class="add_container">

<section>

<form class="add-product-form" enctype="multipart/form-data"  method="POST">

   <div class='button-box'>
      <div id='btn' class='button-box-btn'></div>
      <button type='button'onclick='add_func();'class='toggle-btn'>add</button>
      <button type='button'onclick='update_func();'class='toggle-btn'>update</button>            
   </div>   


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
         <input type="text" name="p_name" placeholder="product name" class="box p_name" style="width: 100%;">
         <input type="text" name="p_type" placeholder="product type" class="box p_type" style="width: 50%;">
         <input type="text" name="p_code" placeholder="product code" class="box_0 p_code">
         <input type="text" name="p_barcode" placeholder="product Barcode" class="box p_barcode" style="width: 100%;">
         <input type="checkbox" name="p_active"value="1"class="checkbox p_active"checked>
         <label for="checkbox" class="toggle">Active</label>
         <input type="checkbox" name="p_Def_qty" value="1" class="checkbox p_Def_qty"checked>
         <label for="checkbox" class="toggle">Default quantity</label>
         <input type="checkbox" name="p_Service" value="0" class="checkbox p_Service">
         <label for="checkbox" class="toggle">Service(not using stock)</label>
         <input type="text" name="p_disc" placeholder="product description" class="box_1 p_disc">
      </div>

      <div id='step2form' class='stepform-class'>
            <h3>PRICE</h3>
            <input type="number" name="p_price_cost" min="0" placeholder="product cost" class="box p_price_cost"style="width: 100%;">
            <input type="number" name="p_markup" min="0" placeholder="Markup" class="box p_markup"style="width: 100%;">
            <input type="number" name="p_price_sale" min="0" placeholder="product Sale price" class="box p_price_sale"style="width: 100%;">
            <input type="checkbox" name="p_include_tax" class="checkbox p_include_tax">
            <label for="checkbox" class="toggle">price includes tax</label>
            <input type="checkbox"name="p_change_allowed" class="checkbox p_change_allowed">
            <label for="checkbox"  class="toggle">price change allowed</label>
      </div>

      <div id='step3form' class='stepform-class'>
         <h3>Likes & Comments</h3>
         
      </div>

      <div id='step4form' class='stepform-class'>
         <h3>Images</h3>
         <!--<input type="button" onclick="call_php();" value="save" name="saceimg" class="btn">-->
         <div class="img_info_box">
            <div class="imgs_box">
               <img  class="i_image"height="200" alt="">
            </div>
            <div class="adding_box">
               <img id='output' class="output" style="height: 100px; width: 100px;" src="" alt="">
               <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" onchange='openFile(event)' class="box p_image">
            </div>
         </div>
         <input type="hidden" name="p_img_names" class="p_img_names">
         <input type="hidden" name="p_img_path1" class="p_img_path1">
         <input type="hidden" name="p_img_path2" class="p_img_path2">
      </div>

      <div id='step5form' class='stepform-class'>
         <h3>SIZE AND COLOR</h3>
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
         <input type="hidden" name="p_info" class="p_info">
      </div>
      
   </div>
   <div class='form_box'>
      <div id='add_form' class='input-group-add'>
         <input type="submit" value="Add the product" name="add_product" class="btn">
      </div>

      <!-- creating the registration form -->
      <div id='update_form' class='input-group-update'>
         <input type="submit" value="update the product" name="update_product" class="btn">
      </div>
   </div>
   <h3>  </h3>
   <h3><?php echo "\n\n\n"; ?></h3>
   <h3><?php echo "\n\n\n"; ?></h3>
</form>

</section>

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
                  $name = explode(' ', $row['images'])[0];
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

.add-product-form .form_box .input-group-add {
    left: 0%;
 }
 
 .add-product-form .form_box .input-group-update {
    left: 100%;
    display: none;
 }
    
#step1form {
   left: 0%;

}

#step2form {
   left: 100%;
    display: none;
}

#step3form {
   left: 100%;
    display: none;
}
#step4form {
   left: 100%;
    display: none;
}
#step4form .img_info_box {
    display: inline-flex;
    width: 100%;
}

#step4form .img_info_box .adding_box {
    width: 30%;
    background-color: darkgrey;
    display: inline-grid;
}

#step4form .img_info_box .adding_box .output {
    width: 100%;
}

#step4form .img_info_box .adding_box .p_image {
    width: 100%;
}

#step4form .img_info_box .imgs_box {
    width: 70%;
    background-color: aliceblue;
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
    color: #777;
    font-size: 12px;
    bottom: 68px;
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
 
 .input-group-add ,
 .input-group-update{
   width: 200%;
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

<script>
   

   function getimg() 
   {
      document.querySelector('.add-product-form .input_table .img_info_box .imgs_box .i_image').src = document.querySelector('.add-product-form .input_table .box .adding_box .p_image').value;
   }
   
   function select_update(up_id, up_name, up_type, up_code, up_barcode, up_price_cost, up_markup, up_price_sale, up_include_tax, up_change_allowed, up_info, up_img, up_img_path, up_disc, up_Server, up_Default_quantity, up_Active)
   {
      document.querySelector('.add-product-form .input_table .p_id').value =  up_id;
      document.querySelector('.add-product-form .input_table .p_name').value = up_name;
      document.querySelector('.add-product-form .input_table .p_type').value = up_type;
      document.querySelector('.add-product-form .input_table .p_code').value = up_code;
      document.querySelector('.add-product-form .input_table .p_barcode').value = up_barcode;

      document.querySelector('#step1form .p_Service').checked = Number(up_Server);
      document.querySelector('#step1form .p_Def_qty').checked = Number(up_Default_quantity);
      document.querySelector('#step1form .p_active').checked = Number(up_Active);
       
      document.querySelector('.add-product-form .input_table .p_price_cost').value = up_price_cost;
      document.querySelector('.add-product-form .input_table .p_markup').value = up_markup;
      document.querySelector('.add-product-form .input_table .p_price_sale').value = up_price_sale;

      document.querySelector('#step2form .p_include_tax').checked = Number(up_include_tax);
      document.querySelector('#step2form .p_change_allowed').checked = Number(up_change_allowed);

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
      img.style.width ="10%";
      img.style.height ="10%";
      list.appendChild(img);

      document.querySelector('.add-product-form .input_table .p_img_names').value = up_img;
      document.querySelector('.add-product-form .input_table .p_disc').value = up_disc;
      document.querySelector('.add-product-form .input_table .p_info').value = up_info;
      chang_to_list(up_info);
      update_func();
   }

   var x=document.querySelector('.add-product-form .input-group-add');
	var y=document.querySelector('.add-product-form .input-group-update');
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
      document.querySelector('.add-product-form h3').innerText='Add product';
		z.style.left='0px';
		x.style.left='0%';
		y.style.left='100%';
      x.style.display='block';
      y.style.display='none';
      document.querySelector('.display-product-table table td .table_btns .update_btn').text = "UPDATE";
	}

	function update_func()
	{
      document.querySelector('.add-product-form h3').innerText='Update Selected product';
		z.style.left='100px';
		x.style.left='100%';
      x.style.display='none';
      y.style.display='block';
		y.style.left='0%';
      document.querySelector('.display-product-table table td .table_btns .update_btn').text = "SELECT";
	}
   
   var openFile = function(file) {
      var input = file.target;
      var reader = new FileReader();

      reader.onload = function(){
         var dataURL = reader.result;
         var src1 = document.querySelector('.add-product-form .input_table .p_img_path1');
         var src2 = document.querySelector('.add-product-form .input_table .p_img_path2');
         src1.value = dataURL;
         src2.value = src2.value + document.querySelector('.add-product-form .input_table .box .adding_box .p_image').value + "~";
         var list = document.querySelector('.add-product-form .input_table .img_info_box .imgs_box');
         
         var img = document.createElement('image');
         img.src = dataURL;
         img.style.width ="100px";
         img.style.height ="100px";
         img.value = dataURL;
         list.appendChild(img);
         document.querySelector('.add-product-form h3').textContent = src2.value;
      }
      reader.readAsDataURL(input.files[0]);
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
</script>

<!-- custom js file link  -->
<script src="js/script.js"></script>
</body>
</html>
