let ckEditorInstance;

ClassicEditor
    .create(document.querySelector('#answer'), {
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
    question: { required: true, maxlength: 500 },
    answer: { required: true, maxlength: 5000 },
    image: { required: false },
    youtube_link: { required: false },
    is_active: { 
        required: true 
    },
};

// Validation Messages
const validationMessages = {
    question: { required: "Question is required", maxlength: "Question must not exceed 500 characters" },
    answer: { required: "Answer is required", maxlength: "Answer must not exceed 5000 characters" },
    is_active: { 
        required: "Please select the status" 
    },
};

// Validate form
function validateForm() {
    let isValid = true;
   
    $('.error-message').text('');
    let descriptionData = '';
    if (ckEditorInstance) {
        descriptionData = ckEditorInstance.getData().trim();
        $('#answer').val(descriptionData); // keep the textarea in sync
    }
    $('#faq_edit_form :input').each(function () {
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

        if (rules.maxlength && value && value.length > rules.maxlength) {
            errorDiv.text(messages.maxlength);
            isValid = false;
            return;
        }
    });

    return isValid;
}

// Image preview
$('#image').on('change', function () {
    const file = this.files[0];
    if (file) {
        $('#previewImage').attr('src', URL.createObjectURL(file)).show();
    } else {
        $('#previewImage').hide();
    }
});

// Submit button
$('#submitBtn').on('click', function (e) {
    e.preventDefault();

    if (ckEditorInstance) {
        $('#answer').val(ckEditorInstance.getData().trim());
    }
    
    if (!validateForm()) return;

    let formData = new FormData($('#faq_edit_form')[0]);

    $.ajax({
        url: submitfaq, // Update your backend URL
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        beforeSend: function () {
            Swal.fire({
                title: 'Submitting...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function (response) {
            Swal.fire({ icon: 'success', title: 'FAQ Submitted!', confirmButtonText: 'OK' })
                .then(() => { window.location.href = "/list_faqs"; });
        },
        error: function (xhr) {
            Swal.close();
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    $(`.error-message[data-error-for="${key}"]`).text(errors[key][0]);
                }
            } else {
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Something went wrong!' });
            }
        }
    });
});

// Live error removal
$('#faq_edit_form :input').on('input change', function () {
    const name = $(this).attr('name');
    const value = $(this).val();
    const rules = validationRules[name];
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);

    if (!rules) return true;
    let valid = true;

    if (rules.required && (!value || value.trim() === '')) valid = false;
    if (rules.maxlength && value && value.length > rules.maxlength) valid = false;

    if (valid) errorDiv.text('');
});
// Validate form
function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    $('#faq_edit_form :input').each(function () {
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

        if (rules.maxlength && value && value.length > rules.maxlength) {
            errorDiv.text(messages.maxlength);
            isValid = false;
            return;
        }

        // YouTube URL validation
        if (name === 'youtube_link' && value) {
            const youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)[\w-]{11}(&.*)?$/;
            if (!youtubeRegex.test(value)) {
                errorDiv.text('Please enter a valid YouTube link');
                isValid = false;
                return;
            }
        }
    });

    return isValid;
}
