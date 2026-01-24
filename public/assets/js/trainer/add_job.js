// Validation Rules
const validationRules = {
    job_title: { required: true, minlength: 2, maxlength: 50 },
    experience_needed: { required: true, minlength: 1, maxlength: 20 },
    city: { required: true, minlength: 2, maxlength: 30 },
};

// Validation Messages
const validationMessages = {
    job_title: {
        required: "Job Title is required",
        minlength: "Job Title must be at least 2 characters",
        maxlength: "Job Title must not exceed 50 characters"
    },
    experience_needed: {
        required: "Experience is required",
        minlength: "Experience must be at least 1 character",
        maxlength: "Experience must not exceed 20 characters"
    },
    city: {
        required: "City is required",
        minlength: "City must be at least 2 characters",
        maxlength: "City must not exceed 30 characters"
    }
};

// Validate all form fields
function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    $('#job_apply_form :input').each(function () {
        const name = $(this).attr('name');
        const value = $(this).val();
        const rules = validationRules[name];
        const messages = validationMessages[name];
        const errorDiv = $(`.error-message[data-error-for="${name}"]`);

        if (!rules) return true;

        if (rules.required && (!value || value.trim() === '')) {
            errorDiv.text(messages.required);
            isValid = false;
            return;
        }

        if (rules.minlength && value.length < rules.minlength) {
            errorDiv.text(messages.minlength);
            isValid = false;
            return;
        }

        if (rules.maxlength && value.length > rules.maxlength) {
            errorDiv.text(messages.maxlength);
            isValid = false;
            return;
        }
    });

    return isValid;
}

// Submit button click
$('#submitBtn').on('click', function (e) {
    e.preventDefault();

    if (!validateForm()) return;

    let formData = new FormData($('#job_apply_form')[0]);

    $.ajax({
        url: submitJobUrl,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Submitting...',
                text: 'Please wait while we process your application.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Your job application has been submitted successfully.',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = jobIndexUrl;
            });
        },
        error: function (xhr) {
            Swal.close();

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
$('#job_apply_form :input').on('input change', function () {
    const name = $(this).attr('name');
    const value = $(this).val();
    const rules = validationRules[name];
    const messages = validationMessages[name];
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);

    if (!rules) return true;

    let valid = true;
    if (rules.required && (!value || value.trim() === '')) valid = false;
    if (rules.minlength && value.length < rules.minlength) valid = false;
    if (rules.maxlength && value.length > rules.maxlength) valid = false;

    if (valid) errorDiv.text('');
});
