<?php
function comparePaths($str1, $str2) {
    // Add ',' at the end if it doesn't exist
    $path1 = $str1;
    $path2 = $str2;
    if (substr($str1, -1) !== ',') {
        $str1 .= ',';
    }
    if (substr($str2, -1) !== ',') {
        $str2 .= ',';
    }
    
    // Split the strings into arrays of paths
    $arr1 = explode(',', $str1);
    $arr2 = explode(',', $str2);
    
    // Remove the last empty element
    array_pop($arr1);
    array_pop($arr2);
    
    // Find the differences
    $str1Diff = array_diff($arr1, $arr2);
    $str2Diff = array_diff($arr2, $arr1);
    
    if (empty($path1) && empty($str1Diff) && !empty($arr2)) {
        $str1Diff = $path1;
    }
    if (empty($path2) && empty($str2Diff) && !empty($arr1)) {
        $str2Diff = $path2;
    }

    // Return the differences
    return [
        'str1_diff' => $str1Diff,
        'str2_diff' => $str2Diff
    ];
}

// Update API endpoint for both Website to Window Application and Window Application to Website
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the JSON data sent by the Python code
    $data = json_decode(file_get_contents('php://input'), true);

    $type = $data['type'];

    $it = "";
    $image_to_get = "";
    $image_to_sand = "";
    
    $error1 = "";
    $secess = "";
    $doing = "";
    $error1 .= $type;

    //|| $type === 'Update_Item' || $type === 'Update_item'
    if ($type == 'Update_Image'){
        $error1 .= 'IN Update_Image        ******';
        $image = $_FILES['image'];
        $uploadPath = 'path/to/save/image.jpg';  // Save the image to a desired location

        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            $response = ['status' => 'success', 'message' => 'Image uploaded successfully '."*********", 'row' => $error1];
        } else {
            http_response_code(500);
            $error1 .= 'Failed to upload image';
        }
    }
    else{
        // Extract data into individual variables
        $id = $data['id'];
        $doc_barcode = $data['doc_barcode'];
        $extension_barcode = $data['extension_barcode'];
        $user_id = $data['user_id'];
        $customer_id = $data['customer_id'];

        $item = $data['item'];
        $qty = $data['qty'];
        $price = $data['price'];
        $discount = $data['discount'];
        $tax = $data['tax'];
        $payments = $data['payments'];
        $doc_created_date = $data['doc_created_date'];
        $doc_expire_date = $data['doc_expire_date'];
        $doc_updated_date = $data['doc_updated_date'];

        // Database connection details
        $host = 'localhost';
        $db_name = 'shop_db';
        $username = 'root';
        $password = '';

        // Create a new MySQLi instance
        $conn = new mysqli($host, $username, $password, $db_name);

        // Check for connection errors
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
        try {
            // Prepare the query
            /*$stmt = $conn->prepare("INSERT INTO your_table_name ( id, doc_barcode, extension_barcode, user_id, customer_id, type, item, qty, price, discount, tax, payments, doc_created_date, doc_expire_date, doc_updated_date)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                    ON DUPLICATE KEY UPDATE 
                                        doc_barcode = VALUES(doc_barcode),
                                        extension_barcode = VALUES(extension_barcode),
                                        user_id = VALUES(user_id),
                                        customer_id = VALUES(customer_id),
                                        type = VALUES(type),
                                        item = VALUES(item),
                                        qty = VALUES(qty),
                                        price = VALUES(price),
                                        discount = VALUES(discount),
                                        tax = VALUES(tax),
                                        payments = VALUES(payments),
                                        doc_created_date = VALUES(doc_created_date),
                                        doc_expire_date = VALUES(doc_expire_date),
                                        doc_updated_date = VALUES(doc_updated_date)");
        
            // Bind the parameters
            $stmt->bind_param('isssssdddddssss', $id, $doc_barcode, $extension_barcode, $user_id, $customer_id, $type, $item, $qty, $price, $discount, $tax, $payments, $doc_created_date, $doc_expire_date, $doc_updated_date);
        
            // Execute the query
            $stmt->execute();
            */
        } catch (Exception $e) {
            $error1 = $error1 . ' got error in doc saving '.$e->getMessage(). '/';
        }
        
        // Check the type of operation
        if ($type === 'Add_Items' || $type === 'Add_item' || $type === 'Update_item' || $type === 'Update_Items') {
            // Split the item data
            try{
                //"'(|1|,|APETITO|,|MH/DRUGS/KD-699-217|,|ACSSESRI GANING_WIGHT PILLS|,||,||,|0|,|5.0|,|0.0|,|15.0|,|0|,|0|,|"{FLAG_SQUARE,(<FRUATE,[|2X10, , 23, -1.0, , |]>)},"|,|test.jpg|,|APETITO CYPROHRPTADINE TABLETS 4MG INDICARION|,|0|,|1|,|1|)'"
                $error1 = $error1 . ' going to '.$type. '\n';
                $it = $item.","; // Append a comma to the $item variable
                $items_lists = explode(":),", $it); // Split $item into an array using the delimiter "),"
                $error1 = $error1 . ' list equal '.implode(",", $items_lists).","."        ";

                // Iterate through each item
                foreach ($items_lists as $key => $items) {
                    if ($key === count($items_lists) - 1 || strpos($items, ":,:") === false) break; // Skip the last item
                    $item_data = explode(":,:", $items);
                    // Check if it's the last item in $items_lists and doesn't contain the delimiter "|,|"
                    
                    // Extract data into individual variables
                    
                    $id_item = intval(str_replace("(:", "", $item_data[0]));
                    $name = $item_data[1];
                    $code = $item_data[2];
                    $typ = $item_data[3];
                    $barcode = $item_data[4];
                    $at_shop = $item_data[5];
                    $quantity = intval($item_data[6]);
                    $cost = floatval($item_data[7]);
                    $tax = floatval($item_data[8]);
                    $price = floatval($item_data[9]);
                    $include_tax = intval($item_data[10]);
                    $price_change = intval($item_data[11]);
                    $more_info = $item_data[12];
                    $images = $item_data[13];
                    $description = $item_data[14];
                    $service = $item_data[15];
                    $default_quantity = intval($item_data[16]);
                    $active = intval(str_replace(":)", "", $item_data[17]));
                    
                    $result = null;
                    $row = null;
                    try {
                        // Check if the item already exists
                        $select_stmt = $conn->prepare("SELECT * FROM `product` WHERE `id` = ?");
                        $select_stmt->bind_param('i', $id_item);
                        $select_stmt->execute();
                        $result = $select_stmt->get_result();
                        $row = $result->fetch_assoc();
                        $error1 = $error1 . ' got  '.$result->num_rows."*********";
                    }catch (Exception $e) {
                        $error1 = $error1 . "item not found: " . $e->getMessage() . "*********";
                    }
                    
                    
                    
                    if ($result != null && $result->num_rows > 0) {
                        // Compare the new values with the existing values
                        $error1 = $error1 .' and '."  row ".implode(", ", $row)."*********";
                        $error1 = $error1 . ' UPDATE num_rows : '."*********";
                        $updateRequired = false;
                        if ($name != $row['name'] || $code != $row['code'] || $typ != $row['type'] || $barcode != $row['barcode'] ||
                            $at_shop != $row['at_shop'] || $quantity != $row['quantity'] || $cost != $row['cost'] || $tax != $row['tax'] ||
                            $price != $row['price'] || $include_tax != $row['include_tax'] || $price_change != $row['price_change'] ||
                            $more_info != $row['more_info'] || $images != $row['images'] || $description != $row['description'] ||
                            $service != $row['service'] || $default_quantity != $row['default_quantity'] || $active != $row['active']) {
                            $updateRequired = true;
                        }
                        if($updateRequired) {
                            try {
                                if ($images != $row['images']) {
                                    // save id  if images value not same

                                    // Example usage
                                    $q = comparePaths($row['images'], $images);

                                    $image_to_sand .= implode(", ", $q['str1_diff']).',';
                                    $image_to_get .= implode(", ", $q['str2_diff']).',';
                                    $error1 = $error1 . "Paths image_to_sand: " . $image_to_sand." *********";
                                    $error1 = $error1 . "Paths image_to_get: " . $image_to_get." *********";
                                }
                                try {
                                    $update_stmt = $conn->prepare("UPDATE `product` SET `name` = ?, `code` = ?, `type` = ?, `barcode` = ?, `at_shop` = ?, `quantity` = ?, `cost` = ?, `tax` = ?, `price` = ?, `include_tax` = ?, `price_change` = ?, `more_info` = ?, `images` = ?, `description` = ?, `service` = ?, `default_quantity` = ?, `active` = ? WHERE `id` = ?");
                                    $update_stmt->bind_param('sssssidddiissssiii', $name, $code, $typ, $barcode, $at_shop, $quantity, $cost, $tax, $price, $include_tax, $price_change, $more_info, $images, $description, $service, $default_quantity, $active, $id_item);
                                    $update_stmt->execute();
                                    $update_stmt->close();
                                    
                                } catch (Exception $e) {
                                    $error1 = $error1 . '\----------------------------------update error: '.$e->getMessage();
                                }
                                $response = ['status' => 'success', 'message' => 'Items is orady exist and new value is updated. and image ('.$images .'=='.$row['images'].')'."*********", 'row' => $error1];
                            } catch (Exception $e) {
                                $error1 = $error1 . '\update error: ' . $e->getMessage();
                            }
                            #$response = ['status' => 'success', 'message' => 'update error found'."*********", 'row' => $error1];
                        }
                        else $response = ['status' => 'success', 'message' => 'Items is orady exist and no new value to update.', 'row' => $error1];
                        $secess = $secess ."done";
                        $select_stmt->close();
                    }
                    else {
                        $error1 = $error1 . ' INSERT num_rows : '.$result->num_rows. ' ';
                        try {
                            // Update the existing item
                            // chack if image is changed comparing to $image
                            
                            // Insert a new item
                            $insert_stmt = $conn->prepare("INSERT INTO `product`(`id`, `name`, `code`, `type`, `barcode`, `at_shop`, `quantity`, `cost`, `tax`, `price`, `include_tax`, `price_change`, `more_info`, `images`, `description`, `service`, `default_quantity`, `active`)
                                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $insert_stmt->bind_param('isssssidddiissssii', $id_item, $name, $code, $typ, $barcode, $at_shop, $quantity, $cost, $tax, $price, $include_tax, $price_change, $more_info, $images, $description, $service, $default_quantity, $active);
                            $insert_stmt->execute();
                            $insert_stmt->close();
                
                            // Add code to handle the response for a newly inserted item
                            if ($images != "") {
                                // save id  if images value not same
                                $image_to_get += $id_item.',';
                            }
                            else{
                                $response = ['status' => 'success', 'message' => 'Item added successfully.', 'row' => $error1];
                            }
                        } catch (Exception $e) {
                            $error1 = $error1 . '\insert error: ' . $e->getMessage();
                            $response = ['status' => 'error', 'message' => 'Insert error: ' . $e->getMessage()];
                        }
                    }
                }
                $inserted_id = $id_item;
                
            }catch (Exception $e){
                $error1 = $error1 . ' error adding '.$e->getMessage(). '/';
            }
        }
        //"Sale_item" "Update_item"
        else if ($type === 'Sale_Item' || $type === 'Sale_item') {
            /*
            // Split the item data
            $it = $item.","; // Append a comma to the $item variable
            $items_lists = explode("),", $it); // Split $item into an array using the delimiter "),"

            // Iterate through each item
            foreach ($items_lists as $key => $items) {
                // Check if it's the last item in $items_lists and doesn't contain the delimiter "|,|"
                if ($key === count($items_lists) - 1 && strpos($items, "|,|") === false) break; // Skip the last item
                
                $item_data = explode("|,|", $items);
                // Extract data into individual variables
                
                $id_item = intval(str_replace("(|", "", $item_data[0]));
                $name = $item_data[1];
                $code = $item_data[2];
                $typ = $item_data[3];
                $barcode = $item_data[4];
                $at_shop = $item_data[5];
                $quantity = intval($item_data[6]);
                $cost = floatval($item_data[7]);
                $tax = floatval($item_data[8]);
                $price = floatval($item_data[9]);
                $include_tax = intval($item_data[10]);
                $price_change = intval($item_data[11]);
                $more_info = $item_data[12];
                $images = $item_data[13];
                $description = $item_data[14];
                $service = $item_data[15];
                $default_quantity = intval($item_data[16]);
                $active = intval(str_replace("|)", "", $item_data[17]));
                
                // Check if the item already exists
                $select_stmt = $conn->prepare("SELECT * FROM `product` WHERE `id` = ?");
                $select_stmt->bind_param('i', $id_item);
                $select_stmt->execute();
                $result = $select_stmt->get_result();
                $select_stmt->close();
        
                if ($result->num_rows > 0) {
                    $error1 = $error1 . ' UPDATE num_rows : '.$result->num_rows. ' ';
                    try {
                        // Update the existing item
                        $update_stmt = $conn->prepare("UPDATE `product` SET `name` = ?, `code` = ?, `type` = ?, `barcode` = ?, `at_shop` = ?, `quantity` = ?, `cost` = ?, `tax` = ?, `price` = ?, `include_tax` = ?, `price_change` = ?, `more_info` = ?, `images` = ?, `description` = ?, `service` = ?, `default_quantity` = ?, `active` = ? WHERE `id` = ?");
                        $update_stmt->bind_param('sssssidddiissssiii', $name, $code, "update$typ", $barcode, $at_shop, $quantity, $cost, $tax, $price, $include_tax, $price_change, $more_info, $images, $description, $service, $default_quantity, $active, $id_item);
                        $update_stmt->execute();
                        $update_stmt->close();
            
                        // Add code to handle the response for an updated item
                        $response = ['status' => 'success', 'message' => 'Item updated successfully.', 'row' => $it];
                    } catch (Exception $e) {
                        $error1 = $error1 . '\update error: ' . $e->getMessage();
                        $response = ['status' => 'error', 'message' => 'Update error: ' . $e->getMessage()];
                    }
                } else {
                    $error1 = $error1 . ' INSERT num_rows : '.$result->num_rows. ' ';
                    try {
                        // Insert a new item
                        $insert_stmt = $conn->prepare("INSERT INTO `product`(`id`, `name`, `code`, `type`, `barcode`, `at_shop`, `quantity`, `cost`, `tax`, `price`, `include_tax`, `price_change`, `more_info`, `images`, `description`, `service`, `default_quantity`, `active`)
                                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $insert_stmt->bind_param('isssssidddiissssii', $id_item, $name, $code, $typ, $barcode, $at_shop, $quantity, $cost, $tax, $price, $include_tax, $price_change, $more_info, $images, $description, $service, $default_quantity, $active);
                        $insert_stmt->execute();
                        $insert_stmt->close();
            
                        // Add code to handle the response for a newly inserted item
                        $response = ['status' => 'success', 'message' => 'Item added successfully.', 'row' => $it];
                    } catch (Exception $e) {
                        $error1 = $error1 . '\insert error: ' . $e->getMessage();
                        $response = ['status' => 'error', 'message' => 'Insert error: ' . $e->getMessage()];
                    }
                }
            }*/
            $response = ['status' => 'success', 'message' => 'Data is for too add_item. it is '.$type, 'row' => $error1];
        }
        else{
            $response = ['status' => 'success', 'message' => 'Data is not for procute. else '.$type, 'row' => $error1];
            /* print doce table 
            $inserted_id = $id_item;
            if ($type === 'Add_Items' || $type === 'Add_item') {
                // Get the last inserted row
                $inserted_id = $conn->insert_id;
                // Check if the row exists
            }

            $result = $conn->query("SELECT * FROM product WHERE id = $inserted_id");
            $error1 = $error1.'inserted_id. '.$inserted_id;
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Update the response if the item was inserted but not updated
                if (!isset($response)) {
                    $response = ['status' => 'success', 'message' => 'Data saved successfully.', 'row' => $it];
                } else {
                    $error1 = $error1.' Failed to retrieve the newly added row. '.$existing_item_count;
                    $response = ['status' => 'error', 'message' => $error1];
                }
            } else {
                #$error1 = $error1.' Failed to retrieve the newly added row. '.$existing_item_count;
                $response = ['status' => 'error', 'message' => $error1];
            }*/
        }
        
        if($image_to_get != ""){
            // $image_to_get
            $row = $result->fetch_assoc();
            $response = ['status' => 'Get_Items_image', 'message' => 'need images .', 'row' => $image_to_get];
        }
        else if ($type === 'Add_Items' || $type === 'Add_item') {
            // Get the last inserted row
            $inserted_id = $conn->insert_id;
            $secess = $secess.'inserted_id. '.$inserted_id;
            // Check if the row exists
        }
        else if ($type === 'Update_Items' || $type === 'Update_item') {
            // Get the last inserted row
            $inserted_id = $id_item;
            $error1 = $error1.'updated_id. '.$inserted_id;
            // Check if the row exists
        }
        else{
            $result = $conn->query("SELECT * FROM product WHERE id = $inserted_id");
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $response = ['status' => 'success', 'message' => 'Data saved successfully.', 'row' => $error1];
            } else {
                $error1 = $error1.' Failed to retrieve the newly added row. ';
                $response = ['status' => 'error', 'message' => $error1];
            }
        }
    }

    // Close the database connection
    $conn->close();
    if (!isset($response['status'])) {
        $response['status'] = 'error';
    }
    $response['message'] = $response['message'].$error1;

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
