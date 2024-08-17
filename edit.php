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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM vehicle_inquiry WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
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

    $sql = "UPDATE vehicle_inquiry SET name=?, mobile_number=?, whatsapp_number=?, address=?, vehicle_name=?, vehicle_model_number=?, vehicle_model_year=?, vehicle_color=?, vehicle_km=?, engine_no=?, chassis_no=?, interested=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssisssssi", $name, $mobile_number, $whatsapp_number, $address, $vehicle_name, $vehicle_model_number, $vehicle_model_year, $vehicle_color, $vehicle_km, $engine_no, $chassis_no, $interested, $id);
    $stmt->execute();
    $stmt->close();
    
    echo "<script>
        window.onload = function() {
            toastr.error('Data deleted successfully!', '', { timeOut: 3000, positionClass: 'toast-top-center', progressBar: true, showDuration: 300, hideDuration: 1000 });
            setTimeout(function() {
                window.location.href = 'displaydata1.php';
            }, 3000);
        }
    </script>";


    header("Location: displaydata.php");
    exit();
    
    
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vehicle Inquiry</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-5">Edit Vehicle Inquiry</h2>
        <form method="POST" action="edit.php" id="form">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="mobile_number">Mobile Number:</label>
                <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php echo $row['mobile_number']; ?>" required>
            </div>
            <div class="form-group">
                <label for="whatsapp_number">WhatsApp Number:</label>
                <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="<?php echo $row['whatsapp_number']; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>" required>
            </div>
            <div class="form-group">
                <label for="vehicle_name">Vehicle Name:</label>
                <input type="text" class="form-control" id="vehicle_name" name="vehicle_name" value="<?php echo $row['vehicle_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="vehicle_model_number">Vehicle Model Number:</label>
                <input type="text" class="form-control" id="vehicle_model_number" name="vehicle_model_number" value="<?php echo $row['vehicle_model_number']; ?>" required>
            </div>
            <div class="form-group">
                <label for="vehicle_model_year">Vehicle Model Year:</label>
                <input type="number" class="form-control" id="vehicle_model_year" name="vehicle_model_year" value="<?php echo $row['vehicle_model_year']; ?>" required>
            </div>
            <div class="form-group">
                <label for="vehicle_color">Vehicle Color:</label>
                <input type="text" class="form-control" id="vehicle_color" name="vehicle_color" value="<?php echo $row['vehicle_color']; ?>" required>
            </div>
            <div class="form-group">
                <label for="vehicle_km">Vehicle KM:</label>
                <input type="number" class="form-control" id="vehicle_km" name="vehicle_km" value="<?php echo $row['vehicle_km']; ?>" required>
            </div>
            <div class="form-group">
                <label for="engine_no">Engine Number:</label>
                <input type="text" class="form-control" id="engine_no" name="engine_no" value="<?php echo $row['engine_no']; ?>" required>
            </div>
            <div class="form-group">
                <label for="chassis_no">Chassis Number:</label>
                <input type="text" class="form-control" id="chassis_no" name="chassis_no" value="<?php echo $row['chassis_no']; ?>" required>
            </div>
            <div class="form-group">
                <label for="interested">Interested:</label>
                <input type="text" class="form-control" id="interested" name="interested" value="<?php echo $row['interested']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>
