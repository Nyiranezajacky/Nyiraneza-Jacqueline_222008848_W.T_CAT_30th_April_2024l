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

    // Retrieve farmer information based on ID
    $sql = "SELECT * FROM farmer WHERE FarmerID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $farmerID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Fetch farmer details
        $row = $result->fetch_assoc();
        $firstName = $row['FirstName'];
        $lastName = $row['LastName'];
        $contactNumber = $row['ContactNumber'];
        $email = $row['Email'];
        $farmLocation = $row['FarmLocation'];
        $farmSize = $row['FarmSize'];
        $membershipStatus = $row['MembershipStatus'];
    } else {
        echo "No farmer found with ID: $farmerID";
    }

    // Close connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
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

    // Prepare the SQL statement
    $sql = "UPDATE farmer SET FirstName=?, LastName=?, ContactNumber=?, Email=?, FarmLocation=?, FarmSize=?, MembershipStatus=? WHERE FarmerID=?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $firstName, $lastName, $contactNumber, $email, $farmLocation, $farmSize, $membershipStatus, $farmerID);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect back to farmer page
        header("Location: farmer.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Farmer</title>
<!-- Add your CSS styling here -->
</head>
<body>
<h2>Update Farmer Information</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="FarmerID" value="<?php echo $farmerID; ?>">

    <label for="FirstName">First Name:</label><br>
    <input type="text" id="FirstName" name="FirstName" value="<?php echo $firstName; ?>" required><br>

    <label for="LastName">Last Name:</label><br>
    <input type="text" id="LastName" name="LastName" value="<?php echo $lastName; ?>" required><br>

    <label for="ContactNumber">Contact Number:</label><br>
    <input type="tel" id="ContactNumber" name="ContactNumber" value="<?php echo $contactNumber; ?>" required><br>

    <label for="Email">Email:</label><br>
    <input type="email" id="Email" name="Email" value="<?php echo $email; ?>" required><br>

    <label for="FarmLocation">Farm Location:</label><br>
    <input type="text" id="FarmLocation" name="FarmLocation" value="<?php echo $farmLocation; ?>" required><br>

    <label for="FarmSize">Farm Size:</label><br>
    <input type="number" id="FarmSize" name="FarmSize" value="<?php echo $farmSize; ?>" required><br>

    <label for="MembershipStatus">Membership Status:</label><br>
    <select id="MembershipStatus" name="MembershipStatus" required>
        <option value="Active" <?php if($membershipStatus == 'Active') echo 'selected'; ?>>Active</option>
        <option value="Inactive" <?php if($membershipStatus == 'Inactive') echo 'selected'; ?>>Inactive</option>
    </select><br><br>

    <input type="submit" value="Update">
</form>
</body>
</html>
