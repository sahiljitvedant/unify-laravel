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
    blog_title: { 
        required: true, 
        minlength: 3, 
        maxlength: 150 
    },
    is_active: { 
        required: true 
    },
    description: { 
        required: true, 
        minlength: 10, 
        maxlength: 1000 
    },
    publish_date: { 
        required: true, 
        date: true 
    },
    blog_image: {
        required: true
    }
 
};

// Validation Messages
const validationMessages = {
    blog_title: { 
        required: "Blog title is required", 
        minlength: "Blog title must be at least 3 characters", 
        maxlength: "Blog title must not exceed 150 characters" 
    },
    is_active: { 
        required: "Please select the status" 
    },
    description: { 
        required: "Blog description is required", 
        minlength: "Description must be at least 10 characters", 
        maxlength: "Description must not exceed 1000 characters" 
    },
    publish_date: { 
        required: "Publish date is required", 
        date: "Please enter a valid date" 
    },
    blog_image: {
        required: "Please upload a blog image"
    }
};


// Validate all form fields
function validateForm() 
{
    let isValid = true;
    let descriptionData = '';
    if (ckEditorInstance) {
        descriptionData = ckEditorInstance.getData().trim();
        $('#description').val(descriptionData); // keep the textarea in sync
    }
    // Clear previous errors
    $('.error-message').text('');

    $('#edit_blogs :input').each(function () {
        const name = $(this).attr('name');
        const value = $(this).val();
        const rules = validationRules[name];
        const messages = validationMessages[name];
        const errorDiv = $(`.error-message[data-error-for="${name}"]`);

        if (!rules) return true; // skip if no rules

        // Required check
        if (rules.required && (!value || value.trim() === '')) {
            errorDiv.text(messages.required);
            isValid = false;
            return;
        }

        // Number check
        if (rules.number && value && isNaN(value)) {
            errorDiv.text(messages.number);
            isValid = false;
            return;
        }

        // Min length check
        if (rules.minlength && value.length < rules.minlength) {
            errorDiv.text(messages.minlength);
            isValid = false;
            return;
        }

        // Max length check
        if (rules.maxlength && value.length > rules.maxlength) {
            errorDiv.text(messages.maxlength);
            isValid = false;
            return;
        }
    });

    if (!$('#blog_image_path').val()) {
        $(`.error-message[data-error-for="blog_image"]`).text(validationMessages.blog_image.required);
        isValid = false;
    }

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
$('#submitBtn').on('click', function (e) 
{
    // alert(1);
    e.preventDefault();
   
    if (!validateForm()) return;

    let formData = new FormData($('#edit_blogs')[0]);

    $.ajax
    ({
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
                text: 'Blog has been updated Sucessfully.',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                // Redirect on OK
                window.location.href = "/list_blogs";
            });
        },
        error: function (xhr) 
        {
            Swal.close(); // close loader
        
            if (xhr.status === 422) 
            {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    $(`.error-message[data-error-for="${key}"]`).text(errors[key][0]);
                }
            } 
            else {
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
$('#edit_blogs :input').on('input change', function () {
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
