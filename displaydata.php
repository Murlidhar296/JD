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

$sql = "SELECT * FROM vehicle_inquiry";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Inquiry Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        body {
            background: linear-gradient(to right, #a1c4fd, #c2e9fb);
            background-size: cover;
            display: flex;
            justify-content: center;
            font-family: Arial, sans-serif;
            padding: 1rem;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(173, 216, 230, 0.5);
            padding: 30px;
            width: 90%;
            max-width: 1200px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        img {
            max-width: 100px;
            height: auto;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-5">JustGO Visit Data</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-nowrap text-center" id="tabel">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile Number</th>
                        <th>WhatsApp Number</th>
                        <th>Address</th>
                        <th>Vehicle Name</th>
                        <th>Model Number</th>
                        <th>Model Year</th>
                        <th>Color</th>
                        <th>KM</th>
                        <th>Engine Number</th>
                        <th>Chassis Number</th>
                        <th>Interested</th>
                        <th>Images</th>
                        <th>Submission Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["mobile_number"] . "</td>";
                            echo "<td>" . $row["whatsapp_number"] . "</td>";
                            echo "<td>" . $row["address"] . "</td>";
                            echo "<td>" . $row["vehicle_name"] . "</td>";
                            echo "<td>" . $row["vehicle_model_number"] . "</td>";
                            echo "<td>" . $row["vehicle_model_year"] . "</td>";
                            echo "<td>" . $row["vehicle_color"] . "</td>";
                            echo "<td>" . $row["vehicle_km"] . "</td>";
                            echo "<td>" . $row["engine_no"] . "</td>";
                            echo "<td>" . $row["chassis_no"] . "</td>";
                            echo "<td>" . $row["interested"] . "</td>";
                            
                            // Display images with modal trigger
                            echo "<td>";
                            $image_paths = explode(",", $row["image_paths"]);
                            if (count($image_paths) > 0 && !empty($image_paths[0])) {
                                echo "<img src='" . $image_paths[0] . "' alt='Vehicle Image' data-toggle='modal' data-target='#imageModal' data-images='" . implode(",", $image_paths) . "'>";
                            }
                            echo "</td>";
                            
                            // Format submission date as per Indian Standard Time (IST) with format dd/mm/yyyy
                            $submission_date = date("d/m/Y H:i:s", strtotime($row["submission_date"]) + 19800);
                            echo "<td>" . $submission_date . "</td>";
                            
                            echo "<td>";
                            echo "<a href='edit.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                            echo "<a href='delete.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='16'>No records found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
            <!--<a href="./download.php"><button class="btn btn-success" id="download-excel">Download Excel</button></a>-->
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Vehicle Images</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div id="imageGallery" class="d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-secondary mr-2" id="prevImage">&lt;</button>
                        <img id="modalImage" src="" class="img-fluid mb-2" style="max-width: 100%;">
                        <button type="button" class="btn btn-secondary ml-2" id="nextImage"> &gt;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        var currentImageIndex = 0;
        var imagesArray = [];

        $('#imageModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            imagesArray = button.data('images').split(",");
            currentImageIndex = 0;
            $('#modalImage').attr('src', imagesArray[currentImageIndex]);
        });

        $('#prevImage').click(function() {
            if (currentImageIndex > 0) {
                currentImageIndex--;
                $('#modalImage').attr('src', imagesArray[currentImageIndex]);
            }
        });

        $('#nextImage').click(function() {
            if (currentImageIndex < imagesArray.length - 1) {
                currentImageIndex++;
                $('#modalImage').attr('src', imagesArray[currentImageIndex]);
            }
        });
    </script>
</body>
</html>
