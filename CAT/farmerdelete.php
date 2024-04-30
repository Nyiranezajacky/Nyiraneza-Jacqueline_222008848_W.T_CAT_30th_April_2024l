<?php
// Check if ID parameter is passed
if(isset($_GET['id']) && !empty($_GET['id'])){
    $farmerID = $_GET['id'];

    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "farmer";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to delete farmer record
    $sql = "DELETE FROM farmer WHERE FarmerID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $farmerID);

    if ($stmt->execute()) {
        echo "Farmer with ID: $farmerID deleted successfully";
        header('location:farmer.php');
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>
