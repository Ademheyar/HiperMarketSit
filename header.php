

<div class="header">
   <?php if(session_id() == "") session_start();  ?>
   <a href="#" class="logo">
      <img src="img/logo.jpg" alt="">
   </a>
   <input type='text' class='search_box' placeholder='Search' name="search_box">
   <div class="header_btns">
      <?php 
      $select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);

      if(isset($_SESSION['loged_user_type']) && $_SESSION['loged_user_type'] == 2) { ?>
         <li><a onclick="chart_start();" class="cart">Cart<span><?php echo $_SESSION['car_length']; ?></span></a></li>
      <?php } else { 
         // If the user is not logged in or has a different user type
         if(session_id() == "") session_start(); ?>      
         <li><a onclick="chart_start();" class="cart">Cart<span><?php echo $_SESSION['car_length']; ?></span></a></li>
      <?php } ?>   
   </div>
</div>

<style>


/* Header Styles */

/* about header */
 
.header{
   background: var(--bg);
   display: flex;
   gap: 1.5rem;
   align-items: center;
   justify-content: space-between;
   /*padding: 1.5rem 7%;*/
   border-bottom: var(--border);
   position: sticky;
   top: 0; left: 0; right: 0;
   padding: 6rem;
 }

 /* about logo on header*/
  
 .header .logo {
   margin-right: auto;
   position: fixed;
   font-size: 2.5rem;
 }

 /* about logo image */
 .header .logo img{
   height: 10rem;
 }
 

 /* 
   this will make search look good
*/

.search-container {
  display: flex;
}

.search_box {
   width: 100%;
  height: 40px;
  border-radius: 20px;
  border: 1px solid #ccc;
  padding: 10px 20px;
  font-size: 16px;
  outline: none;
   margin-right: auto;
   /*font-size: 2.5rem;*/

}
.search-box {
   /*width: 60%;
  height: 40px;
  border-radius: 20px;
  border: 1px solid gray;
  padding: 10px 20px;*/
}

.search-btn {
  width: 40px;
  height: 40px;
  background-color: blue;
  color: white;
  border-radius: 20px;
  border: none;
  cursor: pointer;
}


.search_box::placeholder {
  color: #999;
}
.header .search-form{
   position: absolute;
   top: 115%; right: 7%;
   background: #fff;
   width: 50rem;
   height: 5rem;
   display: flex;
   align-items: center;
   transform: scaleY(0);
   transform-origin: top;
 }
 
 .header .search-form input{
   height: 100%;
   width: 100%;
   font-size: 1.6rem;
   color: var(--black);
   padding: 1rem;
   text-transform: none;
 }
 
 .header .search-form label{
   cursor: pointer;
   font-size: 2.2rem;
   margin-right: 1.5rem;
   color: var(--black);
 }
 
 
 .header .search-form label:hover{
   color: var(--main-color);
 }


/* media queries  */
 
@media (max-width:1500px){
   /* Header Styles */
   .header{
      background: var(--bg);
      display: flex;
      gap: 1.5rem;
      align-items: center;
      justify-content: space-between;
      /*padding: 1.5rem 7%;*/
      border-bottom: var(--border);
      position: sticky;
      top: 0; left: 0; right: 0;
      z-index: 1000; 
      padding: 4%;
   }

   /* about logo on header*/
  
   .header .logo {
      
    position: initial;
    right: 85%;
    padding: 4px;
    padding-right: 7px;
   }

   /* about logo image */
   .header .logo img{
      height: 10rem;
   }
   

   .header .search_box{
      margin-right: auto;
      width: 100%;
      font-size: 2.5rem;
   }
}
 
@media (max-width:991px){
   /* Header Styles */
   .header{
      background: var(--bg);
      display: flex;
      gap: 1.5rem;
      align-items: center;
      justify-content: space-between;
      /*padding: 1.5rem 7%;*/
      border-bottom: var(--border);
      position: sticky;
      top: 0; left: 0; right: 0;
      z-index: 1000; 
      padding: 3rem;
   }

   /* about logo on header*/
  
   .header .logo {
      position: initial;
      right: 85%;
      padding: 4px;
      padding-right: 7px;
   }
  
   /* about logo image */
   .header .logo img{
      height: 10rem;
   }
   
   .header .search_box{
      margin-right: auto;
      width: 50%;
      font-size: 2.5rem;
   }
}
 
@media (max-width:768px){
   /* Header Styles */
    .header{
      background: var(--bg);
      display: flex;
      gap: 1.5rem;
      align-items: center;
      justify-content: space-between;
      /*padding: 1.5rem 7%;*/
      border-bottom: var(--border);
      position: sticky;
      top: 0; left: 0; right: 0;
      z-index: 1000; 
      padding: 3rem;
   }

   /* about logo on header*/
  
   .header .logo{
      left: 10px;
      top: 50px;
      bottom: 50%;
      font-size: 2.5rem;
   }
  
   /* about logo image */
   .header .logo img{
      height: 10rem;
   }

   .header .search_box{
      margin-right: auto;
      width: 50%;
      font-size: 2.5rem;
   }
}
 
@media (max-width: 600px) {
   /* Header Styles */
   .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 3rem;
   }
 
   /* about logo on header*/
  
   .header .logo {
      /*position: initial;
      right: 85%;
      padding: 4px;
      padding-right: 7px;*/
   }
  
   /* about logo image */
   .header .logo img{
      height: 10rem;
   }

   /* about search */
   .search-container {
      width: 100%;
      display: flex;
      justify-content: center;
   }

   .search-box {
      width: 80%;
      margin-bottom: 20px;
   }
}

@media (max-width:450px){
   /* Header Styles */
    .header{
      background: var(--bg);
      display: flex;
      gap: 1.5rem;
      align-items: center;
      justify-content: space-between;
      /*padding: 1.5rem 7%;*/
      border-bottom: var(--border);
      position: sticky;
      top: 0; left: 0; right: 0;
      z-index: 1000; 
      padding: 3rem;
   }
 
   
   /* about logo on header*/
  
   .header .logo {
      
      position: initial;
      right: 85%;
      padding: 4px;
      padding-right: 7px;
     }
  
     /* about logo image */
     .header .logo img{
        height: 10rem;
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
 
 
 @media (max-width:991px){
 
    #menu-btn{
      display: none;
      transition: .2s linear;
   }
   
   
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