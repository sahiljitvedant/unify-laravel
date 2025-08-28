
@extends('layouts.front_app')

@section("title","Register")


@section('right-section')
    <div class="d-flex flex-column align-items-center w-100 px-4">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" 
        style="height: 65px; width:200px; object-fit:cover; border-radius:10px; border:1px solid #0B1061" class="mt-2">

        <div class="login-box mt-4">
            <h5 class="text-center mb-4">Register</h5>
            <form id="registration_add">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                    <span class="text-danger error-name small"></span>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email">
                    <span class="text-danger error-email small"></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <span class="text-danger error-password small"></span>
                </div>
            
                <button type="submit" class="btn login_btn w-100">Submit</button>
            </form> 
        </div>
    </div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>


<script>
    let previousRequest = null;
    var addValidationRules =
    {
        'name':
        {
            'required': true,
            'minlength': 3,
            'maxlength': 50
        },
        'email':
        {
            'required': true,
            'email': true,
            'maxlength': 100
        },
        'password':
        {
            'required': true,
            'minlength': 6,
            'maxlength': 30
        }
    };
    var addValidationMessages =
    {
        'name':
        {
            'required': 'Name field is required',
            'minlength': 'Name must be at least 3 characters long',
            'maxlength': 'Name cannot exceed 50 characters',
            'pattern': 'Name can only contain letters and spaces'
        },
        'email':
        {
            'required': 'Email field is required',
            'email': 'Please enter a valid email address',
            'maxlength': 'Email cannot exceed 100 characters'
        },
        'password':
        {
            'required': 'Password field is required',
            'minlength': 'Password must be at least 6 characters long',
            'maxlength': 'Password cannot exceed 30 characters',
            'pattern': 'Password must contain at least one uppercase letter, one number, and one special character (@$!%*?&)'
        }
    };


    $(document).ready(function ()
    {
        $('#registration_add').validate
        ({
           
            rules:  addValidationRules,
           
            messages:  addValidationMessages,


            errorPlacement: function (error, element)
            {
                $(".error-" + element.attr("name")).html(error);
            },


            submitHandler: function (form)
            {
                let formData = new FormData(form);
               
                if ( (previousRequest) )
                {
                    return false;
                };


                previousRequest =$.ajax
                ({
                    url: '{{ route("register_post") }}',  
                    type: 'POST',
                    data: formData,
                    //   beforeSend: function (xhr)
                    //   {
                    //     xhr.setRequestHeader("Authorization", "Bearer " + ACCESS_TOKEN);
                    //   },
                    processData: false,
                    contentType: false,
                    headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response)
                    {
                        console.log('sucess occured');
                        window.location.href = '{{ route("login_get") }}';
                    },
                    error: function (xhr, status, error)
                    {
                        console.log('error occured');
                    },
                    complete: function ()
                    {
                        previousRequest = null;
                    }
                });
            }
        });
    });
</script>