document.addEventListener('DOMContentLoaded', function() {
  const enrollForm = document.getElementById('enrollForm');
  const formMessage = document.getElementById('formMessage');

  if (enrollForm) {
      enrollForm.addEventListener('submit', function(event) {
          event.preventDefault(); // Prevent the default form submission

          // Basic client-side validation (you'd want more robust validation server-side)
          const childName = document.getElementById('childName').value.trim();
          const parentName = document.getElementById('parentName').value.trim();

          if (childName === '' || parentName === '') {
              formMessage.textContent = 'Please fill in all required fields.';
              formMessage.style.color = 'red';
              return;
          }

          // Simulate form submission (in a real scenario, you'd send this data to a server)
          console.log('Form submitted!');
          console.log('Child\'s Name:', childName);
          console.log('Parent\'s Name:', parentName);

          formMessage.textContent = 'Enrollment submitted successfully!';
          formMessage.style.color = 'green';
          enrollForm.reset(); // Clear the form
      });
  }

  // Example of adding a little interactivity to the gallery images
  const galleryImages = document.querySelectorAll('.gallery-grid img');
  galleryImages.forEach(img => {
      img.addEventListener('mouseover', () => {
          img.style.opacity = '0.8';
          img.style.cursor = 'pointer';
      });
      img.addEventListener('mouseout', () => {
          img.style.opacity = '1';
      });
  });

  // You can add more interactive elements and functionalities here
});