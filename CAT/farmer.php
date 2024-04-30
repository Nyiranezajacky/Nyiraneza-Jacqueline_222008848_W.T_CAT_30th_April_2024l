<?php
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $farmerID = $_POST['FarmerID'];
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $contactNumber = $_POST['ContactNumber'];
    $email = $_POST['Email'];
    $farmLocation = $_POST['FarmLocation'];
    $farmSize = $_POST['FarmSize'];
    $membershipStatus = $_POST['MembershipStatus'];

    // Prepare the SQL statement
    $sql = "INSERT INTO farmer (FarmerID, FirstName, LastName, ContactNumber, Email, FarmLocation, FarmSize, MembershipStatus) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $farmerID, $firstName, $lastName, $contactNumber, $email, $farmLocation, $farmSize, $membershipStatus);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
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
<title>Farmer Form</title>
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
</head>
<body>
<header>
        <nav>
            <ul>
                <li><a href="admindash.html">Home</a></li>
                <li><a href="farmer.php">farmer</a></li>
                <li><a href="products.php">products</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Settings</a>
                    <div class="dropdown-content">
                        <a href="logout.php">log out</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
<div class="container">
  <h2>Farmer Registration Form</h2>
    <form action="farmer.php" method="post">
        <label for="FarmerID">Farmer ID:</label><br>
        <input type="text" id="FarmerID" name="FarmerID" required><br>

        <label for="FirstName">First Name:</label><br>
        <input type="text" id="FirstName" name="FirstName" required><br>

        <label for="LastName">Last Name:</label><br>
        <input type="text" id="LastName" name="LastName" required><br>

        <label for="ContactNumber">Contact Number:</label><br>
        <input type="tel" id="ContactNumber" name="ContactNumber" required><br>

        <label for="Email">Email:</label><br>
        <input type="email" id="Email" name="Email" required><br>

        <label for="FarmLocation">Farm Location:</label><br>
        <input type="text" id="FarmLocation" name="FarmLocation" required><br>

        <label for="FarmSize">Farm Size:</label><br>
        <input type="number" id="FarmSize" name="FarmSize" required><br>

        <label for="MembershipStatus">Membership Status:</label><br>
        <select id="MembershipStatus" name="MembershipStatus" required>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select><br><br>

        <input type="submit" value="Submit">
    </form>

</div>
 <center><h2>Farmer Information</h2></center>

<table align="center" border="1" style="border-collapse: collapse;">
  <tr style="background: blue;color: white;">
    <th>Farmer ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Contact Number</th>
    <th>Email</th>
    <th>Farm Location</th>
    <th>Farm Size</th>
    <th>Membership Status</th>
    <th>Action</th>
  </tr>

  <?php
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

  // Check if there are any rows returned
  $sql = "SELECT * FROM farmer";
$result = $conn->query($sql);
  if ($result->num_rows > 0) {
      // Output data of each row
      while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>".$row["FarmerID"]."</td>";
          echo "<td>".$row["FirstName"]."</td>";
          echo "<td>".$row["LastName"]."</td>";
          echo "<td>".$row["ContactNumber"]."</td>";
          echo "<td>".$row["Email"]."</td>";
          echo "<td>".$row["FarmLocation"]."</td>";
          echo "<td>".$row["FarmSize"]."</td>";
          echo "<td>".$row["MembershipStatus"]."</td>";
          // Add action links for delete and update
          echo "<td><a href='farmerdelete.php?id=".$row["FarmerID"]."'>Delete</a> | <a href='farmerupdate.php?id=".$row["FarmerID"]."'>Update</a></td>";
          echo "</tr>";
      }
  } else {
      echo "0 results";
  }
  ?>

</table>


</body>
</html>
