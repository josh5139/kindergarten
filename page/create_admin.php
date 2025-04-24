<?php
include("../config.php"); 

$fullname = "Ejara Worku";
$username = "ejara"; 
$email = "ejarawo@mail.com";
$plain_password = "Ejara@2025"; 
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
$role = "admin";

// Check if admin already exists to prevent duplicates
$check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$check->bind_param("ss", $username, $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "⚠️ Admin user already exists.";
} else {
    $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fullname, $username, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "✅ Admin account created successfully.";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
    $stmt->close();
}
$check->close();
$conn->close();
?>
