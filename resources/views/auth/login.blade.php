@extends('layouts.front_app')

@section('right-section')
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
@endsection
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
                      // Show loader before sending request
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Please wait...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },

                    success: function (response) {
                        Swal.close(); // Close loader
                        // Redirect to Laravel route
                        window.location.href = '{{ route("list_dashboard") }}';
                    },
                    error: function (xhr) {
                        Swal.close();
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

