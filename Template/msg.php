<?php
   if(session_id() == "") session_start(); // Start the session
    if(isset($_SESSION['msg'])){
      foreach($_SESSION['msg'] as $msg){
         echo '<div class="message"><span>'.$msg.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
      };
      $_SESSION['msg'] = array();
   };
?>
<style>
.message{
    background-color: var(--blue);
    position: sticky;
    
    top:0; left:0;
    z-index: 10000;
    border-radius: .5rem;
    background-color: var(--black);
    padding:1.5rem 2rem;
    margin:0 auto;
    max-width: 1200px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap:1.5rem;
}
 
.message span{
    font-size: 2rem;
    color:white;
 }
 
.message i{
    font-size: 2.5rem;
    color:var(--black);
    cursor: pointer;
}
 
.message i:hover{
    color:var(--red);
}
 
</style>