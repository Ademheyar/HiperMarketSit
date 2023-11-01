<?php
if (session_id() == "") session_start();

@include 'config.php';
include 'Template/shop/shop_actions.php';

$user_owend_shops = [];
?>
<div class="controller_bar">
<button class="btn new_shop_btn">New</button>
</div>

<div class="add_container">
<section>
<form action="" method="post" class="add-shop-form" enctype="multipart/form-data">

<h3>Add Shop</h3>
   <div class="input_table">
      <input type='text'class='input-filed input-ln box' placeholder='Shop Name'name="register_sname"required>
    <input type='text'class='input-filed input-ln box_0'placeholder='Brand Name'name="register_bname"required>
    <input type='text'class='input-filed bo'placeholder='Type'name="register_type"required>
    <input type='email'class='input-filed'placeholder='Email'name="register_email"required>
    <input type='text'class='input-filed' placeholder='Country'name="register_country"required>
    <input type='number'class='input-filed'placeholder='Phone Number'name="register_phone_No"required>
    <input type='text'class='input-filed'placeholder='Location'name="register_location"required>
    <input type='password'class='input-filed'placeholder='Enter Password'name="register_password"required>
    <input type='password'class='input-filed'placeholder='Congirm Password'name="register_cpassword"required>
    <input type='checkbox'class='check-box'><span>I agree to the terms and conditions</span></input>
<button type='submit'class='btn' name="Create_New_Shop">Create New Shop</button>
   </div>
</form>
</section>
<section class="display-shops-table">
   <table>
      <thead>
         <th>Shop image</th>
         <th>Shop name</th>
         <th>Shop brand</th>
         <th>User Activity</th>
         <th>action</th>
      </thead>
      <tbody>
         <?php
         if($_SESSION['loged_user_info'] && $_SESSION['loged_user_info']['user_shops'] != "") {
           $shops = explode("),", $_SESSION['loged_user_info']['user_shops']);
           foreach ($shops as $key => $Value) {
            $shop_s = explode(",", $Value);
            $shop_id = str_replace('(', '', $shop_s[0]);
             $found_shop = mysqli_query($conn, "SELECT * FROM `Shops` WHERE Shop_Id ='$shop_id'");
               if(mysqli_num_rows($found_shop) > 0){
               while($row = mysqli_fetch_assoc($found_shop)){
                $user_shop_count += 1;
                $user_owend_shops[] = $row;?>
         <tr>
            <td><img src=<?php echo "img/products/".str_replace(' ', '/', $row['type'])."/".str_replace(' ', '_', $row['name'])."/".$row['code'] ."/".$row['image']; ?> height="100" alt=""></td>
            <td><?php echo $row['Shop_name']; ?></td>
            <td><?php echo $row['Shop_brand_name']; ?></td>
            <td><?php echo 'Owens'; ?></td>
            <td>
 <form action="" method="post" enctype="multipart/form-data">   
<a href="?delete_shop=1&register_shop_id=<?php echo $row['Shop_Id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
<?php if ($shop_s[1] == '1'){ ?>
<a href="?enabl_or_disable_shop=1&register_enabl_or_disable=0&register_shop_id=<?php echo $row['Shop_Id']; ?>" class="option-btn" name="enabl_or_disable_shop"> Disable </a>
<a href="Template/shop/Shop_Profile.php?Selected_sid=1&user_shop_id=<?php echo $row['Shop_Id']; ?>" name="Selected_shop_viewe" class="option-btn"> View </a>
<?php }
else{ ?>
    <a href="?enabl_or_disable_shop=1&register_enabl_or_disable=1&register_shop_id=<?php echo $row['Shop_Id']; ?>" class="option-btn" name="enabl_or_disable_shop"> Enable </a>
<?php } ?>
</form>
            </td>
         </tr>
         <?php
            };    
            }
         }
         } 
         // list working shop
         if($_SESSION['loged_user_info'] && $_SESSION['loged_user_info']['User_work_shop'] != "") {
           $shops = explode("),", $_SESSION['loged_user_info']['User_work_shop']);
           foreach ($shops as $key => $Value) {
            $shop_s = explode(",", $Value);
            $shop_id = str_replace('(', '', $shop_s[0]);
             $found_shop = mysqli_query($conn, "SELECT * FROM `Shops` WHERE Shop_Id ='$shop_id'");
               if(mysqli_num_rows($found_shop) > 0){
               while($row = mysqli_fetch_assoc($found_shop)){
                $user_shop_count += 1;
                $user_owend_shops[] = $row;?>
         <tr>
            <td><img src=<?php echo "img/products/".str_replace(' ', '/', $row['type'])."/".str_replace(' ', '_', $row['name'])."/".$row['code'] ."/".$row['image']; ?> height="100" alt=""></td>
            <td><?php echo $row['Shop_name']; ?></td>
            <td><?php echo $row['Shop_brand_name']; ?></td>
            <td><?php echo 'Working'; ?></td>
            <td>
 <form action="" method="post" enctype="multipart/form-data">   

<a href="?delete_user=1&register_user_id=<?php echo $row['_Id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to Remove this Worker?');"> <i class="fas fa-trash"></i> Remove </a>

<?php if ($shop_s[1] == '1'){ ?>
<a href="?enabl_or_disable_user=1&register_enabl_or_disable=0&register_user_id=<?php echo $row['user_Id']; ?>" class="option-btn" name="enabl_or_disable_user"> Disable </a>
<a href="Template/shop/Shop_Profile.php?Selected_sid=1&user_shop_id=<?php echo $row['Shop_Id']; ?>" name="Selected_sid" class="option-btn"> View </a> 
<?php }
else{ ?>
    <a href="?enabl_or_disable_user=1&register_enabl_or_disable=1&register_user_id=<?php echo $row['user_Id']; ?>" class="option-btn" name="enabl_or_disable_user"> Enable </a>
<?php } ?>
</form>
            </td>
         </tr>
         <?php
            };    
            }
         }
         }
        ?>
      </tbody>
   </table>
</section>
</div>
<script>
const checkButton = document.querySelector(".controller_bar .new_shop_btn");
const formB = document.querySelector(".add-shop-form"); checkButton.addEventListener("click", function() {  
const buttonText = checkButton.textContent;

if (buttonText === "New") { 
formB.style.display = "block"; 
checkButton.textContent = "Done";
} else if (buttonText === "Done") { 
formB.style.display = "none"; 
checkButton.textContent = "New";
}});
</script>
<style>
.controller_bar .new_shop_btn{
    background-color: green;
}

.add-shop-form{
    max-width: 90rem;
    background-color: var(--bg-color);
    border-radius: .5rem;
    padding:2rem;
    margin:0 auto;
    margin-top: 2rem;
    display: none;
}


/* Edit and delete button styling */
.delete-btn,
.option-btn,
.edit-btn {
   color: #fff;
   padding: 5px 10px;
   border-radius: 5px;
   cursor: pointer;
   text-decoration: none;
   transition: background-color 0.3s;
}

.delete-btn {
   background-color: #e74c3c;
   margin-right: 10px;
}

.option-btn {
   background-color: #3498db;
}

.edit-btn{
   background-color: red;
   margin-right: 10px;
}

.delete-btn:hover,
.option-btn:hover,
.edit-btn {
  
   background-color: #333;
}

/* Empty table message styling */
.empty {
   margin-bottom: 20px;
   text-align: center;
   background-color: #f0f0f0;
   color: #333;
   font-size: 18px;
   padding: 15px;
   border-radius: 5px;
   
    margin-bottom: 2rem;
    text-align: center;
    background-color: var(--bg-color);
    color:var(--black);
    font-size: 2rem;
    padding:1.5rem;
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



 .add-product-form .input-filed{

    text-transform: none;

    padding:1.2rem 1.4rem;

    border-radius: 2.5rem;

    color:var(--black);

    border-radius: 2.5rem; 

    background-color: var(--white);

    margin:1rem 0;

 }

 .add-product-form .input-filed{

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

/* Container styling */
.add_container {
   display: flex;
   flex-direction: column;
   align-items: center;
   padding: 20px;
}

/* Add product form styling */
.add-product-form {
   max-width: 800px;
   background-color: white;
   border-radius: 10px;
   padding: 20px;
   margin: 20px 0;
   box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.add-product-form h3 {
   font-size: 24px;
   margin-bottom: 20px;
   color: #333;
   text-transform: uppercase;
   text-align: center;
}

.input_table {
   width: 100%;
}

.input-filed {
   padding: 10px 15px;
   border-radius: 5px;
   border: 1px solid #ccc;
   margin: 10px 0;
   width: 100%;
}

.box_1 {
   padding: 20px 15px;
   font-size: 18px;
}

.qty_box {
   width: 100%;
   display: flex;
   align-items: center;
   justify-content: space-between;
}

.p_qty_class {
   width: 25%;
   margin-right: 10px;
}

.qty_btn {
   background-color: #3498db;
   color: white;
   border: none;
   padding: 5px 10px;
   border-radius: 5px;
   cursor: pointer;
}

.combox1 {
   padding: 10px;
   border-radius: 5px;
   border: 1px solid #ccc;
   margin-right: 10px;
   width: 40%;
}

/* Table styling */
.display-product-table table {
   width: 100%;
   text-align: center;
   border-collapse: collapse;
   margin-top: 20px;
}

.display-product-table table th,
.display-product-table table td {
   padding: 15px;
   font-size: 18px;
   border-bottom: 1px solid #ccc;
}

.display-product-table table th {
   background-color: #333;
   color: white;
}

.display-product-table table tr:nth-child(even) {
   background-color: #f0f0f0;
}

/* Edit form container styling */
.edit-form-container {
   display: none;
   justify-content: center;
   align-items: center;
   position: fixed;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background-color: rgba(0, 0, 0, 0.5);
   z-index: 999;
}

.edit-form-container form {
   background-color: white;
   padding: 20px;
   border-radius: 10px;
   box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

/* Image box styling */
.img_box {
   display: flex;
   align-items: center;
   margin-top: 10px;
}

.img_box img {
   height: 200px;
   margin-right: 20px;
}

/* Button styling */
.btn {
   background-color: #3498db;
   color: white;
   border: none;
   padding: 10px 20px;
   border-radius: 5px;
   cursor: pointer;
   font-size: 18px;
   margin-top: 10px;
}


/* Table styling */
.display-product-table {
   margin-top: 20px;
}

.display-product-table table {
   width: 100%;
   text-align: center;
   border-collapse: collapse;
   margin-top: 20px;
}

.display-product-table table th,
.display-product-table table td {
   padding: 15px;
   font-size: 18px;
   border-bottom: 1px solid #ccc;
}

.display-product-table table th {
   background-color: #333;
   color: white;
}

.display-product-table table tr:nth-child(even) {
   background-color: #f0f0f0;
}

</style>