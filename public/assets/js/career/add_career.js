// ===============================
// Career Add JS
// ===============================

// Validation Rules
const validationRules = {
    designation: { required: true, maxlength: 255 },
    experience: { required: true, maxlength: 255 },
    years_of_experience: { required: true },
    location: { required: true, maxlength: 255 },
    work_type: { required: true },
    job_description: { required: true },
    status: { required: true },
};

// Validation Messages
const validationMessages = {
    designation: {
        required: "Designation is required",
        maxlength: "Designation must not exceed 255 characters",
    },
    experience: {
        required: "Experience is required",
    },
    years_of_experience: {
        required: "Years of experience is required",
    },
    location: {
        required: "Location is required",
    },
    work_type: {
        required: "Please select work type",
    },
    job_description: {
        required: "Job description is required",
    },
    status: {
        required: "Please select status",
    },
};

// ===============================
// Validate Form
// ===============================
function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    $('#career_add_form :input').each(function () {
        const name = $(this).attr('name');
        const value = $(this).val();
        const rules = validationRules[name];
        const messages = validationMessages[name];
        const errorDiv = $(`.error-message[data-error-for="${name}"]`);

        if (!rules) return true;

        if (rules.required && (!value || value.toString().trim() === '')) {
            errorDiv.text(messages.required);
            isValid = false;
            return;
        }

        if (rules.maxlength && value && value.length > rules.maxlength) {
            errorDiv.text(messages.maxlength);
            isValid = false;
            return;
        }
    });

    return isValid;
}

// ===============================
// Submit Form
// ===============================
$('#submitBtn').on('click', function (e) {
    e.preventDefault();

    if (!validateForm()) return;

    let formData = new FormData($('#career_add_form')[0]);

    $.ajax({
        url: submitCareerUrl,
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
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function () {
            Swal.fire({
                icon: 'success',
                title: 'Career Added!',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "/list_careers";
            });
        },
        error: function (xhr) {
            Swal.close();

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    $(`.error-message[data-error-for="${key}"]`)
                        .text(errors[key][0]);
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                });
            }
        }
    });
});

// ===============================
// Live Error Removal
// ===============================
$('#career_add_form :input').on('input change', function () {
    const name = $(this).attr('name');
    const value = $(this).val();
    const rules = validationRules[name];
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);

    if (!rules) return;

    let valid = true;
    if (rules.required && (!value || value.toString().trim() === '')) valid = false;
    if (rules.maxlength && value && value.length > rules.maxlength) valid = false;

    if (valid) errorDiv.text('');
});
