// ===============================
// Edit Customer JS
// ===============================

const validationRules = {
    customer_name: { required: true, maxlength: 255 },
    is_active: { required: true },
};

const validationMessages = {
    customer_name: {
        required: "Customer name is required",
        maxlength: "Customer name must not exceed 255 characters",
    },
    is_active: {
        required: "Please select status",
    },
};

function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    $('#customer_edit_form :input').each(function () {
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
$('#submitCustomerBtn').on('click', function (e) {
    e.preventDefault();

    if (!validateForm()) return;

    let formData = new FormData($('#customer_edit_form')[0]);

    $.ajax({
        url: submitCustomerUpdateUrl,
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
                title: 'Customer Updated!' 
            }).then(() => {
                window.location.href = "/list_customers";
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
