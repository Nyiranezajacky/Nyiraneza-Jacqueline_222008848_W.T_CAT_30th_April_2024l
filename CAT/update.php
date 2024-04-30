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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $productID = mysqli_real_escape_string($conn, $_POST['productID']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    // Attempt update query execution
    $sql = "UPDATE product SET Name='$name', Price='$price', Quantity='$quantity' WHERE ProductID='$productID'";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        header('location:products.php');
        exit(); // Exit after redirect
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Retrieve product details based on ID from URL parameter
if (isset($_GET['id'])) {
    $productID = $_GET['id'];
    $sql = "SELECT * FROM product WHERE ProductID='$productID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Update Product</h2>

    <form action="#" method="post">
        <input type="hidden" name="productID" value="<?php echo $row['ProductID']; ?>">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['Name']; ?>" required>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" min="0" step="0.01" value="<?php echo $row['Price']; ?>" required>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="0" value="<?php echo $row['Quantity']; ?>" required>

        <input type="submit" value="Update">
    </form>

</body>
</html>
<?php
    } else {
        echo "Product not found";
    }
} else {
    echo "Product ID not provided";
}

// Close connection
$conn->close();
?>
