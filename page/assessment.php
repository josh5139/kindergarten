<?php
include("../config.php");

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST["student_id"];
    $subject = $_POST["subject"];
    $score = $_POST["score"];
    $comment = $_POST["comment"];

    if (!is_numeric($student_id) || empty($subject) || empty($score)) {
        $error = "Please fill all required fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO assessments (student_id, subject, score, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $student_id, $subject, $score, $comment);

        if ($stmt->execute()) {
            $success = "✅ Assessment recorded!";
        } else {
            $error = "❌ Failed to save assessment.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Assessment</title>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Poppins&family=Quicksand&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/global.css" />
  <link rel="stylesheet" href="../assets/css/style_assessment.css">
</head>
<body>
  <h2>📊 Record Assessment</h2>
  <form method="POST">
    <label>Student ID:</label>
    <input type="number" name="student_id" required>

    <label>Subject:</label>
    <input type="text" name="subject" required>

    <label>Score:</label>
    <input type="number" name="score" required>

    <label>Comment:</label>
    <textarea name="comment" rows="3"></textarea>

    <button type="submit">Submit Assessment</button>
  </form>

  <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
  <?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
</body>
</html>
