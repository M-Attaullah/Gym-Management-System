<?php
$servername = "localhost";
$username = "root"; // Adjust based on your database credentials
$password = ""; // Adjust based on your database credentials
$dbname = "gymwebsite";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $phone = $_POST['phonenmbr'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Assuming you have a password field in your form

    // Hash the Password
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO Users (FullName, Address, PhoneNmbr, Email, Username, Password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fullname, $address, $phone, $email, $username, $hashed_password); // Use $phone instead of $phonenmbr

    // Execute the statement
    if ($stmt->execute()) {
    // Registration successful, redirect to login page
        header("Location: login.html");
        exit(); // Stop script execution after redirection
    } else {
        echo "Error: " . $stmt->error; // Use $stmt->error instead of $conn->error
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
