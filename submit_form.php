<?php
$servername = "localhost";
$username = "u670459635_justgo_service";
$password = "Justgo@12345";
$dbname = "u670459635_justgo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $mobile_number = $_POST['mobile_number'];
    $whatsapp_number = $_POST['whatsapp_number'];
    $address = $_POST['address'];
    $vehicle_name = $_POST['vehicle_name'];
    $vehicle_model_number = $_POST['vehicle_model_number'];
    $vehicle_model_year = $_POST['vehicle_model_year'];
    $vehicle_color = $_POST['vehicle_color'];
    $vehicle_km = $_POST['vehicle_km'];
    $engine_no = $_POST['engine_no'];
    $chassis_no = $_POST['chassis_no'];
    $interested = $_POST['interested'];

    // Handle file upload
    $target_dir = "img/";
    $image_paths = [];

    foreach ($_FILES['vehicle_images']['name'] as $key => $image_name) {
        $target_file = $target_dir . basename($image_name);
        if (move_uploaded_file($_FILES['vehicle_images']['tmp_name'][$key], $target_file)) {
            $image_paths[] = $target_file;
        }
    }

    // Convert image paths array to a string
    $image_paths_str = implode(",", $image_paths);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO vehicle_inquiry (name, mobile_number, whatsapp_number, address, vehicle_name, vehicle_model_number, vehicle_model_year, vehicle_color, vehicle_km, engine_no, chassis_no, interested, image_paths) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssissssss", $name, $mobile_number, $whatsapp_number, $address, $vehicle_name, $vehicle_model_number, $vehicle_model_year, $vehicle_color, $vehicle_km, $engine_no, $chassis_no, $interested, $image_paths_str);

    // Execute the statement
    if ($stmt->execute()) {
        // echo "Form Submitted successfully and Store Data successfully";
        header("Location: success.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
