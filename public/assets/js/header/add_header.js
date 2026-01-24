// ===============================
// Header Add JS
// ===============================

// Validation Rules
const validationRules = {
    title: { required: true, maxlength: 255 },
    sequence_no: { required: true },
    status: { required: true },
};

// Validation Messages
const validationMessages = {
    title: {
        required: "Header title is required",
        maxlength: "Title must not exceed 255 characters",
    },
    sequence_no: {
        required: "Sequence number is required",
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

    $('#header_add_form :input').each(function () {
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

    let formData = new FormData($('#header_add_form')[0]);

    $.ajax({
        url: submitHeaderUrl, // backend route
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
                title: 'Header Added!',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "/list_headers";
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
$('#header_add_form :input').on('input change', function () {
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
