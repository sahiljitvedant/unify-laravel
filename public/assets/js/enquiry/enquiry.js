const enquirySubmitUrl = "/enquiry";

// ===============================
// Validation Rules
// ===============================
const validationRules = {
    name: { required: true },
    email: { required: true },
    mobile: { required: true },
    header_id: { required: true },
    message: { required: true }
};

const validationMessages = {
    name: { required: "Name is required" },
    email: { required: "Email is required" },
    mobile: { required: "Mobile number is required" },
    header_id: { required: "Please select category" },
    message: { required: "Message is required" }
};

// ===============================
// Validate Form
// ===============================
function validateEnquiryForm() {
    let isValid = true;
    $('.error-message').text('');

    $('#enquiry_form :input').each(function () {
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
    });

    return isValid;
}

// ===============================
// Submit Form AJAX
// ===============================
$(document).on('submit', '#enquiry_form', function (e) {
    e.preventDefault();

    if (!validateEnquiryForm()) return;

    let formData = new FormData($('#enquiry_form')[0]);

    $.ajax({
        url: enquirySubmitUrl,
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
                title: 'Enquiry Sent!',
                text: 'Request ID: ' + response.request_id
            });

            $('#enquiry_form')[0].reset();
            $('#enquiry_subheader_id').html('<option value="">Select Sub Category</option>');
            $('.error-message').text('');
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
                    title: 'Something went wrong!'
                });
            }
        }
    });
});

// ===============================
// Live Error Remove
// ===============================
$('#enquiry_form :input').on('input change', function () {
    const name = $(this).attr('name');
    $(`.error-message[data-error-for="${name}"]`).text('');
});
