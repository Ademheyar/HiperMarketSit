<?php 
   if(session_id() == "") session_start();
   if (!isset($ishome) or $_SESSION['on'] != 0){
      $_SESSION['on'] = 0;
      header("Location: Home.php");
      exit; // Make sure to include exit after the header redirect
   }
?>

<div class="Main">
   <script>
   const productGrid_container = document.querySelector('body .Main');
   create_list(productGrid_container, 'BANNERS', 0,"", "50%", "H-BOX-LIST", "BANNERS", "", 0);
   create_list(productGrid_container, 'COLLECTIONS', 0,"", "25%", "H-BOX-LIST", "COLLECTIONS", "", 0);
   create_list(productGrid_container, 'SHOPS', 1,"", "40%", "H-BOX-LIST", "SHOPS", "", 0);
   create_list(productGrid_container, 'LIST TO THE LEFT', 1, "", "50%", "H-BOX-LIST", "ITEMS", "", 0);
   create_list(productGrid_container, 'LIST DOWN', 1, "", "", "V-BOX-LIST", "ITEMS", "", 0);
   
   </script>
   <!--<button class="tablinks">Favorite Shops</button>-->
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
   top: 16%;
   align-items: flex-start;
   width: 100%;
   height: 100%;
   background: #f8f8ff;
}

/* media queries  */
 
@media (max-width:1500px){
   
   /* Main Styles */
   body .Main{
      overflow: auto;
      top: 16%;
      align-items: flex-start;
      width: 100%;
      height: 100%;
      background: #f8f8ff;
   }
}
 
@media (max-width:991px){
   
   /* Main Styles */
   body .Main{
      overflow: auto;
      align-items: flex-start;
      width: 100%;
      height: 100%;
      background: #f8f8ff;
   }
}
 
@media (max-width:768px){
   
   /* Main Styles */
   body .Main{
      overflow: auto;
      top: 16%;
      align-items: flex-start;
      width: 100%;
      height: 100%;
      background: #f8f8ff;
   }
}
 
@media (max-width: 600px) {

   /* Main Styles */
   body .Main{
        overflow: auto;
        align-items: flex-start;
        width: 100%;
        height: 100%;
        background: #f8f8ff;
   }
}

@media (max-width:450px){

   /* Main Styles */
   body .Main{
        overflow: auto;
        align-items: flex-start;
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