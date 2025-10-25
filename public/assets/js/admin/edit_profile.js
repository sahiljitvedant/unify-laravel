// Validation rules
const validationRules = {
    name: { required: true, minlength: 2, maxlength: 50 },
    email: { required: true, email: true }
};

const validationMessages = {
    name: {
        required: "Name is required",
        minlength: "Name must be at least 2 characters",
        maxlength: "Name must not exceed 50 characters"
    },
    email: {
        required: "Email is required",
        email: "Please enter a valid email address"
    }
};

// Validation function
function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    $('#admin_profile_edit_form :input').each(function () {
        const name = $(this).attr('name');
        const value = $(this).val()?.trim();
        const rules = validationRules[name];
        const messages = validationMessages[name];
        const errorDiv = $(`.error-message[data-error-for="${name}"]`);

        if (!rules) return true;

        if (rules.required && (!value || value === '')) {
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

        if (rules.email && value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
            errorDiv.text(messages.email);
            isValid = false;
            return;
        }
    });

    return isValid;
}

// Submit form via AJAX
$('#submitBtn').on('click', function (e) {
    e.preventDefault();

    if (!validateForm()) return;

    let formData = new FormData($('#admin_profile_edit_form')[0]);

    $.ajax({
        url: updateProfileUrl,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        beforeSend: function () {
            Swal.fire({
                title: 'Updating...',
                text: 'Please wait while we update your profile.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function () {
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated!',
                text: 'Your changes have been saved successfully.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "/dashboard";
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
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.'
                });
            }
        }
    });
});

// Live error clearing
$('#admin_profile_edit_form :input').on('input change', function () {
    const name = $(this).attr('name');
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);
    if (errorDiv.text()) errorDiv.text('');
});
