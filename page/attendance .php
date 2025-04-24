<?php
include("../config.php");

$error = "";
$success = "";

// Optional: Skip login for now or add session check if needed

$date = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST['student_id']);
    $status = $_POST['status'];

    if (!is_numeric($student_id)) {
        $error = "❌ Invalid student ID.";
    } else {
        $checkStudent = $conn->prepare("SELECT id FROM students WHERE id = ?");
        $checkStudent->bind_param("i", $student_id);
        $checkStudent->execute();
        $checkStudent->store_result();

        if ($checkStudent->num_rows == 0) {
            $error = "❌ Student not found.";
        } else {
            $checkAttendance = $conn->prepare("SELECT id FROM attendance WHERE student_id = ? AND date = ?");
            $checkAttendance->bind_param("is", $student_id, $date);
            $checkAttendance->execute();
            $checkAttendance->store_result();

            if ($checkAttendance->num_rows > 0) {
                $error = "⚠️ Attendance already submitted for today.";
            } else {
                $insert = $conn->prepare("INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)");
                $insert->bind_param("iss", $student_id, $date, $status);

                if ($insert->execute()) {
                    $success = "✅ Attendance recorded successfully!";
                } else {
                    $error = "❌ Database error.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Attendance</title>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Poppins&family=Quicksand&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/global.css" />
  <link rel="stylesheet" href="../assets/css/att.css">
</head>
<body>
  <h2>📋 Record Attendance</h2>
  <form method="POST">
    <label>Student ID:</label>
    <input type="text" name="student_id" required>

    <label>Status:</label>
    <select name="status" required>
      <option value="present">Present</option>
      <option value="absent">Absent</option>
    </select>

    <button type="submit">Submit</button>
  </form>

  <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
  <?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
</body>
</html>
