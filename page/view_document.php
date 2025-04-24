<?php
session_start();
include("../config.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$query = "SELECT * FROM documents ORDER BY uploaded_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Uploaded Documents - Little Bloom</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/global.css" />
    <link rel="stylesheet" href="../assets/css/view.css">

</head>
<body>
    <h2>📂 Uploaded Documents</h2>

    <div class="document-list">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($doc = $result->fetch_assoc()): ?>
                <div class="document-item">
                    <span class="document-name"><?= htmlspecialchars($doc['document_name']) ?></span>
                    <span class="document-info">uploaded on <?= date("F j, Y, g:i a", strtotime($doc['uploaded_at'])) ?></span>
                    <a class="document-download" href="../uploads/<?= htmlspecialchars($doc['file_path']) ?>" target="_blank">🔽 View</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;">No documents uploaded yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
