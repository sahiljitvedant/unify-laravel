let ckEditorInstance;

ClassicEditor
    .create(document.querySelector('#description'), {
        toolbar: [
            'heading', '|',
            'bold', 'italic', 'underline', 'strikethrough', 'link',
            'bulletedList', 'numberedList', 'blockQuote',
            'undo', 'redo'
        ],
        removePlugins: [
            'EasyImage',            // cloud image plugin
            'Image',                // disables image button
            'ImageUpload',          // disables drag/drop upload
            'CKFinder',             // CKFinder integration
            'CKFinderUploadAdapter',// backend upload adapter
            'MediaEmbed'            // optional, disables media embed
        ]
    })
    .then(editor => {
        ckEditorInstance = editor;
        console.log('CKEditor initialized without image upload');
    })
    .catch(error => console.error('CKEditor init error:', error));

// Validation rules
const validationRules = {
    membership_name: { required: true, minlength: 2, maxlength: 15 },
    description: { required: true, minlength: 50, maxlength: 500 },
    duration_in_days: { required: true, number: true },
    price: { required: true, number: true, min: 0 },
    trainer_included: { required: true },
    facilities_included: { required: true },
    is_active: { required: true }
};

const validationMessages = {
    membership_name: {
        required: "Membership name is required",
        minlength: "Membership name must be at least 2 characters",
        maxlength: "Membership name must not exceed 15 characters"
    },
    description: {
        required: "Description is required",
        minlength: "Description must exceed 50 characters",
        maxlength: "Description cannot exceed 500 characters"
    },
    duration_in_days: {
        required: "Duration is required",
        number: "Duration must be numeric"
    },
    price: {
        required: "Price is required",
        number: "Price must be numeric",
        min: "Price cannot be negative"
    },
    trainer_included: { required: "Please select if trainer is included" },
    facilities_included: { required: "Facilities are required" },
    is_active: { required: "Please select status" }
};

// Validation function
function validateForm() {
    let isValid = true;

    if (ckEditorInstance) {
        $('#description').val(ckEditorInstance.getData().trim());
    }

    $('.error-message').text('');

    $('#gym_member_edit_form :input').each(function () {
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

        if (rules.number && value && isNaN(value)) {
            errorDiv.text(messages.number);
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

        if (rules.min !== undefined && parseFloat(value) < rules.min) {
            errorDiv.text(messages.min);
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

    let formData = new FormData($('#gym_member_edit_form')[0]);

    $.ajax({
        url: stepperSubmitUrl,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        beforeSend: function () {
            Swal.fire({
                title: 'Updating...',
                text: 'Please wait while we update your membership.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function () {
            Swal.fire({
                icon: 'success',
                title: 'Membership Updated!',
                text: 'Changes saved successfully.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "/list_membership";
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
$('#gym_member_edit_form :input').on('input change', function () {
    const name = $(this).attr('name');
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);
    if (errorDiv.text()) errorDiv.text('');
});
