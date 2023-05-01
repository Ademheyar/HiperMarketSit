
<?php

@include 'config.php';

if(isset($_POST['update_update_btn'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
   if($update_quantity_query){
      header('location:cart.php');
   };
};

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'");
   header('location:cart.php');
};

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart`");
   header('location:cart.php');
}

?>

<!-- creating the form-box -->
<div id='shopping-cart-form' class='shopping-cart'>
   <h1 class="heading">cart lists</h1>
   <table>
      <tbody>
         <?php 
         if(session_id() == "") session_start();
         $grand_total = 0;
         //array($_POST['product_name'], $_POST['product_price'], $_POST['product_image']);
         $car_id = 0;
         foreach($_SESSION['car'] as $i=>$data1){
            if(count($data1) == 0) break;
         ?>

         <tr>
            <td><img src=<?php echo "img/products/".str_replace(' ', '/', $data1[2])."/".str_replace(' ', '_', $data1[0])."/".$data1[1] ."/".$data1[3]; ?> height="100" alt=""></td>
            <?php if(count($data1[6]) > 0){
                  if(count($data1[6][count($data1[6])-1]) > 0){?>
                  <td><?php echo $data1[6][count($data1[6])-1][0]; ?></td>
                  <td><?php echo $data1[6][count($data1[6])-1][1]; ?></td>
            <?php }}?>
            <?php $sub_price = number_format($data1[4]) * count($data1[6]); ?>
            <td>$<?php echo number_format($data1[4]); ?>x</td>
            <form action="" method="post">
               <td>
                  <input type="hidden" name="update_quantity_id"  value="<?php echo $car_id; ?>" >
                  <input type="number" name="update_quantity" class="update_quantity" onchange="quantity_changed();" min="1"  value="<?php echo  count($data1[6]); ?>" >
               </td>
               <td>
                  <select name="cp_size_list" id="chart_combox1" value="<?php echo $data1[6][count($data1[6])-1][0]; ?>" class="chart_combox1 chart_box cp_size_list" onclick="list_size_info();">product sizes</select>
                  <select name="cp_color_list" id="chart_combox1" value="<?php echo $data1[6][count($data1[6])-1][1]; ?>" class="chart_combox1 chart_box cp_color_list" onclick="list_color_info();">product colors</select>
               </td> 
               <input type="hidden" name="p_info" class="p_info" value="<?php echo $data1[5]; ?>" >
               <td> 
                  <input type="submit" value="update" name="update_update_btn">
                  <a href="cart.php?remove=<?php echo $car_id; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> remove</a>
               </td> 
            </form>
         </tr>
         <?php $sub_total = number_format($data1[4]) * count($data1[6]); ?>
         <?php
         $grand_total += $sub_total;  
         $car_id++;
            };
         ?>
         <tr class="table-bottom">
            <td><?php echo "grand total R".$grand_total; ?></td>
            <td><a href="cart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
         </tr>

      </tbody>

   </table>

   <div class="checkout-btn">
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">procced to checkout</a>
   </div>

</div>   
<script>
   var a_u_list = [];
   function quantity_changed(){

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

   function list_size_info()
   {
      //clear
      chang_to_list(document.querySelector('.shopping-cart .p_info').value);
      var i = 0;
      var list = document.querySelector('.shopping-cart .cp_size_list');
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
      chang_to_list(document.querySelector('.shopping-cart .p_info').value);
      var i = 0;
      var list = document.querySelector('.shopping-cart .cp_color_list');
      for(var q = list.length; q >= 0; q--)
      {
         list.options.remove(q);
      }

      for(var x = 0; a_u_list[x]; x++)
      {
         
         if(a_u_list[x][0] == document.querySelector('.shopping-cart .cp_size_list').value)
         {
            for(var y = 0; a_u_list[x][1][y]; y++)
            {
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
.shopping-cart {
   width: auto;
   height: auto;
   position: absolute;
   margin: 3%;
   left: 15%;
   background: rgba(0,0,0,.3);
   padding: 10px;
   overflow: hidden;
   display: none;
 }
 /*
 
.button-box {
    width: 220px;
    margin: 2px auto;
    position: relative;
    box-shadow: 0 0 20px 9px#ff61241f;
    border-radius: 10px;
 }
 .toggle-btn {
    padding: 10px 30px;
    cursor: pointer;
    background: transparent;
    border: 0;
    outline: none;
    position: relative;
 }
 
 #btn {
    top: 0; left: 0;
    position: absolute;
    width: 110px;
    height: 100%;
    background: #f3c693;
    border-radius: 30px;
    transition: .5s;
 }
 */
.shopping-cart table{
    text-align: center;
    width: 100%;
 }
 

 .shopping-cart table thead th{
    padding:1.5rem;
    font-size: 2rem;
    color:var(--white);
    background-color: var(--black);
 }
 
 .shopping-cart table tr td{
    border-bottom: var(--border);
    font-size: 2rem;
    color:var(--black);
 }
 
 .shopping-cart table input[type="number"]{
    border: var(--border);
    padding:1rem 2rem;
    font-size: 2rem;
    color:var(--black);
    width: 10rem;
 }

 .shopping-cart table select{
    border: var(--border);
    padding:1rem 2rem;
    font-size: 2rem;
    color:var(--black);
    width: 10rem;
 }
 
 .shopping-cart table input[type="submit"]{
    padding:.5rem 1.5rem;
    cursor: pointer;
    font-size: 2rem;
    background-color: var(--orange);
    color:var(--white);
 }
 
 .shopping-cart table input[type="submit"]:hover{
    background-color: var(--black);
 }
 
 .shopping-cart table .table-bottom{
    background-color: var(--bg-color);
 }
 
 .shopping-cart .checkout-btn{
    text-align: center;
    margin-top: 1rem;
 }
 
 .shopping-cart .checkout-btn a{
    display: inline-block;
    width: auto;
 }
 
 .shopping-cart .checkout-btn a.disabled{
    pointer-events: none;
    opacity: .5;
    user-select: none;
    background-color: var(--red);
 }
 

</style>
<!-- the first script code is for login and registration form to move correctly-->
<script>
	  
     window.onscroll = () => {
        var mainy = 150;
        
   var sy = scrollY; 
   var y = mainy + sy;
   var a = document.querySelector('body .Main');
	var ya  = y+ a.scrollTop
	document.getElementById('view-form').style.top = ya + 'px';
        if(document.querySelector('#login-form')) document.querySelector('#login-form').style.top = y + 'px';
        document.querySelector('#shopping-cart-form').style.top = y + 'px';
        menu.classList.remove('fa-times');
        navbar.classList.remove('active');
    };

	function chart_start()
	{
		var mainy = 150;
		var sy = scrollY;
      var y = sy;
      document.querySelector('#shopping-cart-form').style.top = mainy+ y + 'px';
      document.getElementById('shopping-cart-form').style.display='block'; 
      document.getElementById('login-form').style.display='none';
      document.getElementById('view-form').style.display='none'; 
	} 

	// this is for the when you click out the login or registration page the form -box disappears 
   var modal =document.getElementById('login-form');
	window.onclick = function(event)
	{
		if (event.target == modal)
		{
		   modal.style.display = "none";
		}
	}
</script>