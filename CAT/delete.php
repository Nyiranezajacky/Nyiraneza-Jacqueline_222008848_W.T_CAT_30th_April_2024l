<?php
// Assuming your database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "farmer";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the product ID is provided
if (isset($_GET['id'])) {
    $productID = $_GET['id'];

    // Attempt delete query execution
    $sql = "DELETE FROM product WHERE ProductID='$productID'";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        header('location:products.php');
        exit(); // Exit after redirect
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Product ID not provided";
}

// Close connection
$conn->close();
?>
