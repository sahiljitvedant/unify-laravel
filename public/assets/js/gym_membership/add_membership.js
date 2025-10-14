let ckEditorInstance;

ClassicEditor
    .create(document.querySelector('#description'), {
        toolbar: [
            'heading', '|',
            'bold', 'italic', 'underline', 'strikethrough', 'link',
            'bulletedList', 'numberedList', 'blockQuote',
            'undo', 'redo',
            'fontSize' // <-- add font size control
        ],
        fontSize: {
            options: [
                10, 12, 14, 'default', 18, 20, 24, 28
            ]
        },
        removePlugins: [
            'EasyImage',
            'Image',
            'ImageUpload',
            'CKFinder',
            'CKFinderUploadAdapter',
            'MediaEmbed'
        ]
    })
    .then(editor => {
        ckEditorInstance = editor;
        console.log('CKEditor initialized without image upload, with font size');
    })
    .catch(error => console.error('CKEditor init error:', error));


// Validation Rules
const validationRules = {
    membership_name: { required: true, minlength: 2, maxlength: 15 },
    description: { 
        required: true,
        minlength: 50,
        maxlength: 500, 
    },
    duration_in_days: { required: true, number: true },
    price: { required: true, number: true ,  min: 0},
    trainer_included: { required: true },
    facilities_included: { required: true },
    is_active: { required: true }
};

// Validation Messages
const validationMessages = {
    membership_name: { 
        required: "Membership name is required", 
        minlength: "Membership name must be at least 2 characters", 
        maxlength: "Membership name must not exceed 15 characters" 
    },
    description: { required: "Description is required",
    minlength: "Description atleast exceed 50 characters",
    maxlength: "Description cannot exceed 500 characters" },
    duration_in_days: { 
        required: "Duration is required", 
        number: "Duration must be numeric" 
    },
    price: { 
        required: "Price is required", 
        number: "Price must be numeric" ,
        min: "Price cannot be negative"
    },
    trainer_included: { required: "Please select if trainer included" },
    facilities_included: { required: "Facilities are required" },
    is_active: { required: "Please select status" }
};


// Validate form
function validateForm() {
    let isValid = true;

    // ✅ Sync CKEditor data
    if (ckEditorInstance) {
        $('#description').val(ckEditorInstance.getData().trim());
    }

    // Clear old errors
    $('.error-message').text('');

    $('#gym_member_add_form :input').each(function () {
        const name = $(this).attr('name');
        const value = $(this).val();
        const rules = validationRules[name];
        const messages = validationMessages[name];
        const errorDiv = $(`.error-message[data-error-for="${name}"]`);

        if (!rules) return true; // skip if no rules

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

        if (rules.min !== undefined && value && parseFloat(value) < rules.min) {
            errorDiv.text(messages.min);
            isValid = false;
            return;
        }
    });

    return isValid;
}


// Image preview
$('#profileImage').on('change', function (e) 
{
    const file = e.target.files[0];
    if (file) {
        $('#previewImage').attr('src', URL.createObjectURL(file));
    }
});

// Submit button
$('#submitBtn').on('click', function (e) {
    // alert(1);
    e.preventDefault();
   
    if (!validateForm()) return;

    let formData = new FormData($('#gym_member_add_form')[0]);

    $.ajax({
        url: stepperSubmitUrl,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            // Show loader before sending request
            Swal.fire({
                title: 'Submitting...',
                text: 'Please wait while we process your form.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function (response) {
            // Close loader & show success popup
            Swal.fire({
                icon: 'success',
                title: 'Form Submitted!',
                text: 'Your membership has been submitted successfully.',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                // Redirect on OK
                window.location.href = "/list_membership";
            });
        },
        error: function (xhr) {
            Swal.close(); // close loader
        
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    $(`.error-message[data-error-for="${key}"]`).text(errors[key][0]);
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again.'
                });
            }
        }
    });
});

// Live error removal
$('#gym_member_add_form :input').on('input change', function () {
    const name = $(this).attr('name');
    const value = $(this).val();
    const rules = validationRules[name];
    const messages = validationMessages[name];
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);

    if (!rules) return true;

    let valid = true;

    if (rules.required && (!value || value.trim() === '')) valid = false;
    if (rules.number && value && isNaN(value)) valid = false;

    // Min length
    if (rules.minlength && value && value.length < rules.minlength) valid = false;

    // Max length
    if (rules.maxlength && value && value.length > rules.maxlength) valid = false;


    if (valid) errorDiv.text('');
});
