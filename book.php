<?php
// book.php

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Include database connection
require_once 'db_connect.php';

// Initialize variables
$cottage_title = $checkin = $checkout = $id_type = $id_number = $payment_method = $guests = $special_requests = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $cottage_title = trim($_POST['cottage_title']);
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $id_type = $_POST['id_type'];
    $id_number = trim($_POST['id_number']);
    $payment_method = $_POST['payment_method'];
    $guests = $_POST['guests'];
    $special_requests = trim($_POST['special_requests']);

    // Validate inputs
    if (empty($cottage_title)) {
        $errors[] = 'Cottage title is required.';
    }

    if (empty($checkin)) {
        $errors[] = 'Check-in date and time is required.';
    }

    if (empty($checkout)) {
        $errors[] = 'Check-out date and time is required.';
    }

    if (empty($id_type)) {
        $errors[] = 'ID type is required.';
    }

    if (empty($id_number)) {
        $errors[] = 'ID number is required.';
    }

    if (empty($payment_method)) {
        $errors[] = 'Payment method is required.';
    }

    if (empty($guests)) {
        $errors[] = 'Number of guests is required.';
    }

    // Insert booking
    if (empty($errors)) {
        $stmt = $conn->prepare('INSERT INTO bookings (user_id, cottage_title, checkin, checkout, id_type, id_number, payment_method, guests, special_requests) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('issssssss', $_SESSION['user_id'], $cottage_title, $checkin, $checkout, $id_type, $id_number, $payment_method, $guests, $special_requests);
        if ($stmt->execute()) {
            header('Location: booking_success.php');
            exit;
        } else {
            $errors[] = 'Booking failed. Please try again.';
        }
        $stmt->close();
    }
}
?>

<!-- HTML form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Cottage</title>
    <!-- Include your CSS styles here -->
</head>
<body>
    <h2>Book a Cottage</h2>
    <?php
    if (!empty($errors)) {
        echo '<ul style="color:red;">';
        foreach ($errors as $error) {
            echo "<li>{$error}</li>";
        }
        echo '</ul>';
    }
    ?>
    <form action="book.php" method="post">
        <label>Cottage Title:</label>
        <input type="text" name="cottage_title" value="<?= htmlspecialchars($cottage_title); ?>" required><br>

        <label>Check-In:</label>
        <input type="datetime-local" name="checkin" value="<?= htmlspecialchars($checkin); ?>" required><br>

        <label>Check-Out:</label>
        <input type="datetime-local" name="checkout" value="<?= htmlspecialchars($checkout); ?>" required><br>

        <label>ID Type:</label>
        <select name="id_type" required>
            <option value="">Select ID</option>
            <option value="Philippine Passport" <?= $id_type == 'Philippine Passport' ? 'selected' : ''; ?>>Philippine Passport</option>
            <option value="Driver's License" <?= $id_type == "Driver's License" ? 'selected' : ''; ?>>Driver's License</option>
            <option value="PhilHealth ID" <?= $id_type == 'PhilHealth ID' ? 'selected' : ''; ?>>PhilHealth ID</option>
            <option value="SSS ID" <?= $id_type == 'SSS ID' ? 'selected' : ''; ?>>SSS ID</option>
            <option value="UMID" <?= $id_type == 'UMID' ? 'selected' : ''; ?>>UMID</option>
            <option value="TIN ID" <?= $id_type == 'TIN ID' ? 'selected' : ''; ?>>TIN ID</option>
            <option value="Voter's ID" <?= $id_type == "Voter's ID" ? 'selected' : ''; ?>>Voter's ID</option>
            <option value="National ID" <?= $id_type == 'National ID' ? 'selected' : ''; ?>>National ID</option>
        </select><br>

        <label>ID Number:</label>
        <input type="text" name="id_number" value="<?= htmlspecialchars($id_number); ?>" required><br>

        <label>Payment Method:</label>
        <select name="payment_method" required
::contentReference[oaicite:0]{index=0}
 
