<!-- Top Sale -->

<section id="top-sale">
    <div class="top_container py-5">
        <h1 class="heading">Sale</h1>
        <hr>
        <!-- owl carousel -->
        <div class="owl-carousel owl-theme">
            
        <?php
      
        $select_products = mysqli_query($conn, "SELECT * FROM `products`");
        if(mysqli_num_rows($select_products) > 0){
            while($fetch_product = mysqli_fetch_assoc($select_products)){
                $list = explode(' ', $fetch_product['type']);
				$name = explode('~', $fetch_product['images'])[0];
             
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
             <img src=<?php echo "img/".$shop_name[0]."/products/".str_replace(' ', '/', $fetch_product['type'])."/".str_replace(' ', '_', $fetch_product['name'])."/".str_replace('#', '', $fetch_product['code'])."/".$name; ?> height="50" alt="">
                <div class="rating text-warning font-size-12">
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="far fa-star"></i></span>
                </div>
                
                <h3><?php echo $fetch_product['name'] ?? "Unknown"; ?></h3>
                <div class="text-center">                
                
                </div>
                <div class="price">R<?php echo $fetch_product['price'] ?? '0' ; ?></div>
                <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                <input type="hidden" name="product_code" value="<?php echo $fetch_product['code']; ?>">
                <input type="hidden" name="product_type" value="<?php echo $fetch_product['type']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_product['iimages'] ?? 'img0'; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                <input type="submit" class="btn" value="add to cart" name="add_to_cart">
            </div>
        </form>
        <?php
            };
        };
        ?>
        <!-- !owl carousel -->
    </div>
</section>
<!-- !Top Sale -->


<style>
   
#top-sale .top_container{
    display: grid;
    /* grid-template-columns: repeat(auto-fit, 35rem); */
    gap:1.5rem;
    justify-content: center;

    height: 100%;
   width: 100%;
   /*background-image: linear-gradient(rgba(0,0,0,0,4), rgba(0,0,0,0,4),url(image(src)));*/
   background-position: center;
   background-size: cover;
   max-width: 1200px;
   margin:0 auto;
   padding-bottom: 5rem;
   /* this block of code is for the setting the background imag and position of the image if needed*/
 }
 
 #top-sale .top_container .box{
    text-align: center;
    padding:2rem;
    box-shadow: var(--box-shadow);
    border:var(--border);
    border-radius: .5rem;
 }

 #top-sale .top_container .box img{
    height: 25rem;
 }
 
 #top-sale .top_container .box h3{
    margin:1rem 0;
    font-size: 2.5rem;
    color:var(--black);
 }
 
 #top-sale .top_container .box .price{
    font-size: 2.5rem;
    color:var(--black);
 }
 
</style>

<style>

/*  top sale template   */

#top-sale .owl-carousel{
    display: flex;
    overflow: auto;
    position: relative;
    margin: 0 40px;
}

#top-sale .owl-carousel .item{
    line-height: 100%;
    margin-right: 2px;
    text-align: center;
    padding: 2rem;
    box-shadow: var(--box-shadow);
    border: var(--border);
    border-radius: 1.5rem;
    justify-content: space-around;
    display: inline-flex;
    align-items: center;
    align-content: space-between;
    flex-wrap: wrap;
}

#top-sale .owl-carousel .item img {
    position: relative;
    height: 25rem;
    background: #FFFF;
    flex-direction: column;
    align-item: center;
    padding: 3px;
   transition: transform 0.5s ease;
   margin-top: 5px;
   margin-bottom: 5px;
}


#top-sale .owl-carousel .item .item_name {
   transition: transform 0.5s ease;
   margin-top: 5px;
   margin-bottom: 5px;
}

#top-sale .owl-carousel .item .price {
   transition: transform 0.5s ease;
   margin-top: 5px;
   margin-bottom: 5px;
}

#top-sale .owl-carousel .owl-nav button {
   position: absolute;
   top: 30%;
   outline: none;
}

#top-sale .owl-carousel .owl-nav button.owl-prev {
   left: 0;
}

#top-sale .owl-carousel .owl-nav button.owl-prev span,
#top-sale .owl-carousel .owl-nav button.owl-next span {
   font-size: 35px;
   color: #003859;
   padding: 0 1rem;
}

#top-sale .owl-carousel .owl-nav button.owl-prev span {
   margin-left: -4rem;
}

#top-sale .owl-carousel .owl-nav button.owl-next {
   right: 0;
}

#top-sale .owl-carousel .owl-nav button.owl-next span {
   margin-right: -4rem;
}

</style>

<script>
   /* $(document).ready(function(){
        // top sale owl carousel
        $("#top-sale .owl-carousel").owlCarousel({
            loop: true,
            nav: true,
            dots: false,
            responsive : {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000 : {
                    items: 5
                }
            }
        });
    });*/
</script>

