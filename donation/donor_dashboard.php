<?php
session_start();
if ($_SESSION['role'] !== 'donor') {
    header('Location: login.php');
    exit();
}

$receipt = isset($_SESSION['receipt']) ? $_SESSION['receipt'] : null;
unset($_SESSION['receipt']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>    
        <h1>Welcome to the Medicine Donation Platform</h1>
    </header>

    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <p>Thank you for helping others by donating medicine.</p>

        <?php if ($receipt): ?>
            <h2>Donation Receipt</h2>
            <p><strong>Medicine Name:</strong> <?php echo htmlspecialchars($receipt['medicine_name']); ?></p>
            <p><strong>Quantity:</strong> <?php echo htmlspecialchars($receipt['quantity']); ?></p>
            <p><strong>Expiration Date:</strong> <?php echo htmlspecialchars($receipt['expiration_date']); ?></p>
            <p><strong>Thank you for your generous donation!</strong></p>
        <?php endif; ?>

        <a href="donate_medicine.php">Donate More Medicine</a> |
        <a href="logout.php">Logout</a>
    </div>

    <footer>
        <p>&copy; 2025 Medicine Donation Platform. All Rights Reserved.</p>
    </footer>
</body>
</html>
