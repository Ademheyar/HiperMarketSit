<?php 
if (session_id() == "") session_start();

if (isset($_POST['Go_back'])) {
    if ($_SESSION['previous_page']){
    header("Location: ".array_pop($_SESSION['previous_page']));
    }
    else {
      $_SESSION['msg'][] = "user work shop not found";
        $_SESSION['on'] = 6;
        header("Location: /Home.php");
       }
    exit;
}

  
  if(file_exists("config.php")) include("config.php");
  if(file_exists("../config.php")) include("../config.php");
 if(file_exists("../../config.php")) include("../../config.php");
 
  if(!isset($conn)){
        $protocol = isset($_SERVER['HTTPS']);
        $doman = $_SERVER['HTTP_HOST'];
        $currontDir = dirname($_SERVER['REQUEST_URI']);
        $DIRPATHS = explode('/', $currontDir);
        $redirectURL = $protocol .$doman .$currontDir;
        include("../../config.php");
    }
$shop_creater_page = "Template/shop/List_my_shop.php";

if(file_exists("Template/shop/List_my_shop.php")) $shop_creater_page = "Template/shop/List_my_shop.php";
if(file_exists("../Template/shop/List_my_shop.php")) $shop_creater_page = "../Template/shop/List_my_shop.php";
if(file_exists("../../Template/shop/List_my_shop.php")) $shop_creater_page = "../../Template/shop/List_my_shop.php";

  if(file_exists("Template/shop/shop_actions.php")) include 'Template/shop/shop_actions.php';
  if(file_exists("../config.php")) include("../config.php");
 if(file_exists("../../config.php")) include("../../config.php");

?>
<div class="Main">
    <main>
      
        <div class="tab">
          <form id='Go_back' class='input-group-Go_back' method="POST">
            <button type='submit'class='submit-btn' name="Go_back">Back</button>
            </form>
        </div>
        <div id="user_list_shop_div_id" class="viewprofiletabcontent shopprofiletabcontent">
        </div>
    </main>
</div>
<script>
   function opennewshopTab(evt, tabName) {
      // Get all tab content elements and hide them
      const shopprofiletabContent = document.getElementsByClassName("shopprofiletabcontent");
      for (let i = 0; i < shopprofiletabContent.length; i++) {
          shopprofiletabContent[i].style.display = "none";
      }


      // Remove 'active' class from all shopprofiletablinks

      const tabLinks = document.getElementsByClassName("shopprofiletablinks");
      for (let i = 0; i < tabLinks.length; i++) {
          tabLinks[i].classList.remove("active");
      }

      // Show the selected tab and mark the corresponding tablink as active
        const selectedtab = document.getElementById(tabName);
        selectedtab.style.display = "block";
        selectedtab.classList.add("active");

        // Check if the selected tab's innerHTML is empty
        if (selectedtab.innerHTML.trim() === "") { // Use a single '=' to set and '===' to compare
            let url = '';
            switch(tabName){
                case 'user_list_shop_div_id':
                    url = '<?php echo $shop_creater_page; ?>'; 
                    break;
            }
            if(url !== ''){
                try {
                    fetch(url).then((response) => {
                        if(response.ok) return response.text();
                        else console.log('Network response was not ok');
                        
                    }).then((data) => { 
                        selectedtab.innerHTML = data;

                        const scripts = selectedtab.getElementsByTagName('script');
                        for(let script of scripts){
                            console.log('Loading file script.innerHTML : ', script);
                            eval(script.innerHTML);
                        }
                        selectedtab.datasetloaded = 'true';
                    })
                    .then((error) => { console.log('Error fetch content : ', error);});
                } catch (error) {
                    console.log('Error Loading file : ', error);
                }
            }
        }
   }
   opennewshopTab("", 'user_list_shop_div_id');
  </script>

<style>
    body .Main {
        overflow: hidden;
        top: 5%;
        width: 100%;
        height: 100%;
        align-items: flex-start;
        background: #f8f8ff;
    }
     /* Main Styles */
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
  
    body .Main h1, {
        margin-top: 0;
    }

    body .Main .profile_btn { 
        display: inline-flex;
        overflow: auto;
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
    
    body .Main .shopprofiletabcontent {
        min-height: 60rem;
        height: auto;
    background-color: #eee;
    box-shadow: var(--box-shadow);
    border: var(--border);
    border-radius: 1.5rem;
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
    
    body .Main .viewprofiletabcontent {
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
            top: 5%;
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

    /* Main Styles */
    body .Main {
        overflow: auto;
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
            height: auto;
            display: flex;
            flex-wrap: wrap;
    }
    
    body .Main .User_Profile_Info {
        align-items: flex-start;
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        column-gap: 5.0rem;
        row-gap: 1rem;
        justify-content: center;
        align-items: center;
    }

    body .Main .User_Profile_Info .company_followers_div .Follow_btn {
        background-color: #3462dd;
        color: white;
        /*position: absolute;*/
        border-radius: 25%;
        padding: 1px 5px;
        font-size: 10px;
        margin-left: 60px;
        margin-top: -14px;
    }

    body .Main .User_Profile_Info .profile_btn .contact_container {
        position: absolute;
        margin-top: -200;
        display: none;
        overflow-y: auto;
        height: 200px;
        width: 200px;
        box-shadow: var(--box-shadow);
        border: var(--border);
    }
    
    body .Main .User_Profile_Info .Profile_image {
        
        width: 25%;
        text-align: center;
        top: 5px;
        border-image: round;
    }

    body .Main .User_Profile_Info .Profile_image img {
        width: 100%;
        top: 12rem;
        border-image: round;
        box-shadow: var(--box-shadow);
        border: var(--border);
        border-radius: 1.5rem;
    }
    body .Main .User_Profile_Info .user_name {
        
        color: black;
        background: white;
    }
    
    body .Main .User_Profile_Info .user_about {
        text-align: left;
        color: gray;
    }
    
    body .Main .User_Profile_Info .profile_btn button {
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
    body .Main h1, {
        margin-top: 0;
    }

    body .Main .profile_btn { 
        display: inline-flex;
        gap: inherit;
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
    
    body .Main .shopprofiletabcontent {
        min-height: 60rem;
        height: auto;
    background-color: #eee;
    box-shadow: var(--box-shadow);
    border: var(--border);
    border-radius: 1.5rem;
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
            align-items: flex-start;
            background: #f8f8ff;
        }
    }

@media (max-width:991px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            align-items: flex-start;
            background: #f8f8ff;
        }
    }

@media (max-width:768px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            align-items: flex-start;
            background: #f8f8ff;
       }
    }

@media (max-width: 600px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            align-items: flex-start;
            /*position: absolute;*/
            background: #f8f8ff;
        }
    }

@media (max-width:450px) {

        /* Main Styles */
        body .Main {
            overflow: auto;
            align-items: flex-start;
            background: #f8f8ff;
        }
    }
</style>