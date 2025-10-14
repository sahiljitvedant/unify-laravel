// Validation Rules
const validationRules = {
    trainer_name: { required: true, minlength: 2, maxlength: 15 },
    joining_date: { required: true, date: true },
    is_active: { required: true },
    mobile_number:{ required: true, minlength: 10, maxlength: 10 },
};

// Validation Messages
const validationMessages = {
    trainer_name: { 
        required: "Trainer name is required", 
        minlength: "Trainer name must be at least 2 characters", 
        maxlength: "Trainer name must not exceed 15 characters" 
    },

    joining_date: { 
        required: "Joining date is required", 
        date: "date must be numeric" 
    },
    
    is_active: { required: "Please select status" },

    mobile_number:
    {
        required: "Mobile Number name is required", 
        minlength: "Mobile Number must be at least 10 characters", 
        maxlength: "Mobile Number must not exceed 10 characters" 
    }
};


// Validate all form fields
function validateForm() 
{
    let isValid = true;

    // Clear previous errors
    $('.error-message').text('');

    $('#add_trainer_form :input').each(function () {
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
    const joiningDate = $('#joining_date').val();
    const leavingDate = $('#expiry_date').val();

    if (joiningDate && leavingDate && new Date(leavingDate) < new Date(joiningDate)) {
        $(`.error-message[data-error-for="expiry_date"]`).text('Leaving date cannot be earlier than joining date');
        isValid = false;
    }

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
$('#submitBtn').on('click', function (e) {
    // alert(1);
    e.preventDefault();
   
    if (!validateForm()) return;

    let formData = new FormData($('#add_trainer_form')[0]);

    $.ajax({
        url: submitTrainer,
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
                text: 'Trainer has been added Sucessfully',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = "/list_trainer";
            });
        },
        error: function (xhr) {
            Swal.close(); // close loader
        
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    $(`.error-message[data-error-for="${key}"]`).text(errors[key][0]);
                }
            } else {
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
$('#add_trainer_form :input').on('input change', function () {
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
