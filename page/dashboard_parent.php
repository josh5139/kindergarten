<?php
session_start();
include("../config.php");

$parent_name = "Parent";  // Default fallback name

if (isset($_SESSION['user_id'])) {
    $parent_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $parent_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $parent_name = $row['username'];
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard | Little Bloom</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Poppins&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/global.css" />
    <link rel="stylesheet" href="../assets/css/style_parent.css">
</head>
<body>
    <header>
        <h1>👨‍👩‍👧‍👦 Parent Dashboard</h1>
        <nav>
            <a href="../page/dashboard.php"> Dashboard</a>
            <a href="../page/add_fee.php">Fee Management</a>
            <a href="../page/attendance .php">Attendance</a>
            <a href="../page/event.php">Events</a>
            <a href="../page/logout.php">Logout</a>

        </nav>
    </header>
    <section>
        <h2>Welcome back, <?= htmlspecialchars($parent_name) ?>!</h2>
        <p>Here is your child's progress at Little Bloom 🌼</p>
    </section>
</body>
</html>
