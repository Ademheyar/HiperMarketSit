<?php

// Update API endpoint for both Website to Window Application and Window Application to Website
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the JSON data sent by the Python code
    $data = json_decode(file_get_contents('php://input'), true);

	
	// Extract data into individual variables
	$Do = $data['Do'];

    $error1 .= $Do;
    if ($Do == 'Update_Image'){
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
        // Database connection details
        $host = 'localhost';
        $db_name = 'shop';
        $username = 'root';
        $password = '';

        // Create a new MySQLi instance
        $conn = new mysqli($host, $username, $password, $db_name);

        // Check for connection errors
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
        
        // Check the type of operation
		// To test if connection reach here 
		// sand 'DO' : 'Testing Connection' and seve msg and status success 
		if ($Do === 'Testing Connection'){
			$response = ['status' => 'success', 'message' => 'API Connection successfully.', 'row' => $error1];
			echo json_encode($response);
			exit;
		}
        include 'Get.php';
        include 'Set.php';
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
else{
	echo "Trying to load API with Website!!!";
}
?>
