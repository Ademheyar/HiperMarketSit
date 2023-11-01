<?php 
   if(session_id() == "") session_start();
   if (!isset($ishome) or $_SESSION['on'] != 0){
      $_SESSION['on'] = 0;
      header("Location: Home.php");
      exit; // Make sure to include exit after the header redirect
   }
   include ('Template/msg.php');
?>

<div class="Main">
   <?php
      /*  include banner area  */
      include ('Template/_banner-area.php');
      /*  //include banner area  */
      include ('Template/shopbycolection.php');
      //  //include top sale section 
      //include ('Template/_top-sale.php');
      //include ('Template/_top-sale.php');
      //  //include top sale section 
     
   ?>  
   <script>
   const productGrid_container = document.querySelector('body .Main');
   create_list(productGrid_container, 'ls', 'bb', 'tit999e', 1,0);
   create_list(productGrid_container, 'hf', 'ldn', 'ti8899e', 1,1);
   </script>
</div>

<?php
    /*  include banner area  */
    //include ('Template/_banner-area.php');
    /*  //include banner area  */
    //include ('Template/shopbycolection.php');
    //  //include top sale section 
    //include ('Template/_top-sale.php');
    //  //include top sale section 
   /*
    //  //include special price section  
         //include ('Template/_special-price.php');
    //  //include special price section 

    //  //include new phones section  
        //include ('Template/_new-phones.php');
    //  //include new phones section  */


    /*  //include banner ads  */
    //include ('Template/_banner-ads.php');
    /*  //include banner ads  */

    /*  include blog area  */
    //include ('Template/_blogs.php');
    /*  include blog area  */

    // include footer.php file
    //include ('footer.php');
?>

</style>
<style>

/* Main Styles */

body .Main{
   overflow: auto;
   position: relative;
    top: 5%;
   align-items: flex-start;
   position: absolute;
   width: 100%;
   height: 100%;
   background: #f8f8ff;
}

/* media queries  */
 
@media (max-width:1500px){
   
   /* Main Styles */
   body .Main{
      overflow: auto;
      position: relative;
      top: 5%;
      align-items: flex-start;
      position: absolute;
      width: 100%;
      height: 100%;
      background: #f8f8ff;
   }
}
 
@media (max-width:991px){
   
   /* Main Styles */
   body .Main{
      overflow: auto;
      position: relative;
      align-items: flex-start;
      position: absolute;
      width: 100%;
      height: 100%;
      background: #f8f8ff;
   }
}
 
@media (max-width:768px){
   
   /* Main Styles */
   body .Main{
      overflow: auto;
      position: relative;
      top: 16%;
      align-items: flex-start;
      position: absolute;
      width: 100%;
      height: 100%;
      background: #f8f8ff;
   }
}
 
@media (max-width: 600px) {

   /* Main Styles */
   body .Main{
        overflow: auto;
        position: relative;
        align-items: flex-start;
        position: absolute;
        width: 100%;
        height: 100%;
        background: #f8f8ff;
   }
}

@media (max-width:450px){

   /* Main Styles */
   body .Main{
        overflow: auto;
        position: relative;
        align-items: flex-start;
        position: absolute;
        width: 100%;
        height: 100%;
        background: #f8f8ff;
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

@media (max-width: 600px) {

  .links {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .link {
    margin-bottom: 20px;
    margin-right: 0;
  }
}
</style>