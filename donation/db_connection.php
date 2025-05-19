<?php
$servername = "localhost";
$username = "root";  // default MySQL username for XAMPP/WAMP
$password = "";      // default MySQL password for XAMPP/WAMP (blank)
$dbname = "medicine_donation";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
