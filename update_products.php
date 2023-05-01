<?php

@include 'config.php';
if(isset($_POST['update_product'])){
   $main_p = getcwd();
   $update_p_id = $_POST['p_id'];
   $p_name = $_POST['p_name'];
   $p_code = $_POST['p_code'];
   $p_type = $_POST['p_type'];
   $p_ptype = str_replace(' ', '/', $p_type);
   $p_price = $_POST['p_price'];
   $p_image = $_POST['p_img'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_path_name = str_replace(' ', '_', $p_name);
   $p_image_folder = $main_p.'/img/products/'.$p_ptype."/".$p_path_name."/".$p_code;
   $p_image_path = $p_image_folder."/".$p_image;
   $p_disc = $_POST['p_disc'];
   $p_info = $_POST['p_info'];

   $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$p_name', code = '$p_code', type ='$p_type', price = '$p_price', image = '$p_image', Description = '$p_disc', more_info = '$p_info' WHERE id = '$update_p_id'");

   /*if($update_query){
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
   }*/
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

?>

<?php include 'header.php'; ?>

<div class="add_container">

<form action="" method="post" class="add-product-form" enctype="multipart/form-data">
<h3>Update Selected product</h3>
   <div class="input_table">
      <input type="hidden" name="p_id" class="p_id">
      <input type="text" name="p_name" placeholder="product name" class="box p_name" style="width: 100%;" required>
      <input type="text" name="p_type" placeholder="product type" class="box p_type" style="width: 50%;" required>
      <input type="text" name="p_code" placeholder="product code" class="box_0 p_code" required>
      
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
      <h3>PRICE</h3>

      <input type="number" name="p_price" min="0" placeholder="product price" class="box p_price" required>
      
      <div class="img_box">
         <img height="200" alt="">
         <input type="hidden" name="p_img" class="p_img">
         <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box p_image" style="width: 48%;">   
      </div>
      
      <input type="text" name="p_disc" placeholder="product description" class="box_1 p_disc" required>
      <input type="hidden" name="p_img_path" class="p_img_path">
      <input type="submit" value="update the product" name="update_product" class="btn">
   </div>
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
                  $path = "img/".$shop_name[0]."/products/".str_replace(' ', '/', $row['type'])."/".str_replace(' ', '_', $row['name'])."/".$row['code'];
         ?>

         <tr>
            <td><img src=<?php echo $path ."/".$row['images']; ?> height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td>R<?php echo $row['price']; ?></td>
            <td>
               <a onclick="select_update('<?php echo $row['id']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['type']; ?>', '<?php echo $row['code']; ?>', '<?php echo $row['price']; ?>', '<?php echo $row['more_info']; ?>', '<?php echo $row['images']; ?>', '<?php echo $path.'/'; ?>', '<?php echo $row['Description']; ?>');" class="option-btn"> <i class="fas fa-edit"></i> SELECT </a>
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
<script>
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

 .add-product-form .input_table .qty_box {
   text-transform: none;
    display: inline-flex;
    padding: 1.2rem 1.4rem;
    border-radius: 2.5rem;
    border-radius: 2.5rem;
    margin: 1rem 0;
 }

 .add-product-form .input_table .img_box {
   text-transform: none;
    padding:1.2rem 1.4rem;
    border-radius: 2.5rem;
    color:var(--black);
    border-radius: 2.5rem; 
    background-color: var(--white);
    margin:1rem 0;
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

<!-- custom js file link  -->
<script src="js/script.js"></script>
</body>
</html>
