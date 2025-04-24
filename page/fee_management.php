<?php
session_start();
include("../config.php");

$fees = null;

if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];

    $stmt = $conn->prepare("SELECT total_fee, amount_paid, balance FROM fees WHERE student_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $fees = $result->fetch_assoc();
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Management | Little Bloom</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Poppins&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/global.css" />
    <link rel="stylesheet" href="../assets/css/style_fee.css"/>
</head>
<body>
    <header>
        <h1>💰 Fee Management</h1>
    </header>
    <section>
        <h2>Your Fee Details</h2>
        <?php if ($fees): ?>
            <p><strong>Total Fee:</strong> <?= htmlspecialchars($fees['total_fee']) ?> ETB</p>
            <p><strong>Amount Paid:</strong> <?= htmlspecialchars($fees['amount_paid']) ?> ETB</p>
            <p><strong>Remaining Balance:</strong> <?= htmlspecialchars($fees['balance']) ?> ETB</p>
        <?php else: ?>
            <p>No fee records found for your account.</p>
        <?php endif; ?>
    </section>
</body>
</html>
