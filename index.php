<?php
   if(session_id() == "") {
      session_start();
      $_SESSION['on_view'] = 0;
      $_SESSION['car_length'] = 0;
      $_SESSION['car'] = array(array());
      
      $_SESSION['type_on'] = 0;
      $_SESSION['focused_type'] = array();

      
      setcookie("std_name", "name");
      setcookie("std_type", "type");
      setcookie("std_code", "code");
      setcookie("std_barcode", "barcode");
      setcookie("std_active", "1");
      setcookie("std_def_qty", "0");
      setcookie("std_service", "1");
      setcookie("std_disc", "disc");

      setcookie("std_price_cost", "200");
      setcookie("std_markup", "100");
      setcookie("std_price_sale", "400");
      setcookie("std_include_tax", "0");
      setcookie("std_allowed", "1");

      setcookie("std_img_names", "");
      setcookie("std_img_path", "");
      
      setcookie("std_info", "{{0,0}}");

      /*
      $p_type = $_POST['p_type'];
      $p_info = $_POST['p_info'];
      $p_barcode = $_POST['p_barcode'];
      $p_Service = isset($_POST['p_Service']); 
      $p_Def_qty = isset($_POST['p_Def_qty']);
      $p_active = isset($_POST['p_active']);
      $p_ptype = str_replace(' ', '/', $p_type);
      $p_price_cost = $_POST['p_price_cost'];
      $p_markup = $_POST['p_markup'];
      $p_sale_price = $_POST['p_price_sale'];
      // TODO: price include tax and allowe price change is not working tinke about it
      $p_include_tax = isset($_POST['p_include_tax']);
      $p_change_allowed = isset($_POST['p_change_allowed']);
      $p_image = str_replace(' ', '_', $_FILES['p_image']['name']);
      $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
      $p_path_name = str_replace(' ', '_', $p_name);
      $p_image_folder = $main_p."/img/products/".$p_ptype."/".$p_path_name."/".$p_code;
      $p_image_path = $p_image_folder."/".$p_image; 
      $p_disc = $_POST['p_disc'];
      $p_info = $_POST['p_info'];
      
      $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
      $p_path_name = str_replace(' ', '_', $p_name);
      $p_image_folder = $main_p.'/img/products/'.$p_ptype."/".$p_path_name."/".str_replace('#', '', $p_code);
      $p_image_path = $p_image_folder."/".$p_image;
   
      $insert_query = mysqli_query($conn, "INSERT INTO `products`(name, code, type, barcode, cost, tax, price, include_tax, price_change, images, more_info, Description, Service, Default_Quantity, Active) VALUES('$p_name', '$p_code', '$p_type', '$p_barcode', '$p_price_cost', '$p_markup' , '$p_sale_price', '$p_include_tax', '$p_change_allowed', '$p_image', '$p_info', '$p_disc', '$p_Service', '$p_Def_qty', '$p_active')") or die('query failed');
     
   */   

   }
   include('Home.php');
?>
