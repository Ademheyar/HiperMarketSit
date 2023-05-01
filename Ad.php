

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
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


<?php

    /*  include banner area  */
        include ('Template/_banner-area.php');
    /*  include banner area  */

    //  include top sale section 
    include ('Template/_top-sale.php');
    //  include top sale section 
   /*
    //  include special price section  
         include ('Template/_special-price.php');
    //  include special price section 

    //  include new phones section  
        include ('Template/_new-phones.php');
    //  include new phones section  */


?>



<div class="container">

<section class="products">

   <h1 class="heading">latest products</h1>
   <div class="box-container">
      <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `products`");
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>

      <form action="" method="post">
         <div class="box">
            <img src="uploaded_img/<?php echo $fetch_product['iimages']; ?>" alt="">
            <h3><?php echo $fetch_product['name']; ?></h3>
            <div class="price">R<?php echo $fetch_product['price']; ?>/-</div>
            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['iimages']; ?>">
            <input type="submit" class="btn" value="add to cart" name="add_to_cart">
         </div>
      </form>

      <?php
        };
      };
      ?>

   </div>

   <?php
   
    /*  include banner ads  */
    include ('Template/_banner-ads.php');
    /*  include banner ads  */

    /*  include blog area  */
         include ('Template/_blogs.php');
    /*  include blog area  */

    // include footer.php file
    include ('footer.php');
    ?>
</section>

</div>
<!-- !start #footer -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>