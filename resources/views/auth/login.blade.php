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

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .left-section {
            background-color: #0B1061;
            color: #fff;
            padding: 50px;
            text-align: center;
        }
        .left-section h1 {
            font-weight: 700;
            font-size: 2.5rem;
        }
        .left-section p {
            font-size: 1.1rem;
            margin-top: 15px;
            opacity: 0.9;
        }
        .login-box {
            background: #fff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 420px;
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
    </style>
</head>
<body>
<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Left section -->
        <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center left-section">
            <i class="fas fa-users fa-3x mb-4"></i>
            <h1>Welcome Back!</h1>
            <p>Login to access your dashboard, manage memberships, and explore new features.</p>
        </div>

        <!-- Right section -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="login-box">
                <h3 class="text-center mb-4">Login</h3>
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
                
                    <button type="submit" class="btn btn-primary w-100">Submit</button>

                    <div class="register-link">
                        <p>New user? <a href="{{ url('/register') }}">Register here</a></p>
                    </div>
                </form>
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
