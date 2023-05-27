<?php
// Update API endpoint for both Website to Window Application and Window Application to Website
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the JSON data sent by the Python code
    $data = json_decode(file_get_contents('php://input'), true);

    // Extract data into individual variables
    $id = $data['id'];
    $doc_barcode = $data['doc_barcode'];
    $extension_barcode = $data['extension_barcode'];
    $user_id = $data['user_id'];
    $customer_id = $data['customer_id'];
    $type = $data['type'];
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
    $error1 = "";
    try {
        /* Prepare the query
        $stmt = $conn->prepare("INSERT INTO your_table_name ( id, doc_barcode, extension_barcode, user_id, customer_id, type, item, qty, price, discount, tax, payments, doc_created_date, doc_expire_date, doc_updated_date)
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
        $stmt->execute();*/
    
        // Check the type of operation
        $it = "";
        if ($type === 'Add_Items' || $type === 'Add_item') {
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
                
                try {
                    // Check if the item already exists
                    $select_stmt = $conn->prepare("SELECT `id` FROM `products` WHERE `id` = ?");
                    $select_stmt->bind_param('i', $id_item);
                    $select_stmt->execute();
                    $result = $select_stmt->get_result();
                    $select_stmt->close();
            
                    //$error1 = $error1 . '\n : '.$result->num_rows. ' ';
                    if ($result->num_rows > 0) {
                        try{
                            // Update the existing item
                            $update_stmt = $conn->prepare("UPDATE `products` SET `name` = ?, `code` = ?, `type` = ?, `barcode` = ?, `at_shop` = ?, `quantity` = ?, `cost` = ?, `tax` = ?, `price` = ?, `include_tax` = ?, `price_change` = ?, `more_info` = ?, `images` = ?, `description` = ?, `service` = ?, `default_quantity` = ?, `active` = ? WHERE `id` = ?");
                            $update_stmt->bind_param('sssssidddiissssiii', $name, $code, "update$typ", $barcode, $at_shop, $quantity, $cost, $tax, $price, $include_tax, $price_change, $more_info, $images, $description, $service, $default_quantity, $active, $id_item);
                            $update_stmt->execute();
                            $update_stmt->close();
                
                            // Add code to handle the response for an updated item
                            $response = ['status' => 'success', 'message' => 'Item updated successfully.', 'row' => $it];
                        } catch (Exception $e) {
                            $error1 = $error1 . '\update error: ' . $e->getMessage();
                        }
                    } else {
                        // Insert a new item
                        $insert_stmt = $conn->prepare("INSERT INTO `products`(`id`, `name`, `code`, `type`, `barcode`, `at_shop`, `quantity`, `cost`, `tax`, `price`, `include_tax`, `price_change`, `more_info`, `images`, `description`, `service`, `default_quantity`, `active`)
                                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $insert_stmt->bind_param('isssssidddiissssii', $id_item, $name, $code, $typ, $barcode, $at_shop, $quantity, $cost, $tax, $price, $include_tax, $price_change, $more_info, $images, $description, $service, $default_quantity, $active);
                        $insert_stmt->execute();
                        $insert_stmt->close();
            
                        // Add code to handle the response for a newly inserted item
                        $response = ['status' => 'success', 'message' => 'Item added successfully.', 'row' => $it];
                    }
                } catch (Exception $e) {
                    $error1 = $error1 . '\insert error: ' . $e->getMessage();
                }
            }
        }
        // Get the last inserted row
        $inserted_id = $conn->insert_id;
        $result = $conn->query("SELECT * FROM products WHERE id = $inserted_id");
    
        // Check if the row exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Update the response if the item was inserted but not updated
            if (!isset($response)) {
                $response = ['status' => 'success', 'message' => 'Data saved successfully.', 'row' => $it];
            }
        } else {
            $error1 = $error1.'Failed to retrieve the newly added row.'.$existing_item_count;
            $response = ['status' => 'error', 'message' => $error1];
        }
    } catch (Exception $e) {
        $response = ['status' => 'error', 'message' => 'Failed to save data: ' . $e->getMessage()];
    }
    

    // Close the database connection
    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
