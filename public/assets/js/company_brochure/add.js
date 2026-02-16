// Validation Rules
const validationRules = {
    brochure_file: {
        required: true
    },
};

// Validation Messages
const validationMessages = {
    brochure_file: {
        required: "Company brochure PDF is required"
    },
};


// Validate
function validateForm() 
{
    let isValid = true;

    $('.error-message').text('');

    const fileInput = $('#brochure_file')[0];
    const errorDiv = $('[data-error-for="brochure_file"]');

    if (!fileInput.files.length) {
        errorDiv.text(validationMessages.brochure_file.required);
        isValid = false;
    }

    return isValid;
}


// Submit
$('#submitBtn').on('click', function (e) {
    e.preventDefault();

    if (!validateForm()) return;

    let formData = new FormData($('#add_brochure_form')[0]);

    $.ajax({
        url: submitPolicy,
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
                text: 'Uploading brochure, please wait.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: response.message,
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = "/add_company_brochure";
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
                    text: 'Something went wrong!'
                });
            }
        }
    });
});


// Live error remove
$('#brochure_file').on('change', function () {
    if (this.files.length) {
        $('[data-error-for="brochure_file"]').text('');
    }
});
