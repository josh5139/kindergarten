<?php
include("../config.php");
session_start();

$error = "";
$success = "";

// Add course
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $course_name = trim($_POST["course_name"]);
    $description = trim($_POST["description"]);
    $teacher_id = $_POST["teacher_id"];

    if (empty($course_name)) {
        $error = "❌ Course name is required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO courses (course_name, description, teacher_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $course_name, $description, $teacher_id);
        if ($stmt->execute()) {
            $success = "✅ Course added successfully!";
        } else {
            $error = "❌ Failed to add course.";
        }
        $stmt->close();
    }
}

// Get teacher list
$teachers = $conn->query("SELECT id, fullname FROM users WHERE role='teacher'");

// Get courses
$courses = $conn->query("SELECT c.id, c.course_name, c.description, u.fullname as teacher 
                         FROM courses c 
                         LEFT JOIN users u ON c.teacher_id = u.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Courses - Little Bloom</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/global.css" />
    <link rel="stylesheet" href="../assets/css/courses.css">
</head>
<body>
<main class="course-container">
    <h2>📚 Manage Courses</h2>

    <?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
    <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>

    <form method="POST" class="course-form">
        <div class="form-group">
            <label>Course Name:</label>
            <input type="text" name="course_name" required />
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description"></textarea>
        </div>
        <div class="form-group">
            <label>Assign Teacher:</label>
            <select name="teacher_id">
                <option value="">-- Select Teacher --</option>
                <?php while ($row = $teachers->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['fullname']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn-submit">Add Course</button>
    </form>

    <hr />
    <h3>📖 Course List</h3>
    <table class="course-table">
        <thead>
            <tr>
                <th>Course</th>
                <th>Description</th>
                <th>Teacher</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($course = $courses->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($course['course_name']) ?></td>
                    <td><?= htmlspecialchars($course['description']) ?></td>
                    <td><?= htmlspecialchars($course['teacher']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>
</body>
</html>
