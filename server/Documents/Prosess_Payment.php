<?php
session_start();
if(file_exists("config.php")) include("config.php");
  if(file_exists("../../config.php")) include("../../config.php"); // Your database connection script

// Enable error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Custom error handler to log errors
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    $error_message = "Error: [$errno] $errstr - $errfile:$errline";
    // Log error to a file
    error_log($error_message, 3, 'errors.log');
    // Display error message to user
    echo json_encode(['error_message' => $error_message, 'status' => 'Error', 'message' => 'An error occurred.']);
    exit();
}

set_error_handler('customErrorHandler');

// Custom exception handler
function customExceptionHandler($exception) {
    $error_message = "Exception: " . $exception->getMessage();
    // Log exception to a file
    error_log($error_message, 3, 'errors.log');
    // Display exception message to user
    echo json_encode(['status' => 'Exception', 'message' => 'An unexpected error occurred.']);
    exit();
}

set_exception_handler('customExceptionHandler');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $jsonimage_names = $_POST['dataobject'];
        $objects = json_decode($jsonimage_names);
        $activeChartIndex = $objects->activeChartIndex;
        $list_items = $objects->list_items; 
        $paymentList = $objects->paymentList; 

        $At_shop = $_SESSION['User_Shops'][$_SESSION['selected_company_id']]['Shop_Id'];
        $user_name = $_SESSION['loged_user_info']['user_name'];
        $user_id = $_SESSION['loged_user_info']['User_id'];
        $Seller_id = "";
        $customer_id = $objects->customer_id; 
        $document_tyep = "OnlineSell";

        if ($list_items !== null && $paymentList !== null) {
            $date = date('Y-m-d');
            $payments_extra = [];
            $payment_item_required = 0;
            $payment_open_drower = 0;
            $payment_print_slip = 1;
            $payment_customer_required = 0;
            $payment_enable = 0;
            $payment_change_allowed = 0;
            $payment_mark_pad = 0;
            $pay_index = 0;
            $brcod = "";

            // Create a unique document code
            $doc_code = gmdate('y:m') . "-11";
            $b = 0;
            $Uniq_doc_code = "";
            
            while (true) {
                $ex_doc = $doc_code . $b;
                $stmt = $conn->prepare("SELECT * FROM documents WHERE document_barcode = ?");
                $stmt->bind_param('s', $ex_doc);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $b = rand(0, 10000);
                } else {
                    $Uniq_doc_code = $ex_doc;
                    break;
                }
            }
            $brcod = $Uniq_doc_code;

            $docs_ = [];


            // Process each item in the cart 
            foreach ($list_items as $index => $iv) {
                if (isset($iv->ex_doc)) {
                    $doc_found_index = -1;
                    foreach ($docs_ as $doc_index => $doc) { if($doc['barcode'] === $iv->ex_doc) { $doc_found_index = $doc_index; break; }}
                    if($doc_found_index === -1){
                        $doc_found_index = 0;
                        $docs_[] = [
                            'barcode' => $iv->ex_doc,
                            'payments'=> [],
                            'items' => [],
                            'items_counted' => 0,
                            'Item_from_shop_ids' => "",
                            'pay_index' => 0,
                            'price' =>  0,
                            'pid' =>  0,
                            'T_pid' =>  0,
                            'def_pid' =>  0,
                            'disc' =>  0,
                            'T_disc' =>  0,
                            'tax' =>  0,
                            'T_tax' =>  0
                        ];
                    }
                    $docs_[$doc_found_index]['items_counted'] += 1;
                    // Fetch product details from database
                    $result = $conn->query("SELECT * FROM products WHERE id='$iv->id'");
                    if ($result->num_rows > 0) {
                        while ($it = $result->fetch_assoc()) {
                            // id, code, barcode, name, shop, color, size, qty, price, discount, tax
                            $itl = [
                                $iv->id, $iv->code, $iv->barcode, $iv->name, $iv->shop, $iv->color, $iv->size, $iv->Quantity, $iv->Price, $iv->discount, $iv->tax
                            ];
            
                            $docs_[$doc_found_index]['price'] += (float)$iv->Quantity * (float)$iv->Price;
                            $docs_[$doc_found_index]['disc'] += (float)$iv->discount;
                            $docs_[$doc_found_index]['tax'] += (float)$iv->tax;
                            $docs_[$doc_found_index]['items'][] = $itl;
                            $docs_[$doc_found_index]['Item_from_shop_ids'] .= $it['at_shop'].',';
                            $item_tobechanged[] = [
                                $iv->id, (string)$it['more_info'], 0, (string)$iv->shop, (string)$iv->code, (string)$iv->color, (string)$iv->size, (string)$iv->Quantity
                            ];
                            unset($list_items[$index]);
                          }
                    }
                }
            }

            $p = 0;
            // Process payment list
            $allshopPaymentTools = [];

            if (isset($_SESSION['loged_user_info']['User_work_shop'])) {
                  $user_shops = json_decode($_SESSION['loged_user_info']['User_work_shop'], true);
                  $shops = array_column($user_shops, 0);
          
                  foreach ($shops as $shopId) {
                      if (empty($shopId)) continue;
          
                      $result = $conn->query("SELECT * FROM shops WHERE Shop_Id='$shopId'");
                      if ($result->num_rows > 0) {
                          $shop = $result->fetch_assoc();
                          $shopPaymentTools = json_decode($shop['Shop_Payment_Tools'], true) ?? [];
                          $allshopPaymentTools = array_merge($allshopPaymentTools, $shopPaymentTools);
                      }
                  }
              }
            $ex_pid_peyment = []; // $objects->ex_pid_peyment; 

            while ($p < count($paymentList)) {
                if ($paymentList[$p]->name !== "" && $paymentList[$p]->method !== "" && (isset($paymentList[$p]->external_doc)) ) {                    
                    $doc_found_index = -1;
                    foreach ($docs_ as $doc_index => $doc) { if($doc['barcode'] === $paymentList[$p]->external_doc) { $doc_found_index = $doc_index; break; }}
                    if($doc_found_index === -1) {
                        $doc_found_index = 0;
                        $docs_[] = [
                            'barcode'=> $paymentList[$p]->external_doc,
                            'payments'=> [],
                            'items' => [],
                            'items_counted' => 0,
                            'Item_from_shop_ids' => "",
                            'pay_index' => 0,
                            'price' =>  0,
                            'pid' =>  0,
                            'T_pid' =>  0,
                            'def_pid' =>  0,
                            'disc' =>  0,
                            'T_disc' =>  0,
                            'tax' =>  0,
                            'T_tax' =>  0
                        ];
                    }
                    $docs_[$doc_found_index]['pay_index'] += 1;
                    $rows = 0;
                    foreach ($allshopPaymentTools as $r) {
                        if ($r[0] === $paymentList[$p]->name && $r[1] === $paymentList[$p]->method) {
                            $rows = $r;
                            break;
                        }
                    }
                    if ($rows) {
                        $c = (float)$paymentList[$p]->Paid;
    
                        if ($rows[6] === 1) $payment_enable += 1;
                        if ($rows[7] === 1 && $payment_customer_required === 0) $payment_customer_required = 1;
                        if ($rows[8] === 1 && $payment_print_slip === 0) $payment_print_slip = 1;
                        if ($rows[9] === 1 && $payment_change_allowed === 0) $payment_change_allowed = 1;
                        if ($rows[10] === 1 && $payment_mark_pad === 0) $payment_mark_pad = 1;
                        if ($rows[11] === 1 && $payment_open_drower === 0) $payment_open_drower = 1;
                        //if ($rows[11] === 1 && $payment_item_required === 0) $payment_item_required = 1;
    
                        //if ($rows[11] && !$rows[11]) {
                            //$docs_[$doc_found_index]['price'] += $c;
                            //$def_pid += $c;
                        //}
    
                        if ($docs_[$doc_found_index]['price'] - $docs_[$doc_found_index]['disc'] === $docs_[$doc_found_index]['pid']) {
                            $payments_extra[] = [
                                (string)$docs_[$doc_found_index]['pay_index'], $paymentList[$p]->name, $paymentList[$p]->method, (string)$paymentList[$p]->Paid, $date, $date, $date, $user_id, (string)$rows[9], $paymentList[$p]->isPaid,  $paymentList[$p]->external_doc
                            ];
                        } else {
                            if ($docs_[$doc_found_index]['pid'] + $c > $docs_[$doc_found_index]['price'] - $docs_[$doc_found_index]['disc']) {
                                $pr = floor(($docs_[$doc_found_index]['price'] - $docs_[$doc_found_index]['disc']) / $item['price']);
                                $pl = $pr - $pid;
    
                                if ($c > $pl) {
                                    $e = $c - $pl;
                                    $payments_extra[] = [
                                        (string)$docs_[$doc_found_index]['pay_index'], $paymentList[$p]->name, $paymentList[$p]->method, (string)$e, $date, $date, $date, $user_id, (string)$rows[9], $paymentList[$p]->isPaid,  $paymentList[$p]->external_doc
                                    ];
                                    $c = $pl;
                                } else {
                                    $c = $pl;
                                }
                            }
    
                            if ($rows[6]) {
                                $docs_[$doc_found_index]['pid'] += $c;
                                $docs_[$doc_found_index]['T_pid'] += (float)$paymentList[$p]->Paid;
                            }
    
                            $docs_[$doc_found_index]['payments'][] = [
                                (string)$docs_[$doc_found_index]['pay_index'], $paymentList[$p]->name, $paymentList[$p]->method, (string)$c, $date, $date, $date, $user_id, (string)$rows[10], $paymentList[$p]->isPaid, ""
                            ];
                        }
    
                    }
                    $p += 1;
                }
            }

            if(count($payments_extra)) {
                // balance all paymenst for each items
                foreach ($docs_ as $doc_index => $doc) {  
                    while($doc['price'] - $doc['disc'] !== $doc['pid'] && count($payments_extra)) {
                        
                        $amount_needed = $doc['price'] - $doc['disc']- $doc['pid'];
                        $pay_index = $doc['pay_index'];
                        $paymen_infos = [];
                        $added = 0;
                        $left =  $amount_needed;
                        foreach ($payments_extra as $payment_index => $payment_extra) {
                            $pay_index += 1;
                            if($added < $amount_needed) {
                                $c = $found = $payment_extra[3];
                                if($added > $left){
                                    $c = $found - $left;
                                    $found = $left;
                                }
                        
                                $added += $found;
                                $left -= $found;
    
                                $paymen_infos[] = [
                                    (string)$pay_index, 
                                    $payment_extra[1], $payment_extra[2], 
                                    (string)$found, $payment_extra[4], $date, $payment_extra[6], 
                                    $payment_extra[7], $payment_extra[8], $payment_extra[9], $payment_extra[10]
                                ];
    
                                $payments_extra[$payment_index][3] -= $c;
                                if($payments_extra[$payment_index][3] === 0) unset($payments_extra[$payment_index]);
                            }
                            else break;
                        }
                        $doc['payments'] =  array_merge($doc['payments'], $paymen_infos);
                        $doc['pid'] += $amount_needed;
                    }
                }

                foreach ($payments_extra as $payment_index => $payment_extra) {
                    foreach ($docs_ as $doc_index => $doc) {  
                        $docs_[$doc_index]['pay_index'] += 1;
                        if($payment_extra[10] === $doc['barcode']){
                            $docs_[$doc_index]['payments'][] = [
                                (string)$docs_[$doc_index]['pay_index'],
                                    $payment_extra[1], $payment_extra[2], 
                                    $payment_extra[3], $payment_extra[4], $date, $payment_extra[6], 
                                    $payment_extra[7], $payment_extra[8], $payment_extra[9], $payment_extra[10]
                            ];
                             $docs_[$doc_index]['pid'] += floor($payment_extra[3]);
                            unset($payments_extra[$payment_index]);
                        }
                    }
                }
            }

            // putt etrapide as change
            
            
            // Finalizing the transaction and updating the database
            foreach ($docs_ as $doc_index => $doc) {
                if ($doc['items_counted'] > 0 || $doc['payments'] !== []) {
                    $str_item = json_encode($doc['items']);
                    $str_payment = json_encode($doc['payments']);
                    if($doc['barcode'] === "") { 
                        $doc_ = [$brcod, '', $At_shop, $user_id, $customer_id, $Seller_id, $document_tyep, $str_item, $doc['items_counted'], $doc['price'], (string)$doc['pid'], $doc['T_disc'], $doc['T_tax'], $str_payment, $date,  $date, $date];
                       
                        if ($doc['items_counted'] > 0) {
                            $Item_from_shop_ids=$doc['Item_from_shop_ids'];
                            $items_counted=$doc['items_counted'];
                            $price=$doc['price'];
                            $pid=$doc['pid'];
                            $T_disc=$doc['T_disc'];
                            $T_tax=$doc['T_tax'];
                            $result = $conn->query("INSERT INTO `documents`(`document_barcode`, `documents_extension_barcode`, `At_Shop_Id`, `Items_At_Shop`, `user_id`, `customer_id`, `Seller_id`, `document_type`, `item`, `qty`, `price`, `pid`, `discount`, `tax`, `payments`, `document_created_date`, `document_expire_date`, `document_updated_date`) VALUES ('$brcod','', '$At_shop', '$Item_from_shop_ids', '$user_id', '$customer_id', '$Seller_id', '$document_tyep', '$str_item', $items_counted, $price, $pid, $T_disc, $T_tax, '$str_payment', '$date',  '$date', '$date')");
                            if($result) echo json_encode(['status' => 'Success', 'doc_' => $doc_, 'message' => 'Transaction completed successfully!']);
                            else echo json_encode(['status' => 'Eroor', 'doc_' => $doc_, 'message' => 'Transaction completed Failed! '.$conn->error]);
                        } else {
                            echo json_encode(['status' => 'NoItems', 'message' => 'No new items to process.']);
                        }
                    }
                    else {
                        $doc_ = [$doc['barcode'], '', $At_shop, $user_id, $customer_id, $Seller_id, $document_tyep, $str_item, $doc['items_counted'], $doc['price'], (string)$doc['pid'], $doc['T_disc'], $doc['T_tax'], $str_payment, $date,  $date, $date];
                        // Updating the existing document
                        $Item_from_shop_ids = $doc['Item_from_shop_ids'];
                        $items_counted = $doc['items_counted'];
                        $price = $doc['price'];
                        $pid = $doc['pid'];
                        $T_disc = $doc['T_disc'];
                        $T_tax = $doc['T_tax'];
                        
                        $result = $conn->query("UPDATE `documents` SET `Items_At_Shop` = '$Item_from_shop_ids', `item` = '$str_item', `qty` = $items_counted, `price` = $price, `pid` = $pid, `discount` = $T_disc, `tax` = $T_tax, `payments` = '$str_payment', `document_updated_date` = '$date' WHERE `document_barcode` = '{$doc['barcode']}'");
                        
                        if($result) echo json_encode(['status' => 'Success', 'doc_' => $doc_, 'message' => 'Document updated successfully!']);
                        else echo json_encode(['status' => 'Error', 'doc_' => $doc_, 'message' => 'Document update Failed! '.$conn->error]);
                     }
                }
            }
        } else {
            echo json_encode(['status' => 'Error', 'message' => 'Invalid input data.']);
        }
    } else {
        echo json_encode(['status' => 'MethodNotAllowed', 'message' => 'Only POST method is allowed.']);
    }
} catch (Exception $e) {
    customExceptionHandler($e);
} 
?>