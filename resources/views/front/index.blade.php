<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gym Website</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="container navbar">
      <div class="logo">FitnessClub</div>
      <ul class="nav-links">
        <li><a href="#hero">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#classes">Classes</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="{{ route('login_get') }}">Login</a></li>
      </ul>
      <div class="hamburger" onclick="openMenu()">☰</div>
    </div>
  </header>

  <!-- Mobile Fullscreen Menu -->
  <div class="mobile-menu" id="mobileMenu">
    <span class="close-menu" onclick="closeMenu()">✖</span>
    <ul>
      <li><a href="#hero" onclick="closeMenu()">Home</a></li>
      <li><a href="#about" onclick="closeMenu()">About</a></li>
      <li><a href="#classes" onclick="closeMenu()">Classes</a></li>
      <li><a href="#contact" onclick="closeMenu()">Contact</a></li>
    </ul>
  </div>

  <!-- HERO -->
  <section class="hero" id="hero">
    <h1>Push Your Limits</h1>
    <p>Join the best fitness club in town and achieve your goals</p>
    <a href="#contact" class="btn">Get Started</a>
  </section>

  <!-- ABOUT -->
  <section class="about" id="about">
    <img src="https://images.unsplash.com/photo-1599058917212-d750089bc07c?w=600" alt="About Us">
    <div class="about-text">
      <h2>About Us</h2>
      <p>
        We provide world-class training, modern equipment, and a community-driven
        environment where fitness meets lifestyle. Our certified trainers will
        help you achieve your goals step by step.
      </p>
    </div>
  </section>

  <!-- CLASSES -->
  <section class="classes" id="classes">
    <h2>Our Classes</h2>
    <div class="class-grid container">
      <div class="class-card">
        <img src="https://images.unsplash.com/photo-1558611848-73f7eb4001a1?w=600" alt="Yoga">
        <h3>Yoga</h3>
        <p>Improve flexibility, balance, and peace of mind with our yoga sessions.</p>
      </div>
      <div class="class-card">
        <img src="https://images.unsplash.com/photo-1558611848-73f7eb4001a1?w=600" alt="Cardio">
        <h3>Cardio</h3>
        <p>Boost your stamina with high-energy cardio workouts.</p>
      </div>
      <div class="class-card">
        <img src="https://images.unsplash.com/photo-1599058917212-d750089bc07c?w=600" alt="Strength">
        <h3>Strength</h3>
        <p>Build muscle and power with guided strength training programs.</p>
      </div>
    </div>
  </section>

  <!-- CONTACT -->
  <section class="contact" id="contact">
    <h2>Contact Us</h2>
    <form>
      <input type="text" placeholder="Your Name" required>
      <input type="email" placeholder="Your Email" required>
      <textarea rows="5" placeholder="Message"></textarea>
      <button type="submit" class="btn">Send Message</button>
    </form>
  </section>

  <!-- FOOTER -->
  <footer class="footer">
    <p>&copy; 2025 FitnessClub. All rights reserved.</p>
  </footer>

  <!-- SCRIPT -->
  <script>
    function openMenu() {
      document.getElementById("mobileMenu").classList.add("active");
    }
    function closeMenu() {
      document.getElementById("mobileMenu").classList.remove("active");
    }
  </script>
</body>
</html>
