// ===============================
// Edit Home Banner JS
// ===============================

const validationRules = {
    title: { required: true, maxlength: 255 },
    sub_title: { required: true, maxlength: 255 },
    is_active: { required: true },
};

const validationMessages = {
    title: {
        required: "Title is required",
        maxlength: "Title must not exceed 255 characters",
    },
    sub_title: {
        required: "Sub title is required",
        maxlength: "Sub title must not exceed 255 characters",
    },
    is_active: {
        required: "Please select status",
    },
};

function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    $('#home_banner_edit_form :input').each(function () {
        const name = $(this).attr('name');
        const value = $(this).val();
        const rules = validationRules[name];
        const messages = validationMessages[name];
        const errorDiv = $(`.error-message[data-error-for="${name}"]`);

        if (!rules) return;

        if (rules.required && (!value || value.trim() === '')) {
            errorDiv.text(messages.required);
            isValid = false;
        }

        if (rules.maxlength && value && value.length > rules.maxlength) {
            errorDiv.text(messages.maxlength);
            isValid = false;
        }
    });

    return isValid;
}

// Submit
$('#submitBtn').on('click', function (e) {
    e.preventDefault();

    if (!validateForm()) return;

    let formData = new FormData($('#home_banner_edit_form')[0]);

    $.ajax({
        url: submitBanner,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        beforeSend: function () {
            Swal.fire({ title: 'Updating...', allowOutsideClick: false, didOpen: Swal.showLoading });
        },
        success: function () {
            Swal.fire({ icon: 'success', title: 'Banner Updated!' })
                .then(() => window.location.href = "/home_banner");
        },
        error: function (xhr) {
            Swal.close();
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    $(`.error-message[data-error-for="${key}"]`).text(errors[key][0]);
                }
            } else {
                Swal.fire({ icon: 'error', title: 'Something went wrong' });
            }
        }
    });
});
