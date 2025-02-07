<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to your database
    $servername = "localhost";
    $dbusername = "root"; // Adjust based on your database credentials
    $dbpassword = ""; // Adjust based on your database credentials
    $dbname = "gymwebsite";

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['Password'])) {
            // Login successful, redirect to Home.html
            header("Location: Home.html");
            exit();
        } else {
            // Invalid password
            header("Location: login.html?error=1");
            exit();
        }
    } else {
        // Invalid username
        header("Location: login.html?error=1");
        exit();
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
