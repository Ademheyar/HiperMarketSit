<?php
if(session_id() == "") session_start();

if(isset($_POST['pev_type'])){
    if($_SESSION['type_on'] > 0) $_SESSION['type_on']--;
    $_SESSION['focused_type'][$_SESSION['type_on']] = array();
}

if(isset($_POST['list_selected_type'])){
    $_SESSION['focused_type'][$_SESSION['type_on']] = array($_POST['product_type']);
    $_SESSION['type_on']++;
}

if(isset($_POST['pev_type'])){
    if($_SESSION['type_on'] > 0) $_SESSION['type_on']--;
    $_SESSION['focused_type'][$_SESSION['type_on']] = array();
}

if(isset($_POST['list_selected_type'])){
    $_SESSION['focused_type'][$_SESSION['type_on']] = array($_POST['product_type']);
    $_SESSION['type_on']++;
}
?>

<div class="shop_by_containers">
    <form class="shop_by_containers_titel" method="post">
        <input type="submit" class="shop_by_containers_titel_btn" value="---" name="pev_type">
        <h1 class="heading">SHOP BY COLLECTION</h1>
    </form>
    <div class="box-container">
    </div>
</div>
<style>

.shop_by_containers .box-container{
   width: 100%;
   display: flex; /* add flex display to make items horizontal */
   overflow-x: scroll; /* add horizontal scroll */
   grid-template-columns: repeat(auto-fit, 20rem);
    gap: 1.5rem;
    justify-content: center;
    line-height: 100%;
    margin-right: 2px;
    text-align: center;
    padding: 2rem;
    box-shadow: var(--box-shadow);
    border: var(--border);
    border-radius: 1.5rem;
    align-items: center;
    align-content: space-between;
 }
 .shop_by_containers .box-container::-webkit-scrollbar {
  width: 0px;
  height: 0px;
  background-color: transparent;
}

.shop_by_containers .box-container button{
   /* add some styling to the box items */
   background-color: #f5f5f5;
  border: 1px solid #ccc;
  height: 50px;
  margin-right: 10px;
  width: 200px;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  font-weight: bold;
  text-align: center;
  background-color: #ff990094; /* Green background */
  border: none; /* Remove borders */
  color: white; /* White text */
  padding: 12px 24px; /* Some padding */
  font-size: 16px; /* Set font size */
  cursor: pointer; /* Add a pointer cursor on hover */
  border-radius: 8px; /* Add rounded corners */
  transition: background-color 0.3s ease; /* Add a transition effect */

 }
 
.shop_by_containers .box-container button:last-child {
   margin-right: 0; /* remove margin-right from last item */
}
 .shop_by_containers .box-container button:hover {
   transform: scale(1.2);
   border-radius: .7rem;
   background-color: #3e8e41;
}

 .shop_by_containers .box-container .box .full_hiden_btn img{
    width: 100%;
 }
 .shop_by_containers .box-container .box .full_hiden_btn br{
    
    position: relative;
 }
.shop_by_containers .box-container .box .box_btns{
		width: 100%;
    text-align: center;
    display: -webkit-inline-box;
    display: flex;
    overflow: hidden;
    position: relative;
    justify-content: space-around;
 }

 .shop_by_containers .box-container .box img{
    height: 15rem;
 }
 
 .shop_by_containers .box-container .box h3{
    margin:1rem 0;
    font-size: 2.5rem;
    color:var(--black);
 }
 
 .shop_by_containers .box-container .box .price{
    font-size: 2.5rem;
    color:var(--black);
 }

 .shop_by_containers .shop_by_containers_titel {
    position: unset;
    text-align: center;
    display: inline-flex;
    padding: 2rem;
    border-radius: 0.5rem;
 }
 
 .shop_by_containers .shop_by_containers_titel .shop_by_containers_titel_btn{
    display: block;
    text-align: center;
    font-size: 1.7rem;
    padding:1.2rem 3rem;
    border-radius: .5rem;
    cursor: pointer;
    margin-top: 1rem;
 }
 
 .shop_by_containers .shop_by_containers_titel .shop_by_containers_titel_btn:hover {
    background-color: var(--black);
 }
 
</style>

<script src="js/Typelistscript.js"> </script>
<script>
   const container = document.querySelector('.shop_by_containers .box-container');
   var selected = "";
   var list = findHierarchy(selected, first_list);
   function clean_box(){
      var i = 0;
      while(i < container.children.length) {
         container.children[i].remove();
         i++;
      };
   }
   
   function add_box(){
      clean_box();
      clean_box();
      console.log("going to read list("+selected+" )");
      list = findHierarchy(selected+" ", first_list);
      console.log("out");
      console.log(list);
      if (list.length > 0) {
         list.forEach(word => {
            const blueDiv = document.createElement('button');
            blueDiv.textContent = word;
            container.appendChild(blueDiv);

            blueDiv.addEventListener('click', function(event) {
               if(selected == "") selected = word;
               else selected = selected + " " + word;
               add_box();
            });
         });
      }
   }
   add_box();
   //updateHiddenLabel();
  container.addEventListener('mousemove', (e) => {
    const containerRect = container.getBoundingClientRect();

    if (e.clientX <= containerRect.left + 500) {
      container.scrollBy({
        left: -200,
        behavior: 'smooth',
      });
    } else if (e.clientX >= containerRect.right - 500) {
      container.scrollBy({
        left: 200,
        behavior: 'smooth',
      });
    }
  });
</script>