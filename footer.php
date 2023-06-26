<!-- start #footer -->
<footer id="footer">
    <div class='MenuItems'>
         

        <?php if ($_SESSION['on'] != 0){ ?>
            <a href="Main.php" class="MenuItemBtn Home_mainu">
               <img src="img/home.png" class="Home_icon" alt="">
               <b href="Main.php" class="Home_text">Home</b>
            </a>  
         <?php } ?>

        <?php if ($_SESSION['on'] != 1){ ?>
            <a href="Template/profile/View_Profile.php" class="MenuItemBtn Home_mainu">
               <img src="img/home.png" class="Home_icon" alt="">
               <b href="Template/profile/View_Profile.php" class="View_Profile_text">View Profile</b>
            </a>   
         <?php } ?>

        <?php 
        // Check if the user is logged in and has user type 2
        if(isset($_SESSION['loged_user_type']) && $_SESSION['loged_user_type'] == 2) { ?>
            <a href="view_products.php" class="MenuItemBtn Home_mainu">
                <img src="img/home.png" class="Home_icon" alt="">
                <b href="view_products.php" class="Home_text">View Products</b>
            </a>

            <a href="products.php" class="MenuItemBtn Home_mainu">
                <img src="img/home.png" class="Home_icon" alt="">
                <b href="products.php" class="Home_text">Products</b>
            </a>
            
            <a onclick="chart_start();" class="MenuItemBtn Home_mainu">Cart<span><?php echo $_SESSION['car_length']; ?></span></a>    

            <a href="Logout.php" class="MenuItemBtn Home_mainu">
                <img src="img/home.png" class="Home_icon" alt="">
                <b href="Logout.php" class="Home_text">Log out<span><?php echo $_SESSION['loged_user_name']; ?></span></b>
            </a>
        <?php } else { 
            // If the user is not logged in or has a different user type
            if(session_id() == "") session_start(); ?>  
            <a onclick="chart_start();" class="MenuItemBtn Home_mainu">
                <img src="img/cart.png" class="Home_icon" alt="">
                <b onclick="chart_start();" class="Home_text">Cart<span><?php echo $_SESSION['loged_user_name']; ?></span></b>
            </a>    
            
            <button onclick="log_in_out();" style="width:auto;" class="MenuItemBtn loginbtn">
                <b class="Home_text">Log in</b>
            </button> 
        <?php } ?>            
    </div>
    <!--<div class="footer_container">
        <div class="footer_container_row">
            <div class="col-lg-3 col-12">
                <h4 class="font-rubik font-size-20">ADOT SHOPING</h4>
                <p class="font-size-14 font-rale text-white-50">Lorem ipsum.</p>
            </div>
            
            <div class="col-lg-4 col-12">
                <h4 class="font-rubik font-size-20">Newslatter</h4>
                <form class="form-row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Email *">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary mb-2">Subscribe</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-2 col-12">
                <h4 class="font-rubik font-size-20">Information</h4>
                <div class="d-flex flex-column flex-wrap">
                    <a href="#" class="font-rale font-size-14 text-white-50 pb-1">About Us Delivery Information Privacy Policy Terms & Conditions</a>
                </div>
            </div>
            <div class="col-lg-2 col-12">
                <h4 class="font-rubik font-size-20">Account</h4>
                <div class="d-flex flex-column flex-wrap">
                    <a href="#" class="font-rale font-size-14 text-white-50 pb-1">My Account Order History Wish List Newslatters</a>
                </div>
            </div>
        </div>          
        <div class="copyright text-center bg-white text-dark py-2">
            <a href="#" class="color-second font-size-14">ADDIS_SOFTWARES &copy; Copyrights 2022. BY Adem Heyar(ademheyar@gmail.com)</a>
        </div>
    </div>-->
</footer>
    
<style>
#footer{
    position: relative;
    clear: both;
    /* clear: both; */
    /* background: var(--bg); */
    display: list-item;
    align-items: center;
    justify-content: space-between;
    /* padding: 1.5rem 7%; */
    border-bottom: var(--border);
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 1000;

    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    position: absolute;
    width: 15%;
    height: 100%; /* Adjusted to be 75% of the parent height */
    top: 15rem; /* Added to push it 25% down from the parent */
    background: var(--bg);
 }
 

 #footer .MenuItems {
    display: inline-flex;
    margin: auto;
    padding: 1%;
    width: 15%;
    display: flex;
    overflow-x: scroll;
    grid-template-columns: repeat(auto-fit, 20rem);
    gap: 11.5rem;
    justify-content: center;
    line-height: 100%;
    margin-right: 12px;
    text-align: center;
    padding: 3rem;
    box-shadow: var(--box-shadow);
    border: var(--border);
    border-radius: 1.5rem;
    align-items: center;
    align-content: space-between;
}

.footer_container{
   margin: auto;
}

.footer_container_row{
    display: flex;
}

#footer li {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  list-style: none;
}

#footer li a,
#footer li button {
  padding: 2rem;
  border: var(--border);
  border-radius: 0.5rem;
}

#footer .MenuItemBtn {
   position: relative;
   width: 100%;
   margin-bottom: 10px;
   border: var(--border);
   border-radius: 0.5rem;
   top: 10%;
}

#footer .Home_mainu {
  text-align: left;
  border: var(--border);
  border-radius: 0.5rem;
  display: block;
  background: #010103;
}

#footer .Home_mainu:hover {
  background: #eee;
}

#footer .Home_mainu .Home_text {
  color: palevioletred;
  font-size: 19px;
}

#footer .Home_mainu .Home_icon {
  width: 25px;
  height: 25px;
}


.col-12{

    /* padding: 0 15px; */
    /* DISPLAY: GRID;*/
}


/*
@media (max-width:730px) {
   #footer {
        background: #24262b;
        //position: initial; 
        // clear: both; 
        // background: var(--bg); 
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem 7%;
        border-bottom: var(--border);
        position: fixed;
        bottom: 0;
        // top: 100%; 
        left: 0;
        right: 0;
        z-index: 1000;
   }
}*/

/* media queries  */
 
@media (max-width:1500px){
   #footer{
        position: relative;
        clear: both;
        /* clear: both; */
        /* background: var(--bg); */
        display: list-item;
        align-items: center;
        justify-content: space-between;
        /* padding: 1.5rem 7%; */
        border-bottom: var(--border);
        left: 0;
        right: 0;
        z-index: 1000;

        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        position: absolute;
        width: 15%;
        height: 100%; /* Adjusted to be 75% of the parent height */
        background: var(--bg);

      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: flex-start;
      position: absolute;
      width: 15%;
      height: 100%; /* Adjusted to be 75% of the parent height */
      top: 20rem; /* Added to push it 25% down from the parent */
      background: var(--bg);
   }


   #footer .MenuItems {
        margin: auto;
        padding: 1%;
        width: 15rem;
        display: inline-table;
        overflow-x: scroll;
        grid-template-columns: repeat(auto-fit, 20rem);
        gap: 11.5rem;
        justify-content: center;
        line-height: 100%;
        margin-right: 12px;
        text-align: center;
        padding: 3rem;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        align-items: center;
        align-content: space-between;
    }

   #footer li {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      list-style: none;
   }

   #footer li a,
   #footer li button {
      padding: 2rem;
      border: var(--border);
      border-radius: 0.5rem;
   }

   #footer .MenuItemBtn {
      position: relative;
      width: 100%;
      margin-bottom: 10px;
      border: var(--border);
      border-radius: 0.5rem;
      top: 10%;
   }

   #footer .Home_mainu {
      text-align: left;
      border: var(--border);
      border-radius: 0.5rem;
      display: block;
      background: #010103;
   }

   #footer .Home_mainu:hover {
      background: #eee;
   }

   #footer .Home_mainu .Home_text {
      color: palevioletred;
      font-size: 19px;
   }

   #footer .Home_mainu .Home_icon {
      width: 25px;
      height: 25px;
   }
}
 
@media (max-width:991px){
    #footer{
        background: #24262b;
        background: #24262b;
        position: relative;
        clear: both;
        /* clear: both; */
        /* background: var(--bg); */
        display: list-item;
        align-items: center;
        justify-content: space-between;
        /* padding: 1.5rem 7%; */
        border-bottom: var(--border);
        bottom: 0;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 1000;

        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        position: absolute;
        width: 15%;
        height: 100%; /* Adjusted to be 75% of the parent height */
        top: 15rem; /* Added to push it 25% down from the parent */
        background: var(--bg);

      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: flex-start;
      position: absolute;
      width: 15%;
      height: 100%; /* Adjusted to be 75% of the parent height */
      top: 15rem; /* Added to push it 25% down from the parent */
      background: var(--bg);
   }


   #footer .MenuItems {
        margin: auto;
        padding: 1%;
        width: 15rem;
        display: inline-table;
        overflow-x: scroll;
        grid-template-columns: repeat(auto-fit, 20rem);
        gap: 11.5rem;
        justify-content: center;
        line-height: 100%;
        margin-right: 12px;
        text-align: center;
        padding: 3rem;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        align-items: center;
        align-content: space-between;
    }

   #footer li {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      list-style: none;
   }

   #footer li a,
   #footer li button {
      padding: 2rem;
      border: var(--border);
      border-radius: 0.5rem;
   }

   #footer .MenuItemBtn {
      position: relative;
      width: 100%;
      margin-bottom: 10px;
      border: var(--border);
      border-radius: 0.5rem;
      top: 10%;
   }

   #footer .Home_mainu {
      text-align: left;
      border: var(--border);
      border-radius: 0.5rem;
      display: block;
      background: #010103;
   }

   #footer .Home_mainu:hover {
      background: #eee;
   }

   #footer .Home_mainu .Home_text {
      color: palevioletred;
      font-size: 19px;
   }

   #footer .Home_mainu .Home_icon {
      width: 25px;
      height: 25px;
   }
}
 
@media (max-width:768px){
   #footer{
        background: #24262b;
        background: #24262b;
        position: relative;
        clear: both;
        /* clear: both; */
        /* background: var(--bg); */
        display: list-item;
        align-items: center;
        justify-content: space-between;
        /* padding: 1.5rem 7%; */
        border-bottom: var(--border);
        bottom: 0;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 1000;

        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        position: absolute;
        width: 15%;
        height: 100%; /* Adjusted to be 75% of the parent height */
        top: 15rem; /* Added to push it 25% down from the parent */
        background: var(--bg);

      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: flex-start;
      position: absolute;
      width: 15%;
      height: 100%; /* Adjusted to be 75% of the parent height */
      top: 15rem; /* Added to push it 25% down from the parent */
      background: var(--bg);
   }


   #footer .MenuItems {
        display: inline-flex;
        margin: auto;
        padding: 1%;
        width: 100%;
        display: flex;
        overflow-x: scroll;
        grid-template-columns: repeat(auto-fit, 20rem);
        gap: 11.5rem;
        justify-content: center;
        line-height: 100%;
        margin-right: 12px;
        text-align: center;
        padding: 3rem;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        align-items: center;
        align-content: space-between;
    }

   #footer li {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      list-style: none;
   }

   #footer li a,
   #footer li button {
      padding: 2rem;
      border: var(--border);
      border-radius: 0.5rem;
   }

   #footer .MenuItemBtn {
      position: relative;
      width: 100%;
      margin-bottom: 10px;
      border: var(--border);
      border-radius: 0.5rem;
      top: 10%;
   }

   #footer .Home_mainu {
      text-align: left;
      border: var(--border);
      border-radius: 0.5rem;
      display: block;
      background: #010103;
   }

   #footer .Home_mainu:hover {
      background: #eee;
   }

   #footer .Home_mainu .Home_text {
      color: palevioletred;
      font-size: 19px;
    }
    
    #footer .Home_mainu .Home_icon {
        width: 25px;
        height: 25px;
    }
}

@media (max-width: 600px) {
    #footer{
       top: 100%;
        position: relative;
        clear: both;
        /* clear: both; */
        /* background: var(--bg); */
        display: list-item;
        align-items: center;
        justify-content: space-between;
        /* padding: 1.5rem 7%; */
        border-bottom: var(--border);
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1000;

        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        position: absolute;
        width: 15%;
        height: 100%; /* Adjusted to be 75% of the parent height */
        background: var(--bg);

      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: flex-start;
      position: absolute;
      width: 100%;
      height: 15rem;
      background: var(--bg);
      gap: 1.5rem;
      padding: 1.5rem 7%;
      border-bottom: var(--border);
      
      left: 0;
      right: 0;
      z-index: 1000;
   }

   #footer .MenuItems {
        display: inline-flex;
        margin: auto;
        padding: 1%;
        width: 100%;
        display: flex;
        overflow-x: scroll;
        grid-template-columns: repeat(auto-fit, 20rem);
        gap: 11.5rem;
        justify-content: center;
        line-height: 100%;
        margin-right: 12px;
        text-align: center;
        padding: 3rem;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        align-items: center;
        align-content: space-between;
    }

   #footer li {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      list-style: none;
   }

   #footer li a,
   #footer li button {
      padding: 2rem;
      border: var(--border);
      border-radius: 0.5rem;
   }

   #footer .MenuItemBtn {
      position: relative;
      width: 100%;
      margin-bottom: 10px;
      border: var(--border);
      border-radius: 0.5rem;
      top: 10%;
   }

   #footer .Home_mainu {
      text-align: left;
      border: var(--border);
      border-radius: 0.5rem;
      display: block;
      background: #010103;
   }

   #footer .Home_mainu:hover {
      background: #eee;
   }

   #footer .Home_mainu .Home_text {
      color: palevioletred;
      font-size: 19px;
   }

   #footer .Home_mainu .Home_icon {
      width: 25px;
      height: 25px;
   }
}

@media (max-width:450px){
   #footer{
    position: relative;
        clear: both;
        /* clear: both; */
        /* background: var(--bg); */
        display: list-item;
        align-items: center;
        justify-content: space-between;
        /* padding: 1.5rem 7%; */
        border-bottom: var(--border);
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1000;

        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        position: absolute;
        width: 15%;
        height: 100%; /* Adjusted to be 75% of the parent height */
        background: var(--bg);

      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: flex-start;
      position: absolute;
      width: 100%;
      height: 15rem;
      background: var(--bg);
      gap: 1.5rem;
      padding: 1.5rem 7%;
      border-bottom: var(--border);
      left: 0;
      right: 0;
      z-index: 1000;
        
   }

   #footer .MenuItems {
        display: inline-flex;
        margin: auto;
        padding: 1%;
        width: 100%;
        display: flex;
        overflow-x: scroll;
        grid-template-columns: repeat(auto-fit, 20rem);
        gap: 11.5rem;
        justify-content: center;
        line-height: 100%;
        margin-right: 12px;
        text-align: center;
        padding: 3rem;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        align-items: center;
        align-content: space-between;
    }

   #footer li {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      list-style: none;
   }

   #footer li a,
   #footer li button {
      padding: 2rem;
      border: var(--border);
      border-radius: 0.5rem;
   }

   #footer .MenuItemBtn{
      position: relative;
      width: 100%;
      margin-bottom: 10px;
      border: var(--border);
      border-radius: 0.5rem;
  }

   #footer .Home_mainu {
      text-align: left;
      border: var(--border);
      border-radius: 0.5rem;
      display: block;
      background: #010103;
   }

   #footer .Home_mainu:hover {
      background: #eee;
   }

   #footer .Home_mainu .Home_text {
      color: palevioletred;
      font-size: 19px;
   }

   #footer .Home_mainu .Home_icon {
      width: 25px;
      height: 25px;
   }
}




 



.logo {
  font-size: 24px;
}


.links {
  display: flex;
}

.link {
  margin-right: 20px;
  cursor: pointer;
}













/* Responsive Styles */


 
nav {
   flex: 1;
   text-align: right;
 }
 nav ul 
 {
   display: contents;
    list-style: none;
 }
 
 nav ul li {
    display: table-row;
    list-style: 70px;
    /* this blocks are for styling the list elements */
 }
 
 nav ul li a {
    text-decoration: none;
    list-style: 70px;
    text-decoration: none;
    color: palevioletred;
    font-size: 28px;
    text-align: center;
    padding: 2rem;
    box-shadow: var(--box-shadow);
    border: var(--border);
    border-radius: 0.5rem;
    gap: 50px;
    margin: auto;
 }
 
 nav ul li a:hover {
    color: aqua;
 }
 
 nav ul li button {
    font-size: 20px;
    color: white;
    outline: none;
    border: none;
    background: transparent;
    cursor: pointer;
    font-family: sans-serif;
 }
 
 nav ul li button:hover {
    color: aqua;
 }
 
 .navbar {
    align-items: center;
    padding: 0px;
    padding-left: 50px;
    padding-right: 30px;
    /* this is for setting the dimensions of navigation bar */
 }




/* 
   this will make loging nice
*/
.loginbtn {
  font-size: 16px;
  color: #fff;
  background-color: transparent;
  border: none;
  cursor: pointer;
  transition: color 0.3s ease;
}

.loginbtn:hover {
  color: aqua;
}


 body .flex .navbar a{
    margin-left: 2rem;
    font-size: 2rem;
    color:var(--white);
 }
 
 body .flex .navbar a:hover{
    color:yellow;
 }
 
 body .flex .cart{
    margin-left: 2rem;
    font-size: 2rem;
    color:var(--white);
 }
 
 body .flex .cart:hover{
    color:yellow;
 }
 
 body .flex .cart span{
    padding:.1rem .5rem;
    border-radius: .5rem;
    background-color: var(--white);
    color:var(--blue);
    font-size: 2rem;
 }
 
 #menu-btn{
    margin-left: 2rem;
    font-size: 3rem;
    cursor: pointer;
    display: inline-block;
   color:var(--white);
   display: none;
 }
 
 
 .header .navbar a{
   margin: 0 1rem;
   font-size: 1.6rem;
   color: #fff;
 }
 
 .header .navbar a:hover{
   color: var(--main-color);
   border-bottom: .1rem solid var(--main-color);
   padding-bottom: .5rem;
 }
 
 .header .icons div{
   color: #fff;
   cursor: pointer;
   font-size: 2.5rem;
   margin-left: 2rem;
 }
 
 .header .icons div:hover{
   color: var(--main-color);
 }
 
 
 @media (max-width:768px){
   /*body .flex .navbar{
       top:99%; left:0; right:0;
       background-color: var(--blue);
       clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
       transition: .2s linear;
    }
 
    body .flex .navbar.active{
       clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);
    }
 
    body .flex .navbar a{
       margin:2rem;
       display: block;
       text-align: center;
       font-size: 2.5rem;
    }*/
 
    #menu-btn{
       display: inline-block;
    /*   position: absolute;
       width: 50px;
    height: 50px;
     left: 0%; 
    bottom: 1%;
    right: 1%;
       transition: .2s linear;*/
    }
    
    #menu-btn.fa-times{
       transform: rotate(180deg);
    }
 }
 
 @media (max-width:450px){
 
    .heading{
       font-size: 3rem;
    }
 }




.logo {
  font-size: 24px;
}


.links {
  display: flex;
}

.link {
  margin-right: 20px;
  cursor: pointer;
}
</style>

</style>