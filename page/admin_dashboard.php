<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include("../config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Little Bloom</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <header class="dashboard-header">
        <h1>Welcome, Admin</h1>
        <nav>
            <ul>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_students.php">Manage Students</a></li>
                <li><a href="courses_management.php">Manage Courses</a></li>
                <li><a href="attendance .php">Attendance Reports</a></li>
                <li><a href="assessment.php">Assessment Reports</a></li>
                <li><a href="add_fee.php">Fee Management</a></li>
                <li><a href="event.php">Events Calendar</a></li>
                <li><a href="upload_document.php">Documents</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="dashboard-main">
        <section class="overview-boxes">
            <div class="box">
                <h3>Total Users</h3>
                <p><?php 
                $result = $conn->query("SELECT COUNT(*) as count FROM users"); 
                $data = $result->fetch_assoc(); 
                echo $data['count']; 
                ?></p>
            </div>
            <div class="box">
                <h3>Total Students</h3>
                <p><?php 
                $result = $conn->query("SELECT COUNT(*) as count FROM students"); 
                $data = $result->fetch_assoc(); 
                echo $data['count']; 
                ?></p>
            </div>
            <div class="box">
                <h3>Upcoming Events</h3>
                <p><?php 
                $today = date('Y-m-d');
                $result = $conn->query("SELECT COUNT(*) as count FROM events WHERE event_date >= '$today'"); 
                $data = $result->fetch_assoc(); 
                echo $data['count']; 
                ?></p>
            </div>
        </section>
    </main>
</body>
</html>
