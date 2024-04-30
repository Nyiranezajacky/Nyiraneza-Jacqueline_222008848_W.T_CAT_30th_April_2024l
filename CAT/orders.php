<?php
// Check if ID parameter is passed

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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $orderID = $_POST['OrderID'];
    $quantity = $_POST['Quantity'];
    $totalPrice = $_POST['TotalPrice'];
    $orderDate = $_POST['OrderDate'];
    $orderStatus = $_POST['OrderStatus'];
    $farmerID = $_POST['FarmerID'];

    // Prepare the SQL statement
    $sql = "INSERT INTO orders (OrderID, Quantity, TotalPrice, OrderDate, OrderStatus, FarmerID) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $orderID, $quantity, $totalPrice, $orderDate, $orderStatus, $farmerID);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('New record created successfully')</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form</title>
    <style>
        <style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color:white;
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
  .container {
    max-width: 600px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  .form-group {
    margin-bottom: 20px;
  }
  label {
    font-weight: bold;
  }
  input[type="text"], input[type="email"], textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
  input[type="submit"] {
    background-color: #2a09e3;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
  }
  input[type="submit"]:hover {
    background-color: #45a049;
  }
</style>
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="userdash.html">Home</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Settings</a>
                    <div class="dropdown-content">
                        <a href="logout.php">Log Out</a>
                        <a href="view.php">view my orders</a>
                    </div>
                </li>
            </ul>
        </nav>
        <h2>User Dashboard</h2>
    </header>

    <div class="container">
        <h2>Order Form</h2>
        <form action="orders.php" method="POST">
            <div class="form-group">
                <label for="OrderID">Order ID:</label>
                <input type="text" id="OrderID" name="OrderID" required>
            </div>
            <div class="form-group">
                <label for="Quantity">Quantity:</label>
                <input type="number" id="Quantity" name="Quantity" required>
            </div>
            <div class="form-group">
                <label for="TotalPrice">Total Price:</label>
                <input type="number" id="TotalPrice" name="TotalPrice" required>
            </div>
            <div class="form-group">
                <label for="OrderDate">Order Date:</label>
                <input type="date" id="OrderDate" name="OrderDate" required>
            </div>
            <div class="form-group">
                <label for="OrderStatus">Order Status:</label>
                <select id="OrderStatus" name="OrderStatus" required>
                    <option value="Pending">Pending</option>
                    <option value="Processing">Processing</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
            <div class="form-group">
                <label for="FarmerID">Farmer ID:</label>
                <input type="text" id="FarmerID" name="FarmerID" required>
            </div>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
