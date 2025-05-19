<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'donor'; // Default role for registration

        $stmt = $conn->prepare("INSERT INTO users (username, email, contact_number, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $contact, $hashed_password, $role);

        if ($stmt->execute()) {
            // After successful registration, redirect to the login page
            header('Location: login.php');
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Donor Registration</h1>
        <form action="donor_register.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="contact">Contact Number:</label>
            <input type="text" name="contact" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
