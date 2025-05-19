<?php
session_start();
require_once 'db_connection.php';

if ($_SESSION['role'] !== 'donor') {
    // If the user is not a donor, redirect them to the login page
    header('Location: login.php');
    exit();
}
$receipt = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medicine_name = $_POST['medicine_name'];
    $quantity = $_POST['quantity'];
    $expiration_date = $_POST['expiration_date'];
    $donor_id = $_SESSION['id'];

    // Insert the donated medicine details into the database
    $stmt = $conn->prepare("INSERT INTO medicines (name, quantity, expiration_date, donor_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sisi", $medicine_name, $quantity, $expiration_date, $donor_id);

    if ($stmt->execute()) {
      
        $receipt = [
            'medicine_name' => $medicine_name,
            'quantity' => $quantity,
            'expiration_date' => $expiration_date
        ];

        $_SESSION['receipt'] = $receipt;
        
       
        header('Location: donor_dashboard.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate Medicine</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome to the Medicine Donation Platform</h1>
    </header>

    <div class="container">
        <h1>Donate Medicine</h1>
        <form action="donate_medicine.php" method="POST">
            <label for="medicine_name">Medicine Name:</label>
            <input type="text" name="medicine_name" required>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required>

            <label for="expiration_date">Expiration Date:</label>
            <input type="date" name="expiration_date" required>

            <button type="submit">Donate</button>
        </form>

        <?php if ($receipt): ?>
            <h2>Donation Receipt</h2>
            <p><strong>Medicine Name:</strong> <?php echo htmlspecialchars($receipt['medicine_name']); ?></p>
            <p><strong>Quantity:</strong> <?php echo htmlspecialchars($receipt['quantity']); ?></p>
            <p><strong>Expiration Date:</strong> <?php echo htmlspecialchars($receipt['expiration_date']); ?></p>
            <p><strong>Thank you for your generous donation!</strong></p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 Medicine Donation Platform. All Rights Reserved.</p>
    </footer>
</body>
</html>
