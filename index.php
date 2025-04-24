<?php
  $base_url = "./";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Little Bloom Kindergarten</title>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Poppins&family=Quicksand&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/global.css" />
  <link rel="stylesheet" href="./assets/css/style_index.css">
  <script src="./assets/js/main.js" defer></script>
 
</head>
<body>

  <header>
    <div class="container">
      <h1 style="font-weight: bolder;">Little Bloom</h1>
      <nav>
        <ul class="nav-links">
          <li><a href="index.php">Home</a></li>
          <li><a href="./page/about_us.php">About us</a></li>
          <li><a href="./page/contact.php">Contact Us</a></li>
          <li><a href="./page/login.php">Login</a></li>
          <li><a href="./page/logout.php">logout</a></li>
          
        </ul>
      </nav>
    </div>
  </header>

  <section class="hero" id="hero">
    <div class="container">
      <h2>🌟 Where Little Minds Grow Big!</h2>
      <p>We nurture young minds through creativity, care, and fun learning in Ethiopia.</p>
      <a href="./page/login.php" class="cta-button">Enroll Now</a>
    </div>
  </section>

  <!-- Mission Section -->
  <section class="mission" id="mission">
    <div class="container">
      <h2>Our Mission</h2>
      <p>At Little Bloom Kindergarten, we are committed to providing a safe, nurturing, and enriching environment where every child is encouraged to explore, grow, and develop at their own pace. Our team of dedicated teachers and staff fosters creativity, curiosity, and a love for learning through hands-on experiences and play-based education.</p>
    </div>
  </section>

  <!-- Why Choose Us Section -->
  <section class="why-choose-us" id="why-choose-us">
    <div class="container">
      <h2>Why Choose Little Bloom?</h2>
      <ul>
        <li>🧸 Creative and Fun Learning Environment</li>
        <li>👩‍🏫 Experienced and Caring Teachers</li>
        <li>📚 Age-Appropriate Curriculum</li>
        <li>🌍 Focus on Holistic Development</li>
        <li>💖 Parent-Teacher Collaboration</li>
      </ul>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features" id="features">
    <div class="container features-grid">
      <div class="card">
        <img src="assets/imgs/enroll.png" alt="Enroll Icon" width="100px">
        <h3>🧒 Enroll Your Child</h3>
        <p>Begin their learning adventure in a safe and joyful environment.</p>
      </div>
      <div class="card">
        <img src="assets/imgs/tech.jpg" width="300px" alt="Teachers Icon">
        <h3>👩‍🏫 Meet Our Teachers</h3>
        <p>Our caring and certified teachers inspire young learners every day.</p>
      </div>
      <div class="card">
        <img src="assets/imgs/flag2.jpg" width="200px" alt="Events Icon">
        <h3>📅 Upcoming Events</h3>
        <p>Stay informed about fun events and school activities.</p>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="testimonials" id="testimonials">
    <div class="container">
      <h2>What Parents Say</h2>
      <div class="testimonial-card">
        <p>"Little Bloom has been an amazing experience for our child..." - Sarah</p>
      </div>
      <div class="testimonial-card">
        <p>"We couldn't be happier with Little Bloom!..." - John</p>
      </div>
    </div>
  </section>

  <!-- Gallery -->
  <section class="gallery" id="gallery">
    <div class="container">
      <h2>Gallery</h2>
      <div class="gallery-grid">
        <img src="assets/imgs/classroom.jpg"width="200px" alt="Classroom">
        <img src="assets/imgs/21589058.jpg"width="200px" alt="Playground">
        <img src="assets/imgs/photo12.jpg"width="100px" class="btn" alt="Activities">
        <img src="assets/imgs/tech.jpg"width="200px" alt="Teachers">
      </div>
    </div>
  </section>

  <!-- Enrollment Form -->
  <section id="enrollment-form">
    <h2>Enrollment Form</h2>
    <form id="enrollForm">
      <div>
        <label for="childName">Child's Name:</label>
        <input type="text" id="childName" required>
      </div>
      <div>
        <label for="parentName">Parent's Name:</label>
        <input type="text" id="parentName" required>
      </div>
      <button type="submit">Submit Enrollment</button>
    </form>
    <p id="formMessage"></p>
  </section>

  <!-- Contact Section -->
  <section class="contact" id="contact">
    <div class="container">
      <h2>Contact Us</h2>
      <p>Email: contact@littlebloom.com</p>
      <p>Phone: +251 911 123 456</p>
      <p>Address: Hossanna, Ethiopia</p>
    </div>
  </section>

  <?php include('./page/footer.php'); ?>
</body>
</html>
