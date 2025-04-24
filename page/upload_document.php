<?php
// upload_document.php
session_start();
include("../config.php");

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
    $student_id = $_POST['student_id'];
    $description = trim($_POST['description']);
    $uploaded_by = $_SESSION['role'];

    $file = $_FILES['document'];
    $targetDir = "../uploads/documents/";
    $fileName = basename($file["name"]);
    $targetFilePath = $targetDir . time() . "_" . $fileName;

    if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
        $stmt = $conn->prepare("INSERT INTO documents (student_id, file_name, file_path, uploaded_by, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $student_id, $fileName, $targetFilePath, $uploaded_by, $description);
        if ($stmt->execute()) {
            $success = "✅ Document uploaded successfully.";
        } else {
            $error = "❌ Database error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "❌ Failed to upload the document.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Document - Little Bloom</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="">
</head>
<body>
    <main class="upload-form">
        <h2>📁 Upload Student Document</h2>
        <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
        <?php if ($success): ?><p class="success"><?= htmlspecialchars($success) ?></p><?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Student ID:</label>
                <input type="number" name="student_id" required />
            </div>
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Select Document (PDF, JPG, DOCX):</label>
                <input type="file" name="document" required />
            </div>
            <button type="submit" class="btn-upload">Upload</button>
        </form>
    </main>
</body>
</html>
