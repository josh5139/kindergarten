<?php
include("../config.php");
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'] ?? null;
    $fee_type = $_POST['fee_type'] ?? '';
    $amount = $_POST['amount'] ?? 0;
    $due_date = $_POST['due_date'] ?? '';
    $status = $_POST['status'] ?? '';
    $payment_date = ($status === 'Paid') ? date("Y-m-d") : null;

    // Check if student exists first
    $check = $conn->prepare("SELECT id FROM students WHERE id = ?");
    $check->bind_param("i", $student_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows == 0) {
        $message = "❌ Error: Student ID does not exist!";
    } else {
        $stmt = $conn->prepare("INSERT INTO fees (student_id, fee_type, amount, due_date, status, payment_date) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            $message = "❌ Prepare failed: " . $conn->error;
        } else {
            $stmt->bind_param("isdsss", $student_id, $fee_type, $amount, $due_date, $status, $payment_date);
            if ($stmt->execute()) {
                $message = "✅ Fee record added successfully!";
            } else {
                $message = "❌ Execute failed: " . $stmt->error;
            }
            $stmt->close();
        }
    }

    $check->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Fee Record | Little Bloom</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Poppins&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/global.css" />
    <link rel="stylesheet" href="../assets/css/style_fee_form.css">

</head>
<body>
    <h1>💰 Add Fee Record</h1>
    <form method="POST">
        <label>Student ID:</label><br>
        <input type="number" name="student_id" required><br><br>

        <label>Fee Type:</label><br>
        <input type="text" name="fee_type" required><br><br>

        <label>Amount:</label><br>
        <input type="number" step="0.01" name="amount" required><br><br>

        <label>Due Date:</label><br>
        <input type="date" name="due_date" required><br><br>

        <label>Status:</label><br>
        <select name="status" required>
            <option value="Unpaid">Unpaid</option>
            <option value="Paid">Paid</option>
        </select><br><br>

        <button type="submit">Add Fee</button>
    </form>
    <p><?= htmlspecialchars($message) ?></p>
</body>
</html>
