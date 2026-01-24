// ===============================
// Home Banner Add JS
// ===============================

// Validation Rules
const validationRules = {
    title: { required: true, maxlength: 255 },
    sub_title: { required: true, maxlength: 255 },
    faq_image: { required: true },
    is_active: { required: true },
};

// Validation Messages
const validationMessages = {
    title: {
        required: "Title is required",
        maxlength: "Title must not exceed 255 characters",
    },
    sub_title: {
        required: "Sub title is required",
        maxlength: "Sub title must not exceed 255 characters",
    },
    faq_image: {
        required: "Banner image is required",
    },
    is_active: {
        required: "Please select the status",
    },
};

// ===============================
// Validate Form
// ===============================
function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    $('#faq_add_form :input').each(function () {
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

    let formData = new FormData($('#faq_add_form')[0]);

    $.ajax({
        url: submitBanner, // backend route
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
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Home Banner Added!',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "/home_banner"; // update route if needed
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
$('#faq_add_form :input').on('input change', function () {
    const name = $(this).attr('name');
    const value = $(this).val();
    const rules = validationRules[name];
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);

    if (!rules) return;

    let valid = true;
    if (rules.required && (!value || value.trim() === '')) valid = false;
    if (rules.maxlength && value && value.length > rules.maxlength) valid = false;

    if (valid) errorDiv.text('');
});
