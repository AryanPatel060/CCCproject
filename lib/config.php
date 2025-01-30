<?php
$servername = "localhost"; // Server name or IP address
$username = "root";        // MySQL username
$password = "";            // MySQL password
$dbname = "DummyDB";       // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// echo "Connected successfully!";
// echo"product<br>";
?>

 




