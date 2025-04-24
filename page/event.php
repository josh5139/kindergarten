<?php
session_start();
include("../config.php");

// Fetch upcoming events
$events = [];
$stmt = $conn->prepare("SELECT * FROM events ORDER BY event_date ASC");
if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | Little Bloom</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Poppins&family=Quicksand&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style_event.css">
</head>
<body>
    <header>
        <h1>🎉 School Events</h1>
        <nav>
            <ul class="nav-menu">
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="courses_management.php">Courses</a></li>
                <li><a href="attendance .php">Attendance</a></li>
                <li><a href="assessment.php">Assessments</a></li>
                <li><a href="add_fee.php">Fees</a></li>
                <li><a href="upload_document.php">Documents</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="events-section">
            <h2>Upcoming Events</h2>
            <?php if (count($events) > 0): ?>
                <?php foreach ($events as $event): ?>
                    <div class="event">
                        <h3><?= htmlspecialchars($event['event_name']) ?></h3>
                        <p><strong>Date:</strong> <?= htmlspecialchars($event['event_date']) ?></p>
                        <p><?= nl2br(htmlspecialchars($event['event_description'])) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No upcoming events at the moment.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
