// Validation Rules
const validationRules = {
    membership_name: { required: true, minlength: 3, maxlength: 5 },
    description: { required: true },
    duration_in_days: { required: true, number: true },
    price: { required: true, number: true },
    trainer_included: { required: true },
    facilities_included: { required: true },
    is_active: { required: true }
};

// Validation Messages
const validationMessages = {
    membership_name: { 
        required: "Membership name is required", 
        minlength: "Membership name must be at least 3 characters", 
        maxlength: "Membership name must not exceed 5 characters" 
    },
    description: { required: "Description is required" },
    duration_in_days: { 
        required: "Duration is required", 
        number: "Duration must be numeric" 
    },
    price: { 
        required: "Price is required", 
        number: "Price must be numeric" 
    },
    trainer_included: { required: "Please select if trainer included" },
    facilities_included: { required: "Facilities are required" },
    is_active: { required: "Please select status" }
};


// Validate all form fields
function validateForm() 
{
    let isValid = true;

    // Clear previous errors
    $('.error-message').text('');

    $('#gym_member_edit_form :input').each(function () {
        const name = $(this).attr('name');
        const value = $(this).val();
        const rules = validationRules[name];
        const messages = validationMessages[name];
        const errorDiv = $(`.error-message[data-error-for="${name}"]`);

        if (!rules) return true; // skip if no rules

        // Required check
        if (rules.required && (!value || value.trim() === '')) {
            errorDiv.text(messages.required);
            isValid = false;
            return;
        }

        // Number check
        if (rules.number && value && isNaN(value)) {
            errorDiv.text(messages.number);
            isValid = false;
            return;
        }

        // Min length check
        if (rules.minlength && value.length < rules.minlength) {
            errorDiv.text(messages.minlength);
            isValid = false;
            return;
        }

        // Max length check
        if (rules.maxlength && value.length > rules.maxlength) {
            errorDiv.text(messages.maxlength);
            isValid = false;
            return;
        }
    });

    return isValid;
}

// Image preview
$('#profileImage').on('change', function (e) 
{
    const file = e.target.files[0];
    if (file) {
        $('#previewImage').attr('src', URL.createObjectURL(file));
    }
});

// Submit button
$('#submitBtn').on('click', function (e) 
{
    // alert(1);
    e.preventDefault();
   
    if (!validateForm()) return;

    let formData = new FormData($('#gym_member_edit_form')[0]);

    $.ajax
    ({
        url: stepperSubmitUrl,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
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
        success: function (response) {
            // Close loader & show success popup
            Swal.fire({
                icon: 'success',
                title: 'Form Submitted!',
                text: 'Your membership has been submitted successfully.',
                confirmButtonText: 'OK'
            }).then(() => {
                // Redirect on OK
                window.location.href = "/list_membership";
            });
        },
        error: function (xhr) 
        {
            Swal.close(); // close loader
        
            if (xhr.status === 422) 
            {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    $(`.error-message[data-error-for="${key}"]`).text(errors[key][0]);
                }
            } 
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again.'
                });
            }
        }
    });
});

// Live error removal
$('#gym_member_edit_form :input').on('input change', function () {
    const name = $(this).attr('name');
    const value = $(this).val();
    const rules = validationRules[name];
    const messages = validationMessages[name];
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);

    if (!rules) return true;

    let valid = true;

    if (rules.required && (!value || value.trim() === '')) valid = false;
    if (rules.number && value && isNaN(value)) valid = false;
     // Min length
     if (rules.minlength && value && value.length < rules.minlength) valid = false;

     // Max length
     if (rules.maxlength && value && value.length > rules.maxlength) valid = false;

    if (valid) errorDiv.text('');
});
