$(document).ready(function() {

    const validationRulesPassword = {
        password: { required: true, minLength: 6, maxLength: 10 },
        password_confirmation: { required: true, minLength: 6, maxLength: 10 },
    };
    
    const validationMessagesPassword = {
        password: { 
            required: "Please enter new password", 
            minLength: "Password must be at least 6 characters",
            maxLength: "Password cannot exceed 10 characters"
        },
        password_confirmation: { 
            required: "Please confirm new password", 
            minLength: "Password must be at least 6 characters",
            maxLength: "Password cannot exceed 10 characters"
        },
    };
    
    function validatePasswordForm() {
        let isValid = true;
        $('.error-message').text('');
    
        $('#memebrPasswordForm :input').each(function () {
            const name = $(this).attr('name');
            const value = $(this).val();
            const rules = validationRulesPassword[name];
            const messages = validationMessagesPassword[name];
            const errorDiv = $(`.error-message[data-error-for="${name}"]`);
    
            if (!rules) return true;
    
            if (rules.required && (!value || value.trim() === '')) {
                if (errorDiv.length) {
                    errorDiv.text(messages.required);
                } else {
                    $(this).after(`<div class="text-danger error-message" data-error-for="${name}">${messages.required}</div>`);
                }
                isValid = false;
                return;
            }
    
            if (rules.minLength && value && value.trim().length < rules.minLength) {
                if (errorDiv.length) {
                    errorDiv.text(messages.minLength);
                } else {
                    $(this).after(`<div class="text-danger error-message" data-error-for="${name}">${messages.minLength}</div>`);
                }
                isValid = false;
                return;
            }
    
            // ✅ ADD THIS BLOCK FOR MAX LENGTH
            if (rules.maxLength && value && value.trim().length > rules.maxLength) {
                if (errorDiv.length) {
                    errorDiv.text(messages.maxLength);
                } else {
                    $(this).after(`<div class="text-danger error-message" data-error-for="${name}">${messages.maxLength}</div>`);
                }
                isValid = false;
                return;
            }
        });
    
        // Password match check
        const password = $('#password').val().trim();
        const confirmPassword = $('#password_confirmation').val().trim();
    
        if (password && confirmPassword && password !== confirmPassword) {
            const errorDiv = $(`.error-message[data-error-for="password_confirmation"]`);
            if (errorDiv.length) {
                errorDiv.text("Password and confirm Password are not same yet");
            } else {
                $('#password_confirmation').after('<div class="text-danger error-message" data-error-for="password_confirmation">Passwords do not match</div>');
            }
            isValid = false;
        }
    
        return isValid;
    }
    

    // Handle submit
    $('#submitPasswordBtn').off('click').on('click', function(e) {
        e.preventDefault();

        if (!validatePasswordForm()) return;

        let formData = new FormData($('#memebrPasswordForm')[0]);

        $.ajax({
            url: stepperupdatePasswordUrl,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },beforeSend: function () {
                // Show loader before sending request
                Swal.fire({
                    title: 'Submitting...',
                    text: 'Please wait while we process your form.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) 
            {
                Swal.fire({
                    icon: 'success',
                    title: 'Password Submitted!',
                    text: 'Your Password changed successfully.',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                }).then(() => {
                    // Redirect on OK
                    window.location.href = "/list_member";
                });
                // $('#memebrPasswordForm')[0].reset();
            },
            error: function(xhr) 
            {
                console.log(xhr.status);
                console.log(xhr.responseText);
                Swal.fire("Error", "An error occurred. Check console for details.", "error");
            }
        });
    });

});
