<?php
session_start();
include("../config.php");

// ✅ Check if user is logged in and is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}

$teacher_name = "Teacher";  

if (isset($_SESSION['user_id'])) {
    $teacher_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $teacher_name = $row['username'];
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
    <title>Teacher Dashboard | Little Bloom</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Poppins&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/global.css" />
    <link rel="stylesheet" href="../assets/css/style_teacher.css">
</head>
<body>
    <header>
        <h1>👩‍🏫 Teacher Dashboard</h1>
        <nav>
            <a href="../page/dashboard.php" class="active">Dashboard</a>
            <a href="../page/attendance .php">Attendance</a>
            <a href="../page/assessment.php">Assessments</a>
            <a href="../page/upload_document.php">Document</a>
            <a href="../page/view_document.php">view</a>
            <a href="../page/login.php">Login</a>
            <a href="../page/logout.php">Logout</a>
        </nav>
    </header>
    <section>
        <h2>Welcome back, <?= htmlspecialchars($teacher_name) ?>!</h2>
        <p>Here's what's happening today at Little Bloom 🌼</p>
        <div>
            <h3>📚 My Classes</h3>
            <p>Manage your assigned classrooms.</p>
            <a href="#">View Classes</a>
        </div>
    </section>
</body>
</html>
