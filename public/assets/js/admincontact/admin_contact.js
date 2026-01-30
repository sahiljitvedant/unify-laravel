const submitContact = "/admin/contactus-submit";

// No required validation — everything optional
const validationRules = {};
const validationMessages = {};

function validateForm() {
    $('.error-message').text('');
    return true; // nothing mandatory
}

$('#submitBtn').on('click', function (e) {
    e.preventDefault();

    if (!validateForm()) return;

    let formData = new FormData($('#admin_contact_form')[0]);

    $.ajax({
        url: submitContact,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Saving...',
                text: 'Please wait while we save details.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function () {
            Swal.fire({
                icon: 'success',
                title: 'Saved!',
                text: 'Contact details updated successfully.',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload();
            });
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong!'
            });
        }
    });
});
