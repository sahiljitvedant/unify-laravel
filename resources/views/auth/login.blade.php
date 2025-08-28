<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<!-- DataTables Bootstrap 5 -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/searchpanes/2.2.0/css/searchPanes.bootstrap5.min.css" rel="stylesheet" />

<!-- Font librry -->
<!-- Google Fonts: Inter -->

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<!-- Swal Js -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html, body {
    height: 100%;
    margin: 0;
    overflow: hidden; /* prevent vertical scroll */
}
        .left-section {
            background-color: #0B1061;
            color: #fff;
        }
        .right-section {
            background-color: #0B1061;
        }
        .container-fluid {
    height: 100vh; /* full viewport height */
    padding: 0;
}

.left-section, .right-section {
    height: 100vh; /* full height for both sections */
}

.login-box {
    max-height: 90%; /* optional: keep it inside view */
    overflow: auto;  /* allow scrolling inside login-box if needed */
}
        .login-box {
            background: #fff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 6px 0 18px rgba(0, 0, 0, 0.35);
            width: 100%;
            max-width: 520px;
        }
        .login-box h3 {
            font-weight: 600;
            margin-bottom: 20px;
        }
        .register-link {
            margin-top: 15px;
            text-align: center;
        }
        .register-link a {
            text-decoration: none;
            color: #0B1061;
            font-weight: 500;
        }
        .login_btn
        {
            background-color: #0B1061;
            color: #ffffff;
        }
        .login_btn:hover
        {
            background-color: #0B1061;
            color: #ffffff;
        }
    </style>
    <style>
/* Left Section Styles */
.left-section {
    background: linear-gradient(135deg, #0B1061 0%, #1a1f7f 100%);
    color: #fff;
    position: relative;
    overflow: hidden;
}

/* Abstract Circles */
.shape-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}

.shape-circle-1 {
    width: 200px;
    height: 200px;
    top: 50px;
    right: -50px;
}

.shape-circle-2 {
    width: 300px;
    height: 300px;
    bottom: -100px;
    left: -50px;
}

.shape-circle-3 {
    width: 150px; 
    height: 150px; 
    top: 150px; 
    left: -75px; 
}

/* Quote */
.quote {
    font-size: 1rem;
    line-height: 1.5;
    max-width: 280px;
}

/* Services */
.service-box p {
    margin: 0;
    font-size: 0.85rem;
}

/* Bubble Link */
.bubble-link {
    background-color: #1a1f7f;
    border-radius: 50px;
    font-weight: 500;
    transition: background-color 0.3s, transform 0.3s;
}

.bubble-link:hover {
    background-color: #0f1470;
    transform: translateY(-2px);
    text-decoration: none;
}

/* Footer */
.bottom-footer {
    bottom: 10px;
    padding: 0 20px;
}

/* Social Icons */
.social-links a:hover {
    color: #ffd700;
    transform: scale(1.1);
    transition: 0.3s;
}
.top-feature-icons {
    position: absolute;
    top: 20px;
    width: 100%;
    gap: 25px;
}

.icon-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: rgba(255,255,255,0.3); /* subtle but visible */
    font-size: 0.7rem;
}

.icon-box i {
    margin-bottom: 4px;
}
</style>
    
</head>
<body>
<div class="container-fluid">
    <div class="row">
       <!-- Left Section -->
<div class="col-md-6 left-section d-none d-md-flex p-0 flex-column justify-content-center align-items-center text-center position-relative">
<!-- Top Feature Icons -->
<div class="top-feature-icons d-flex justify-content-center gap-4 flex-wrap">
    <div class="icon-box">
        <i class="fas fa-laptop-code fa-2x"></i>
        <p>Dev</p>
    </div>
    <div class="icon-box">
        <i class="fas fa-mobile-alt fa-2x"></i>
        <p>Apps</p>
    </div>
    <div class="icon-box">
        <i class="fas fa-cloud fa-2x"></i>
        <p>Cloud</p>
    </div>
    <div class="icon-box">
        <i class="fas fa-chart-line fa-2x"></i>
        <p>Analytics</p>
    </div>
    <div class="icon-box">
        <i class="fas fa-bullhorn fa-2x"></i>
        <p>Marketing</p>
    </div>
</div>
<!-- Background Shapes -->
<div class="shape-circle shape-circle-1"></div>
<div class="shape-circle shape-circle-2"></div>
<div class="shape-circle shape-circle-3"></div>

<!-- Logo & Tagline -->
<img src="{{ asset('assets/img/logo.png') }}" alt="Logo" 
     style="height: 65px; width:200px; object-fit:cover; border-radius:10px; border:1px solid #0B1061" class="mt-2">
<h6 class="mt-3">Crafting Digital Solutions</h6>



<!-- Service Highlights -->
<div class="d-flex justify-content-center gap-4 mt-4">
    <div class="text-center text-white service-box">
        <i class="fas fa-laptop-code fa-2x mb-2"></i>
        <p>Web Development</p>
    </div>
    <div class="text-center text-white service-box">
        <i class="fas fa-mobile-alt fa-2x mb-2"></i>
        <p>Mobile Apps</p>
    </div>
    <div class="text-center text-white service-box">
        <i class="fas fa-bullhorn fa-2x mb-2"></i>
        <p>Digital Marketing</p>
    </div>
</div>

<!-- Footer: Bubble Link + Contact -->
<div class="d-flex justify-content-between w-100 position-absolute bottom-footer px-4">
    <a href="https://www.corporatewebsite.com" target="_blank" class="bubble-link text-white text-decoration-none d-inline-flex align-items-center px-3 py-2">
        Corporate Website
        <i class="bi bi-arrow-right ms-2"></i>
    </a>

    <span class="text-white contact-info">
        Support: sachii@gmail.com | Contact: 97653453
    </span>
</div>

<!-- Social Icons -->
<div class="social-links d-flex flex-column position-absolute" style="bottom: 120px; left: 20px;">
    <a href="#" class="text-white mb-3 fs-5"><i class="fab fa-facebook-f"></i></a>
    <a href="#" class="text-white mb-3 fs-5"><i class="fab fa-twitter"></i></a>
    <a href="#" class="text-white mb-3 fs-5"><i class="fab fa-linkedin-in"></i></a>
    <a href="#" class="text-white mb-3 fs-5"><i class="fab fa-instagram"></i></a>
</div>

</div>



        <!-- Right section -->
        <div class="col-md-6 d-flex align-items-center justify-content-center ">
            <div class="d-flex flex-column align-items-center w-100 px-4">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" 
                     style="height: 65px; width:200px; object-fit:cover; border-radius:10px; border:1px solid #0B1061" class="mt-2">

                <div class="login-box mt-4">
                    <h5 class="text-center mb-4">Login</h5>
                    <form id="login_post">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <span class="text-danger error-email"></span>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <span class="text-danger error-password"></span>
                        </div>

                        <button type="submit" class="btn login_btn w-100">Submit</button>

                        <div class="register-link">
                            <p>New user? <a href="{{ url('/register') }}">Register here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script>
    let previousRequest = null;
    var addValidationRules = {
        'email': { 'required': true, 'email': true, 'maxlength': 100 },
        'password': { 'required': true, 'minlength': 6, 'maxlength': 30 }
    };
    var addValidationMessages = {
        'email': {
            'required': 'Email field is required',
            'email': 'Please enter a valid email address',
            'maxlength': 'Email cannot exceed 100 characters'
        },
        'password': {
            'required': 'Password field is required',
            'minlength': 'Password must be at least 6 characters long',
            'maxlength': 'Password cannot exceed 30 characters'
        }
    };

    $(document).ready(function () {
        $('#login_post').validate({
            rules: addValidationRules,
            messages: addValidationMessages,
            errorPlacement: function (error, element) {
                $(".error-" + element.attr("name")).html(error);
            },
            submitHandler: function (form) {
                let formData = new FormData(form);
                if (previousRequest) return false;

                previousRequest = $.ajax({
                    url: '{{ url("/login") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (response) {
                        if (response.status === 'success') {
                            window.location.href = response.redirect;
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let response = xhr.responseJSON;
                            $(".error-email").text(response.message);
                        } else {
                            console.log('Error occurred');
                        }
                    },
                    complete: function () {
                        previousRequest = null;
                    }
                });
            }
        });
    });
</script>
</body>
</html>
