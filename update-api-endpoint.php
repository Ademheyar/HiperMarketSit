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

    try {
        // Prepare the query
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
        $stmt->execute();


        // Check the type of operation
        if ($type === 'Add_Item') {
            // Split the item data
            $items_lists = explode(",", $item);

            // Iterate through each item
            foreach ($items_lists as $items) {
                $item_data = explode("|,|", $items);

                // Extract data into individual variables
                $id = intval(str_replace("(|", "", $item_data[0]));
                $code = $item_data[1];
                $name = $item_data[2];
                $at_shop = $item_data[3];
                $barcode = $item_data[4];
                $quantity = intval($item_data[5]);
                $cost = floatval($item_data[6]);
                $tax = floatval($item_data[7]);
                $price = floatval($item_data[8]);
                $include_tax = intval($item_data[9]);
                $price_change = intval($item_data[10]);
                $more_info = $item_data[11];
                $images = $item_data[12];
                $description = $item_data[13];
                $service = $item_data[14];
                $default_quantity = intval($item_data[15]);
                $active = intval($item_data[16]);

                // Prepare the query for inserting or updating the item data
                $item_stmt = $conn->prepare("INSERT INTO item_table (id, name, code, type, barcode, at_shop, quantity, cost, tax, price, include_tax, price_change, more_info, images, description, service, default_quantity, active)
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                            ON DUPLICATE KEY UPDATE
                                                name = VALUES(name),
                                                code = VALUES(code),
                                                type = VALUES(type),
                                                barcode = VALUES(barcode),
                                                at_shop = VALUES(at_shop),
                                                quantity = VALUES(quantity),
                                                cost = VALUES(cost),
                                                tax = VALUES(tax),
                                                price = VALUES(price),
                                                include_tax = VALUES(include_tax),
                                                price_change = VALUES(price_change),
                                                more_info = VALUES(more_info),
                                                images = VALUES(images),
                                                description = VALUES(description),
                                                service = VALUES(service),
                                                default_quantity = VALUES(default_quantity),
                                                active = VALUES(active)");

                // Bind the parameters for item data
                $item_stmt->bind_param('isssssiddiisssssssi', $id, $name, $code, $type, $barcode, $at_shop, $quantity, $cost, $tax, $price, $include_tax, $price_change, $more_info, $images, $description, $service, $default_quantity, $active);

                // Execute the query for item data
                $item_stmt->execute();
            }
        }

        echo 'Data saved successfully.';
    } catch (Exception $e) {
        echo 'Failed to save data: ' . $e->getMessage();
    }

    // Close the database connection
    $conn->close();

    echo json_encode(['status' => 'success']);
    exit;
}
?>
