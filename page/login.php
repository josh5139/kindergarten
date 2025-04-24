<?php
ob_start();
session_start();
include("../config.php");

$error = "";
$success = "";

// Redirect if already logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    if ($role === "teacher") {
        header("Location: dashboard_teacher.php");
    } elseif ($role === "parent") {
        header("Location: dashboard_parent.php");
    } elseif ($role === "admin") {
        header("Location: admin_dashboard.php");
    }
    exit();
}

// Handle Login
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ? AND role = ?");
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;

            if ($role === "teacher") {
                header("Location: dashboard_teacher.php");
            } elseif ($role === "parent") {
                header("Location: dashboard_parent.php");
            } elseif ($role === "admin") {
                header("Location: admin_dashboard.php");
            }
            exit();
        } else {
            $error = "❌ Invalid password.";
        }
    } else {
        $error = "⚠️ No user found with this username and role.";
    }
    $stmt->close();
}

// Handle Sign Up
if (isset($_POST['signup'])) {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "❌ Please enter a valid email address.";
    } elseif ($role === "admin") {
        $error = "⛔ Admin accounts can only be created manually.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $error = "⚠️ Username or email already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fullname, $username, $email, $hashed_password, $role);

            if ($stmt->execute()) {
                $success = "✅ Account created successfully. <a href='?action=login'>Login here</a>";
            } else {
                $error = "❌ Error creating account. Please try again.";
            }
        }
        $check_stmt->close();
    }
}

// Handle Student Registration
if (isset($_POST['register_student'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST["full_name"]);
    $date_of_birth = $_POST["date_of_birth"];
    $gender = $_POST["gender"];
    $parent_name = mysqli_real_escape_string($conn, $_POST["parent_name"]);
    $parent_contact = mysqli_real_escape_string($conn, $_POST["parent_contact"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);
    $created_by = $_SESSION['user_id'] ?? null;

    if (empty($full_name) || empty($date_of_birth) || empty($gender) || empty($parent_name) || empty($parent_contact)) {
        $error = "❌ Please fill in all required fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO students (full_name, date_of_birth, gender, parent_name, parent_contact, address, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $full_name, $date_of_birth, $gender, $parent_name, $parent_contact, $address, $created_by);

        if ($stmt->execute()) {
            $success = "✅ Student registered successfully!";
        } else {
            $error = "❌ Registration failed. Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login / Sign Up / Register Student - Little Bloom</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/style_login.css">
</head>
<body>
<main class="login-container">
    <h2>Little Bloom System</h2>
    <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>

    <?php if (isset($_GET['action']) && $_GET['action'] == 'signup'): ?>
        <!-- Sign Up Form -->
        <form method="POST">
            <h3>Create Account</h3>
            <input type="text" name="fullname" placeholder="Full Name" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="parent">Parent</option>
                <option value="teacher">Teacher</option>
            </select>
            <button type="submit" name="signup">Sign Up</button>
        </form>
    <?php elseif (isset($_GET['action']) && $_GET['action'] == 'register_student'): ?>
        <!-- Student Registration Form -->
        <form method="POST">
            <h3>Register a Student</h3>
            <input type="text" name="full_name" placeholder="Student Full Name" required>
            <input type="date" name="date_of_birth" required>
            <select name="gender" required>
                <option value="">-- Gender --</option>
                <option value="Male">Boy</option>
                <option value="Female">Girl</option>
                <option value="Other">Other</option>
            </select>
            <input type="text" name="parent_name" placeholder="Parent Name" required>
            <input type="text" name="parent_contact" placeholder="Parent Contact" required>
            <input type="text" name="address" placeholder="Address">
            <button type="submit" name="register_student">Register Student</button>
        </form>
    <?php else: ?>
        <!-- Login Form -->
        <form method="POST">
            <h3>Login</h3>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="parent">Parent</option>
                <option value="teacher">Teacher</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" name="login">Login</button>
            <p>
                <a href="?action=signup">Create an account</a> | 
                <a href="?action=register_student">Register Student</a>
            </p>
        </form>
    <?php endif; ?>
</main>
</body>
</html>

<?php ob_end_flush(); ?>
