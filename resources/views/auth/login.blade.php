@extends("layouts.app")
@section("title","Login")


@section("content")


<div class="container">
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-10">
    <form id="login_post">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
            <span class="text-danger error-email"></span>
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
            <span class="text-danger error-password"></span>
        </div>
       
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>


</div>
</div>


@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>


<script>
    let previousRequest = null;


var addValidationRules = {
    'email': {
        'required': true,
        'email': true,
        'maxlength': 100
    },
    'password': {
        'required': true,
        'minlength': 6,
        'maxlength': 30
    }
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


            if (previousRequest) {
                return false;
            }


            previousRequest = $.ajax({
                url: '{{ route("login_post") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    // alert(1);
                    if (response.status === 'success') {
                        window.location.href = response.redirect;
                    }
                },
                error: function (xhr) {
                    // alert(2);
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
