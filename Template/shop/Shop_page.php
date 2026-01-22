<?php 
  if(file_exists("config.php")) include("config.php");
  if(file_exists("../../config.php")) include("../../config.php");
  
  if(session_id() == "") session_start();
  $shop_found = 0;

  if (isset($_GET['shop_pag_name'])) {
    $_SESSION['selected_company_id'] = -1;
    // Update the session variable value
    $shop_id_info = $_GET['shop_pag_name'].',';
    $shop_ids = explode(',', $shop_id_info);
    for ($sid=0; $sid < count($shop_ids); $sid++) { 
        $Company_Id = $shop_ids[$sid];
        if($Company_Id == "") continue;
        $select_shop = $conn->query("SELECT * FROM `shops` WHERE Shop_Id='$Company_Id'");
        if($select_shop->num_rows > 0){
         // exit; // Make sure
         while($row = mysqli_fetch_assoc($select_shop)) {
            $_SESSION['User_Shops'][] = $row;
            $shop_found = 1;
            $_SESSION['selected_company_id'] = count($_SESSION['User_Shops'])-1;
            break;
        }
       }
        else $_SESSION['msg'][] = "can't Find User Shop In database.";
  }
}

if ($_SESSION['selected_company_id'] === -1) {
  $_SESSION['selected_company_id'] = count($_SESSION['User_Shops'])-1;
  if ($_SESSION['selected_company_id'] === -1) {
    
  }
}

 if (!isset($ishome) or $_SESSION['on'] != 5){
    $_SESSION['on'] = 5;
    $protocol = isset($_SERVER['HTTPS']);
    $doman = $_SERVER['HTTP_HOST'];
    $currontDir = dirname($_SERVER['REQUEST_URI']);
    $redirectURL = $protocol .$doman .$currontDir;
    header("Location: ../../Home.php");
     exit; // Make sure to include exit after the header redirect
  }
?>
<div class="Main">
  <main>
    <script>
        var shop_id = '<?php echo $_SESSION['User_Shops'][$_SESSION['selected_company_id']]['Shop_Id'];?>';
        var isset = 0;
        <?php if (isset($_SESSION['loged_user_info']) && $_SESSION['loged_user_info']['user_name'] != "") {
            if (isset($_SESSION['User_Shops'][$_SESSION['selected_company_id']])) {
                $owener_ids = explode(',', $_SESSION['User_Shops'][$_SESSION['selected_company_id']]['Shop_oweners_id']);
                for ($oid=0; $oid < count($owener_ids); $oid++) { 
                    $id = $owener_ids[$oid];
                    if($id == $_SESSION['loged_user_info']['User_id'])?>
                    isset = 1;
                <?php   
                }
            } 
        }?>
        var shop_p = <?php echo json_encode($_SESSION['User_Shops'][$_SESSION['selected_company_id']]['Shop_Page']);?>;
        var new_list = loadList(shop_p);
	    console.log(new_list);
        const shop_list_container = document.querySelector('body .Main');
        for(let info of new_list){
            create_list(shop_list_container, info[0], info[1], info[2], info[3], info[4], info[5], info[6], isset);
        }
    </script>
  </main>
  <?php //include ('footer.php');?>
</div>


<style>
    /* Main Styles */
    body .Main {
        overflow: auto;
        top: 5%;
        width: 100%;
        height: 100%;
        align-items: flex-start;
        background: #f8f8ff;
    }

  body .Main button {
        background-color: #f2f2f2;
        border: none;
        outline: none;
        cursor: pointer;
        width: auto;
        padding: 10px 20px;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        font-size: 16px;
        transition: background-color 0.3s;
  }
  
  body .Main main .DocumentsTab .doc_chart_frame  {
        background-color: green;
        height: auto;
  }
    
    body .Main .About_disc {
        align-items: flex-start;
        width: 100%;
        height: 30%;
        background: #eee;
    }
    
    body .Main .About_disc .Profile_image {
        position: absolute;
        width: 20%;
        text-align: center;
        top: 5px;
        border-image: round;
    }

    body .Main .About_disc .Profile_image img {
        width: 100%;
        top: 12rem;
        border-image: round;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
    }
    body .Main .About_disc .user_name {
        
        color: black;
        background: white;
    }
    
    body .Main .About_disc .user_about {
        text-align: left;
        color: gray;
    }

    body .Main h1, {
        margin-top: 0;
    }

    body .Main .profile_btn {
        overflow: auto;
        width: 100%;
        margin-bottom: 0px;
        display: inline-flex;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        gap: 10px;
    }
    
    body .Main .profile_btn button {
        background-color: #f2f2f2;
        border: none;
        outline: none;
        cursor: pointer;
        width: auto;
        padding: 10px 20px;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        font-size: 16px;
        transition: background-color 0.3s;
    }
    
    body .Main .tab {
        overflow: auto;
        width: 100%;
        margin-bottom: 0px;
        display: inline-flex;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        gap: 10px;
    }

    body .Main .tab button {
        background-color: #f2f2f2;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 10px 20px;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    body .Main .tab button:hover {
        background-color: #ddd;
    }

    body .Main .tab button.active {
        background-color: #ccc;
    }
    
    body .Main .tabcontent {
        min-height: 60rem;
        height: auto;
    }
    
    body .Main table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    body .Main table th, table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    
    
    
    
    .productCard {
        width: 200px;
        padding: 10px;
        margin-right: 20px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .productCard img {
        width: 100%;
        height: auto;
        margin-bottom: 10px;
    }

    .productCard h3 {
        margin-top: 0;
    }

    .productCard p {
        margin: 0;
    }

    /* media queries  */

@media (max-width:1500px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            top: 15%;
            align-items: flex-start;
            width: 100%;
            height: 100%;
            background: #f8f8ff;
        }
    }

@media (max-width:991px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            top: 14%;
            left: 0%;
            align-items: flex-start;
            width: 100%;
            height: 100%;
            background: #f8f8ff;
        }
    }

@media (max-width:768px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            top: 16%;
            left: 0%;
            align-items: flex-start;
            width: 100%;
            height: 100%;
            background: #f8f8ff;
       }
    }

@media (max-width: 600px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            left: 0;
            align-items: flex-start;
            width: 100%;
            height: 100%;
            background: #f8f8ff;
        }
    }

@media (max-width:450px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            left: 0;
            align-items: flex-start;
            width: 100%;
            height: 100%;
            background: #f8f8ff;
        }
    }
</style>