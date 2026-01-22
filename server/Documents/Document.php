<?php
  if(file_exists("config.php")) include("config.php");
  if(file_exists("../config.php")) include("../config.php");
  if(file_exists("../../config.php")) include("../../config.php");

    // PHP code
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if (session_id() == "") session_start();

    $result = [];
    $sql = "";
    $postData = array();
    $list_clumens = [];
    $Uniq_doc_code = "";

    if(isset($_POST['Search_Like_Query'])){
      $query = $_POST['Search_Query_value'];
      $search_what = $_POST['search_what'];
      if(($search_what == "" || $search_what == "DOCUMENT")){
          $User_result = $conn->query("SELECT * FROM documents WHERE document_barcode LIKE '%$query%'");
          while ($DOCUMENT_ROW = $User_result->fetch_assoc()) {
            $result[] = ["DOCUMENT", $DOCUMENT_ROW];
          }
      }
    }

    if(isset($_POST['GET_UNIQE_DOC_ID'])){
      $for = $_POST['FOR'];

      // Create a unique document code
      $doc_code = gmdate('y:m')."-11";
      $b = 0;
      while (1) {
         $ex_doc = $doc_code."".$b;
         $result = $conn->query("SELECT * FROM documents WHERE document_barcode='$ex_doc'");
         if ($result->num_rows > 0) {
            $b = rand(0, 10000);
         } else {
            $Uniq_doc_code = $ex_doc;
            break;
        }
      }
    }

    if(isset($_POST['ADD_UPDATE_DOCUMENT'])){
      $query = $_POST['dowhat'];
      $Company_Id = $_SESSION['Selected_Shop']['Shop_Id'];
      $Company_columens_result = $conn->query("SELECT * FROM documents");
      if ($Company_columens_result->num_rows > 0) {
        while ($row = $Company_columens_result->fetch_assoc()) {
            $list_clumens = array_keys($row);
            break;
        }
      }
      foreach($list_clumens as $column){
        if(isset($_POST[$column])) $postData[$column] = $_POST[$column];
      }

      if(!empty($postData)){
        // build sql query 
        if (isset($_POST['document_id'])){
          // update
          $sql = "UPDATE documents SET ";
          foreach ($postData as $key => $value) {
            $sql .= "$key = '$value',";
          }
          $sql = rtrim($sql, ', ') . "WHERE document_id = ". $_POST['document_id'];
        }
        else // insert
        {
          $columns = implode(', ', array_keys($postData));
          $values = "'".implode(', ', array_values($postData))."'";
          $sql = "INSERT INTO documents ($columns) VALUES ($values)";
        }
      }
      if(!empty($sql)){
        mysqli_query($conn, $sql);
      }
    }
    //$values = ['id', 'name', 'code', 'type', 'barcode', 'at_shop', 'quantity', 'cost', 'tax', 'price', 'include_tax', 'price_change', 'more_info', 'images', 'description', 'service', 'default_quantity', 'active'];
    //$shops_columens = ['Shop_Id', 'Shop_name', 'Shop_brand_name', 'shop_type', 'Shop_oweners_id', 'Shop_linke', 'shop_email', 'shop_phone_no', 'Shop_location', 'Shop_about', 'Shop_rate', 'Shop_likes', 'Shop_followers', 'Shop_items', 'Shop_workers', 'Shop_password', 'Shop_contry', 'Shop_settings', 'Shop_Page', 'Shop_profile_img', 'Shop_banner_imgs', 'Shop_payment_r', 'Shop_balance', 'Shop_payment_info', 'Shop_isenable'];
    //[`document_id`, `document_barcode`, `documents_extension_barcode`, `user_id`, `customer_id`, `document_type`, `item`, `qty`, `price`, `discount`, `tax`, `payments`, `document_created_date`, `document_expire_date`, `document_updated_date`]
    // Create the response array
    $response = array(
    'sql' => $sql,
    'Udoc_code' => $Uniq_doc_code,
    'postData' => $postData,
    'list_clumens' => $list_clumens,

    'result' => $result
    );

    // Encode the response array as JSON
    $jsonResponse = json_encode($response);

    // Close the database connection
    $conn->close();

    // Echo the JSON response
    echo $jsonResponse;
?>