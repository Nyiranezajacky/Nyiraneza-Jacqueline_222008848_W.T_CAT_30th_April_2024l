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

    // Attempt insert query execution
    $sql = "INSERT INTO product (ProductID, Name, Price, Quantity) VALUES ('$productID', '$name', '$price', '$quantity')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Retrieve data from the product table
$sql = "SELECT ProductID, Name, Price, Quantity FROM product";
$result = $conn->query($sql);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <link rel="stylesheet" href="styles.css">
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        header {
            background-color: #2a09e3;
            color: #fff;
            padding: 10px 0;
            height: 50px;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            line-height: 50px;
            float: right;
        }
        nav ul li {
            display: inline;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
        }
        nav ul li a:hover {
            background-color: #555;
        }
        /* Dropdown menu styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 50px;
            z-index: 1;
        }
        .dropdown-content a {
            color: #fff;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #555;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        h1 {
            text-align: center;
        }
        .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .product {
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            text-align: center;
            cursor: pointer;
        }
        .product img {
            width: 100%;
            height: auto;
            border-radius: 5px 5px 0 0;
        }
        .product-content {
            padding: 10px;
        }
        .product-name {
            font-weight: bold;
        }
        .product-description {
            margin-top: 5px;
        }
        .product-price {
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .action {
            text-align: center;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="admindash.html">Home</a></li>
                <li><a href="farmer.php">Farmer</a></li>
                <li><a href="products.php">Products</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Settings</a>
                    <div class="dropdown-content">
                        <a href="logout.php">Log out</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Product Form -->
    <h2>Product Form</h2>
    <form action="#" method="post">
        <label for="productID">ProductID:</label>
        <input type="text" id="productID" name="productID" required>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" min="0" step="0.01" required>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="0" required>

        <input type="submit" value="Submit">
    </form>

    <!-- Product List -->
    <h2>Product List</h2>
    <table>
        <tr>
            <th>ProductID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ProductID"] . "</td>";
                echo "<td>" . $row["Name"] . "</td>";
                echo "<td>" . $row["Price"] . "</td>";
                echo "<td>" . $row["Quantity"] . "</td>";
                echo "<td class='action'>
                        <a href='update.php?id=" . $row["ProductID"] . "'>Update</a>
                         <a href='delete.php?id=" . $row["ProductID"] . "'>Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No products found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
