<?php
include("../config.php");

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "❌ Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "❌ Invalid email address.";
    } else {
        $stmt = $conn->prepare("INSERT INTO contact_messages (full_name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            $success = "✅ Message sent successfully!";
        } else {
            $error = "❌ Failed to send message. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - Little Bloom</title>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Poppins&family=Quicksand&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/global.css" />
  <link rel="stylesheet" href="../assets/css/style_contact.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <main class="contact-container">
    <form method="POST" class="contact-form">
      <h2>📨 Contact Us</h2>

      <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <?php if ($success): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
      <?php endif; ?>

      <div class="form-group">
        <label>Full Name:</label>
        <input type="text" name="full_name" required />
      </div>
      <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" required />
      </div>
      <div class="form-group">
        <label>Subject:</label>
        <input type="text" name="subject" required />
      </div>
      <div class="form-group">
        <label>Message:</label>
        <textarea name="message" required></textarea>
      </div>
      <button type="submit">Send Message</button>
    </form>
  </main>
</body>
</html>
