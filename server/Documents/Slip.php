<?php

session_start();

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

        if(file_exists("config.php")) include("config.php");
        else if(file_exists("../../config.php")) include("../../config.php"); // Your database connection script
        else {
           echo json_encode(['status' => 'Error', 'message' => 'config Not Found.']);
            exit();
        }
        
        // Function to get spare text
        function get_sparet($width) {
            return str_repeat("*", $width) . "\n";
        }
        
        function get_sparet_0($width) {
            return str_repeat("#", $width) . "\n";
        }
        
        function get_sparet_1($width) {
            return str_repeat("-", $width) . "\n";
        }
        
        // Function to get spare text
        function get_sparet_2($width) {
            return str_repeat("_", $width) . "\n";
        }

        function get_sparet_3($width) {
            return str_repeat("~", $width) . "\n";
        }

        // Function to fetch user data
        function find_user($v, $conn) {
                $return=[];
            $users = $conn->query("SELECT * FROM users WHERE User_id ='$v' OR user_name='$v'");
            if ($users->num_rows > 0) {
                while ($row = $users->fetch_assoc()) {
                    $return[] = $row;
                }
            }
            if ($return) return $return;
            else return null;
        }
        
        // Function to fetch shop data
        function find_shop($id, $conn) {
            $return = [];
            $Shops = $conn->query("SELECT * FROM shops WHERE Shop_Id='$id'");
            if ($Shops->num_rows > 0) {
                while ($row = $Shops->fetch_assoc()) {
                    $return[] = $row;
                }
            }

            if ($return) return $return;
            else echo json_encode(['status' => 'Error', 'message' => "found shop ".json_encode($return)]);
        }
        
        // Function to format text with width
        function add_text_($width, $value) {
            $ret = "";
            $i = 0;
            for ($j = 0; $j < strlen($value); $j++) {
                $ret .= $value[$j];
                $i++;
                if ($i == intval($width)) {
                    $ret .= "\n";
                    $i = 0;
                }
            }
            return $ret;
        }
        
        
        
        // Function to get links
        function get_links($shop) {
            $v = $shop[0]['Shop_linke'];
            $ret = "";
            if ($v && strpos($v, "+") !== false) {
                $location = explode("+", $v);
                foreach ($location as $l) {
                    $ret .= $l . "\n";
                }
            } elseif ($v) {
                $ret .= $v . "\n";
            }
            return $ret;
        }
        
        // Function to get phone number
        function get_Shop_infos($shop) {
            $items_lists = json_decode($shop[0]['Shop_contact'], true);
            $ret = "";
            foreach ($items_lists as $l) {
                $ret .= $l[0].' : '.$l[1]. "\n";
            }
            return $ret;
        }
        
        // Function to get receipt number
        function get_receipt_no($doc) {
            return "Receipt No : " . $doc['document_barcode'] . "\n";
        }
        
        // Function to get extension receipt number
        function get_extension_receipt_no($doc) {
            return "Extension Receipt No :  " . $doc['documents_extension_barcode'] . "\n";
        }
        
        // Function to get date
        function get_date($doc) {
            return "Date :  " . $doc['document_created_date'] . "\n";
        }
        
        // Function to get updated date
        function get_updated_date($doc) {
            return "Updated Date :  " . $doc['document_updated_date'] . "\n";
        }
        
        // Function to get due date
        function get_due_date($doc) {
            return "Due Date :  " . $doc['document_expire_date'] . "\n";
        }
        
        // Function to get user information
        function get_user($doc, $conn) {
            $slip = "";
            $user_list = find_user($doc['user_id'], $conn);
            if ($user_list) {
                $slip .= "User : " . $user_list[0]['user_name']. "\n";
            }
            return $slip;
        }
        
        // Function to get seller information
        function get_seller($doc, $conn) {
            $slip = "";
            $seller = find_user($doc['Seller_id'], $conn);
            if ($seller) {
                $slip .= "Seller : " . $seller[0]['user_name'] . "\n";
            }
            return $slip;
        }
        
        // Function to get customer information
        function get_customer($doc, $conn) {
            $slip = "";
            if (!empty($doc['customer_id'])) {
                $customer = find_user($doc['customer_id'], $conn);

                if ($customer) {
                    $slip .= "Customer : " . $customer[0]['user_name'] . "\n";
                    $slip .= "Phone No : " . $customer[0]['user_phone_No'] . "\n";
                }
            }
            return $slip;
        }
        
        // Function to get items
        function get_items($doc, $width) {
            $slip = "";
            $items_lists = json_decode($doc['item'], true);
        
            $shop = "";
            $color = "";
            $size = "";
            $PRICE = 0;
            $QTY = 0;
            $Disc = 0;
            $TAX = 0;
            $payments = "";
        
            $v = [];
            foreach ($items_lists as $iv) {
                list($id, $code, $bar, $name, $shop, $color, $size, $qty, $price, $disc, $tax) = $iv;
                $QTY += floatval($qty);
                $total_price = floatval($qty) * floatval($price);
                $PRICE += $total_price;
                $Disc += floatval($disc);
                $TAX += floatval($tax);
                $v[] = [strval($code), strval($name), strval($qty), strval($price), strval($total_price)];
            }
        
            $itemforslip = "";
            foreach ($v as $vs) {
                $vl = [7, 10, 3, 8, 8];
                $vsy = ['/', '(', 'x', '=', ')'];
                $vvi = 0;
                foreach ($vl as $vi) {
                    for ($w = 0; $w < $vi; $w++) {
                        if ($w < strlen($vs[$vvi])) {
                            $itemforslip .= $vs[$vvi][$w];
                        } else {
                            $itemforslip .= ' ';
                        }
                    }
                    $itemforslip .= $vsy[$vvi];
                    $vvi++;
                }
                $itemforslip .= "\n" . get_sparet_2($width);
            }
        
            $slip .= "Code    Name       qty  price    totale \n";
            $slip .= "_________________________________________\n";
            $slip .= $itemforslip . "\n";
        
            return [[$PRICE, $QTY, $Disc, $TAX], $slip];
        }
        
        // Function to get payments
        function get_payments($doc, $total_info) {
            $slip = "";
            $taxstr = "";
        
            list($PRICE, $QTY, $Disc, $TAX) = $total_info; // Ensure TAX is defined here if not globally
        
            if ($TAX == 0) {
                $taxstr = "5%";
            } else {
                $taxstr = strval($TAX);
            }
        
            $slip_payments = "";
        
            $list_items_copy = json_decode($doc['payments'], true);
            foreach ($list_items_copy as $iv) {
                list($pay_id, $pay_type, $pay_pid, $pay_pid_date, $pay_updated_date, $pay_user, $ispayed, $extrabarcode) = $iv;
                $price = $pay_type;
                $slip_payments .= $pay_id . ". " . $pay_type . ", " . $pay_pid . ", " . explode(' ', $pay_pid_date)[0] . ", " . $pay_user . "\n";
            }
        
            $slip .= $slip_payments . "\n";
            return [[$PRICE, $QTY, $Disc, $TAX], $slip];
        }
        
        // Function to get total
        function get_total($doc, $total_info) {
            $slip = "";
            list($PRICE, $QTY, $Disc, $TAX) = $total_info;
            $taxstr = $TAX == 0 ? "5%" : strval($TAX);
        
           
            $pvv = [(string)$QTY, (string)$PRICE, (string)$taxstr, (string)$Disc, (string)0, (string)0];
            if ($doc['pid']) {
                $pvv = [(string)$QTY, (string)$PRICE, $taxstr, (string)$Disc, (string)floatval($doc['pid']), (string)(floatval($doc['pid']) - ($PRICE - $Disc) - $TAX)];
            }
            $pvvi = 0;
            $totalitemforslip = "";
            $pv = [3, 7, 3, 8, 6, 8];
            $vsy = [' ', '-', '-', ' ', '=', ''];
            foreach ($pv as $pvi) {
                for ($w = 0; $w < $pvi; $w++) {
                    if ($w < strlen($pvv[$pvvi])) {
                        $totalitemforslip .= $pvv[$pvvi][$w];
                    } else {
                        $totalitemforslip .= ' ';
                    }
                }
                $totalitemforslip .= $vsy[$pvvi];
                $pvvi++;
            }
            $totalitemforslip .= "\n";
        
            $slip .= "QTY  Price  Tax  Discount  Paid  CHANGE\n";
            $slip .= $totalitemforslip . "\n";
        
            return [[$PRICE, $QTY, $Disc, $TAX], $slip];
        }
        
        // Function to get rules
        function get_rules($shop, $width) {

            $items_lists = json_decode($shop[0]['Shop_rules'], true);
            $ret = "";
            if($items_lists){
                    foreach ($items_lists as $l) {
                        $ret .= $l[0].' : '.$l[1]. "\n";
                    }
            }
            return $ret;

            
        }
        
        
        // Main function to load slip
        function load_slip($result, $conn) {
            // Fetch document from database
        
            //$result = $conn->query("SELECT * FROM documents WHERE document_barcode='$document_id'");
            if ($result->num_rows > 0) {
                while ($doc = $result->fetch_assoc()) {
                   
                    $shop = find_shop($doc['At_Shop_Id'], $conn);
                    $width = 40; // Define your width
                    $slip = "";
                    // Construct the slip using the functions
                    $slip .= get_sparet($width);

                    $slip .= get_links($shop);
                    $slip .= get_Shop_infos($shop);

                    $slip .= get_sparet($width);

                    $slip .= get_receipt_no($doc);
                    $slip .= get_extension_receipt_no($doc);
                    $slip .= get_date($doc);
                    $slip .= get_updated_date($doc);
                    $slip .= get_due_date($doc);
 
                    $slip .= get_sparet_1($width);

                    $slip .= get_user($doc, $conn);
                    $slip .= get_seller($doc, $conn);
                    $slip .= get_customer($doc, $conn);

                    $slip .= get_sparet_1($width);

                    list($ret_0, $ret_1) = get_items($doc, $width);
                    $total_info = $ret_0;
                    $slip .= $ret_1;

                    list($ret_0, $ret_1) = get_payments($doc, $total_info);
                    $total_info = $ret_0;
                    $slip .= $ret_1;

                    list($ret_0, $ret_1) = get_total($doc, $total_info);
                    $total_info = $ret_0;
                    $slip .= $ret_1;

                    $slip .= get_sparet_3($width);
                    $slip .= get_rules($shop, $width);

                    $slip .= get_sparet_0($width);
                
                    return [$doc, $slip];
                }
            } else {
                return "Transaction Document not found.";
            }
        }
        
        
        
        // Fetch the document ID from a request (e.g., from JavaScript)
        if (isset($_POST['document_id'])) {
            $document_id = $_POST['document_id'];
            $documents = $conn->query("SELECT * FROM documents WHERE document_barcode='$document_id'");

            $data = load_slip($documents, $conn);
            
            echo json_encode(['status' => 'Success', 'doc_data' => $data]);
        } else {
            echo json_encode(['status' => 'Error', 'message' => "No document ID provided."]);
        }
    }
} catch (Exception $e) {
    customExceptionHandler($e);
} 
?>
