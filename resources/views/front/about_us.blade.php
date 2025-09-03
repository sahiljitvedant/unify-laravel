<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gym Website</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- HEADER -->
    <header class="header">
    <nav class="navbar">
        <div class="logo">
            <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" 
                    style="height:60px; width:180px; object-fit:cover; border-radius:10px; border:1px solid #0B1061">
            </a>
        </div>
        <ul class="nav-links">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="#about"  class="active">About</a></li>
        <li><a href="{{ route('blogs') }}">Blogs</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a target="_blank" href="{{ route('login_get') }}">Login</a></li>
        </ul>
        <div class="hamburger">&#9776;</div>
    </nav>
    </header>

    <!-- MOBILE MENU -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="#hero">Home</a>
        <a href="#about" >About</a>
        <a href="#classes">Classes</a>
        <a href="#contact">Contact</a>
        <li><a href="{{ route('login_get') }}">Login</a></li>
    </div>

    <!-- ABOUT US INFO SECTION -->
    <section id="about-contact" class="about-contact">
  <div class="about-container">
    
    <!-- Left Side: Contact Info -->
    <div class="about-info">
      <div class="contact-card">
        <h2>Get in Touch</h2>
        <p><strong>Address:</strong> Fitness Club, FC Road, Pune, Maharashtra, India</p>

        <p><strong>Phone:</strong> +91 98765 43210</p>
     
        <p><strong>Email:</strong> support@fitnessclub.com</p>
     
        <p><strong>Hours:</strong> Mon – Sat: 6:00 AM – 10:00 PM</p>
      </div>
    </div>

    <!-- Right Side: Google Map -->
    <div class="about-map">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3783.339948926727!2d73.84296771489123!3d18.5167260874091!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2c07c61e9bb8f%3A0xbee72d1c8e0f5f9c!2sFergusson%20College%20Rd%2C%20Shivajinagar%2C%20Pune%2C%20Maharashtra%20411004!5e0!3m2!1sen!2sin!4v1674123456789!5m2!1sen!2sin" 
        width="100%" 
        height="100%" 
        style="border:0;" 
        allowfullscreen 
        loading="lazy">
      </iframe>
    </div>

  </div>
</section>


    <!-- FOOTER -->
    <footer class="footer fixed-footer">
    <p>&copy;2025 Sachi. All rights reserved.</p>
    </footer>
    <style>
        .fixed-footer 
        {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
    
        text-align: center;
        padding: 10px 0;
        z-index: 1000;
        }
        .nav-links a.active 
        {
            color: #0B1061; /* green highlight */
            font-weight: bold;
            border-bottom: 2px solid #0B1061;
        }
        .contact-card
        {
            background: #f2f2f2 !important;
        }

        .about-contact {
        min-height: calc(100vh - 60px); /* full height minus footer */
        padding: 40px 20px;
        background: #f9f9f9;
        display: flex;
        align-items: center; /* vertically center */
        }

        .about-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        max-width: 1100px;
        margin: auto;
        width: 100%;
        }

        .about-info {
        flex: 1 1 45%;
        }

        .contact-card {
        background: #fff;
        border-radius: 12px;
        padding: 25px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-left: 5px solid #0B1061; /* accent bar */
        }

        .contact-card h2 {
        margin-bottom: 20px;
        font-size: 22px;
        color: #0B1061;
        }

        .contact-card p {
        margin: 10px 0;
        font-size: 16px;
        line-height: 1.6;
        color: #333;
        }

        .contact-card strong {
        color: #0B1061;
        }

        /* Right side map */
        .about-map {
        flex: 1 1 45%;
        min-height: 400px;
        }

        .about-map iframe {
        width: 100%;
        height: 100%;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
        .about-container {
            flex-direction: column;
        }
        .about-map {
            min-height: 300px;
        }
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const hamburger = document.querySelector('.hamburger');
        const mobileMenu = document.getElementById('mobileMenu');

        hamburger.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
        });

        // Close menu when clicking a link
        document.querySelectorAll('.mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#enquiryForm").on("submit", function () {
                var btn = $("#submitBtn");
                btn.prop("disabled", true).text("Please wait...");
            });
        });
        $(document).ready(function () {
            $(".nav-links a").on("click", function () {
                $(".nav-links a").removeClass("active"); // remove from all
                $(this).addClass("active"); // add to clicked
            });
        });

    </script>
</body>
</html>
