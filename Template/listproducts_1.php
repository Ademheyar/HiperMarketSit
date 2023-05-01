
<div class="list_containers">
			<h1 class="heading">latest products</h1>
			<div class="box-container">
				<?php
      $select_products = mysqli_query($conn, "SELECT * FROM `products`");
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
				$type_path = "";
					$list = explode(' ', $fetch_product['type']);

					$display = 1;
					for ($i=0; $i < $_SESSION['type_on']; $i++) { 
							if($list[$i] != $_SESSION['focused_type'][0][$i]){
									$display = 0;
									break;	
							} 
					}
					if(!$display) continue;
					$shop_name = explode(' ', $fetch_product['at_shop']." ");
      ?>

      <form action="" method="post">
         <div class="box">
			<div class="img_box">
				<?php $path =  str_replace('\\\\', '\\', "img\\".$shop_name[0]."\\products\\".str_replace(' ', '\\', $fetch_product['type'])."\\".str_replace(' ', '_', $fetch_product['name'])."\\".$fetch_product['code']); ?>
				<input type="hidden" name="product_name" class="p_name" value="<?php echo $fetch_product['name']; ?>">
				<input type="hidden" name="product_code" class="p_code" value="<?php echo $fetch_product['code']; ?>">
				<input type="hidden" name="product_type" class="p_type" value="<?php echo $fetch_product['type']; ?>">
				<input type="hidden" name="product_image" class="p_img" value="<?php echo $fetch_product['images'] ?? 'img0'; ?>">
				<input type="hidden" name="product_price" class="p_price" value="<?php echo $fetch_product['price']; ?>">
				<input type="hidden" name="product_disc" class="p_disc" value="<?php echo $fetch_product['Description']; ?>">
				<input type="hidden" name="product_info" class="p_info" value="<?php echo $fetch_product['more_info']; ?>">

				<input type="hidden" name="product_size" class="p_size">
				<input type="hidden" name="product_color" class="p_color">
				
				<input type="hidden" name="product_path" class="p_path" value="<?php echo $path; ?>">

				<button onclick="View_Selected(<?php echo $fetch_product['id']; ?>, '<?php echo $fetch_product['name']; ?>', <?php echo $fetch_product['price']; ?>, '<?php echo $fetch_product['images'] ?? 'img0'; ?>', '<?php echo $path; ?>', '<?php echo $fetch_product['Description']; ?>', '<?php echo $fetch_product['more_info']; ?>');"><img src=<?php echo $path."\\".$fetch_product['images']; ?> height="50" alt=""></button>
				<div class="box_btns">
					<input type="submit" class="lcb_1btns" value="like" name="add_to_cart">
					<input type="submit" class="lcb_1btns" value="Buy" name="add_to_cart">
					<input type="submit" class="lcb_1btns" value="Add to cart" name="add_to_cart">
				</div>
			</div>
			<h3><?php echo $fetch_product['name']; ?></h3>
			<div class="price">R<?php echo $fetch_product['price']; ?></div>
			<input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
			<input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
			<input type="hidden" name="product_image" value="<?php echo $fetch_product['images']; ?>">
		</div>
      </form>

      <?php
        };
      };
      ?>
   </div>
	</div>
	
<?php include 'forms\view.php'; ?>

<style>

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
	left: 34px;
 }

.list_containers .box-container .box .box_btns .lcb_1btns {
	display: block;
	color: black;
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