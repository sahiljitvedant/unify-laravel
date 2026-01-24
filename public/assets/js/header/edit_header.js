// ===============================
// Edit Header JS
// ===============================

const validationRules = {
    title: { required: true, maxlength: 255 },
    sequence_no: { required: true },
    status: { required: true },
};

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

function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    $('#header_edit_form :input').each(function () {
        const name = $(this).attr('name');
        const value = $(this).val();
        const rules = validationRules[name];
        const messages = validationMessages[name];
        const errorDiv = $(`.error-message[data-error-for="${name}"]`);

        if (!rules) return;

        if (rules.required && (!value || value.toString().trim() === '')) {
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

// ===============================
// Submit
// ===============================
$('#submitBtn').on('click', function (e) {
    e.preventDefault();

    if (!validateForm()) return;

    let formData = new FormData($('#header_edit_form')[0]);

    $.ajax({
        url: submitHeaderPage,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
        },
        beforeSend: function () {
            Swal.fire({ 
                title: 'Updating...', 
                allowOutsideClick: false, 
                didOpen: Swal.showLoading 
            });
        },
        success: function () {
            Swal.fire({ 
                icon: 'success', 
                title: 'Header Updated!' 
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
                    title: 'Something went wrong' 
                });
            }
        }
    });
});
