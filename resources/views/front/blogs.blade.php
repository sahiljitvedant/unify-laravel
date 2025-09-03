<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gym Website</title>

<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
        <li><a href="#about" >About</a></li>
        <li><a href="#classes" class="active">Blogs</a></li>
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
            <h2 class="section-title">Blogs</h2>
            <div class="blogs-grid mt-3">
                <div class="class-item">
                    <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Yoga">
                    <h3>Yoga</h3>
                    <p>Improve flexibility, balance, and mental focus with our yoga sessions.</p>
                    <a href="{{ route('blogs_read_more') }}" class="btn-read">Read More
                    <i class="bi bi-arrow-right fs-5 ms-1 align-middle"></i>
                    </a>
                </div>
                <div class="class-item">
                <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Yoga">
                    <h3>Cardio</h3>
                    <p>Boost your heart health and stamina with our intensive cardio workouts.</p>
                    <a href="{{ route('blogs_read_more') }}" class="btn-read">Read More
                    <i class="bi bi-arrow-right fs-5 ms-1 align-middle"></i>
                    </a>
                </div>
                <div class="class-item">
                    <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Yoga">
                    <h3>CrossFit</h3>
                    <p>Challenge yourself with high-intensity CrossFit exercises for full-body strength.</p>
                    <a href="{{ route('blogs_read_more') }}" class="btn-read">Read More
                    <i class="bi bi-arrow-right fs-5 ms-1 align-middle"></i>
                    </a>
                </div>
                <!-- Add more cards here -->
            </div>
            <div class="blogs-grid mt-3">
                <div class="class-item">
                <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Yoga">
                    <h3>Yoga</h3>
                    <p>Improve flexibility, balance, and mental focus with our yoga sessions.</p>
                    <a href="{{ route('blogs_read_more') }}" class="btn-read">Read More
                    <i class="bi bi-arrow-right fs-5 ms-1 align-middle"></i>
                    </a>
                </div>
                <div class="class-item">
                <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Yoga">
                    <h3>Cardio</h3>
                    <p>Boost your heart health and stamina with our intensive cardio workouts.</p>
                    <a href="{{ route('blogs_read_more') }}" class="btn-read">Read More
                    <i class="bi bi-arrow-right fs-5 ms-1 align-middle"></i>
                    </a>
                </div>
                <div class="class-item">
                <img src="https://images.unsplash.com/photo-1605296867424-35fc25c9212a?w=600" alt="Yoga">
                    <h3>CrossFit</h3>
                    <p>Challenge yourself with high-intensity CrossFit exercises for full-body strength.</p>
                    <a href="{{ route('blogs_read_more') }}" class="btn-read">Read More
                    <i class="bi bi-arrow-right fs-5 ms-1 align-middle"></i>
                    </a>
                </div>
                <!-- Add more cards here -->
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
       
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            padding: 10px 0;
            z-index: 1000;
        }
        .btn-read {
            display: inline-flex;
            justify-content: center; 
            align-items: center;
            gap: 5px; 
            transition: transform 0.3s ease;
        }

        .btn-read:hover {
            transform: translateX(5px);
        }

        .nav-links a.active 
        {
            color: #0B1061; /* green highlight */
            font-weight: bold;
            border-bottom: 2px solid #0B1061;
        }
        .nav-links a,
        .mobile-menu a {
            text-decoration: none; /* remove underline */
            color: inherit;        /* optional, keeps original color */
        }
        .about-contact {
            padding: 60px 20px;
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .section-title {
            text-align: center;
            font-size: 2.2rem;
            margin-bottom: 40px;
            color: #0B1061;
            font-weight: 700;
        }

        .blogs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .class-item {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
        }

        .class-item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .class-item:hover img {
            transform: scale(1.05);
        }

        .class-item h3 {
            font-size: 1.5rem;
            margin: 15px 20px 10px;
            color: #0B1061;
        }

        .class-item p {
            font-size: 0.95rem;
            margin: 0 20px 20px;
            color: #555;
            flex-grow: 1;
        }

        .btn-read {
            text-align: center;
      
            
            color: #0B1061;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.3s;
        }

       
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .section-title {
                font-size: 1.8rem;
            }
            .class-item img {
                height: 150px;
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
    
</body>
</html>
