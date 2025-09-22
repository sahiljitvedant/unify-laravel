
// Validation Rules
const validationRules = {
    blog_title: { 
        required: true, 
        minlength: 3, 
        maxlength: 150 
    },
    is_active: { 
        required: true 
    },
    description: { 
        required: true, 
        minlength: 10, 
        maxlength: 1000 
    },
    publish_date: { 
        required: true, 
        date: true 
    },  
    blog_image: {
        required: true
    }

};

// Validation Messages
const validationMessages = {
    blog_title: { 
        required: "Blog title is required", 
        minlength: "Blog title must be at least 3 characters", 
        maxlength: "Blog title must not exceed 150 characters" 
    },
    is_active: { 
        required: "Please select the status" 
    },
    description: { 
        required: "Blog description is required", 
        minlength: "Description must be at least 10 characters", 
        maxlength: "Description must not exceed 1000 characters" 
    },
    publish_date: { 
        required: "Publish date is required", 
        date: "Please enter a valid date" 
    },
    blog_image: {
        required: "Please upload a blog image"
    }
};



// Validate all form fields
function validateForm() 
{
    let isValid = true;

    // Clear previous errors
    $('.error-message').text('');

    $('#add_blogs :input').each(function () {
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
    // Special check for blog image
    if (!$('#blog_image_path').val()) {
            $(`.error-message[data-error-for="blog_image"]`).text(validationMessages.blog_image.required);
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

    let formData = new FormData($('#add_blogs')[0]);

    $.ajax({
        url: submitblog,
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
                text: 'Your Blog has been created successfully.',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = "/list_blogs";
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
$('#add_blogs :input').on('input change', function () {
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
