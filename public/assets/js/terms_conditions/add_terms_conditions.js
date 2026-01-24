let ckEditorInstance;

/* ===============================
   CKEDITOR INIT
=============================== */
ClassicEditor
    .create(document.querySelector('#terms_description'), {
        toolbar: [
            'heading', '|',
            'bold', 'italic', 'underline', 'strikethrough', 'link',
            'bulletedList', 'numberedList', 'blockQuote',
            'undo', 'redo',
            'fontSize'
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
        console.log('CKEditor initialized for Terms & Conditions');
    })
    .catch(error => console.error('CKEditor init error:', error));


/* ===============================
   VALIDATION RULES
=============================== */
const validationRules = {
    terms_description: {
        required: true,
        minlength: 10,
        maxlength: 5000
    }
};

const validationMessages = {
    terms_description: {
        required: "Terms & Conditions description is required",
        minlength: "Description must be at least 10 characters",
        maxlength: "Description must not exceed 5000 characters"
    }
};


/* ===============================
   VALIDATE FORM
=============================== */
function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    if (ckEditorInstance) {
        const data = ckEditorInstance.getData().trim();
        $('#terms_description').val(data);
    }

    $('#add_terms_form :input').each(function () {
        const name = $(this).attr('name');
        const value = $(this).val();
        const rules = validationRules[name];
        const messages = validationMessages[name];
        const errorDiv = $(`.error-message[data-error-for="${name}"]`);

        if (!rules) return;

        if (rules.required && (!value || value.trim() === '')) {
            errorDiv.text(messages.required);
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
    });

    return isValid;
}


/* ===============================
   SUBMIT FORM
=============================== */
$('#submitBtn').on('click', function (e) {
    e.preventDefault();

    if (ckEditorInstance) {
        $('#terms_description').val(ckEditorInstance.getData().trim());
    }

    if (!validateForm()) return;

    let formData = new FormData($('#add_terms_form')[0]);

    $.ajax({
        url: submitTerms,
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
                text: 'Please wait while we save Terms & Conditions.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function () {
            Swal.fire({
                icon: 'success',
                title: 'Saved!',
                text: 'Terms & Conditions updated successfully.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "/add_terms_conditions";
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
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again.'
                });
            }
        }
    });
});


/* ===============================
   LIVE ERROR REMOVAL
=============================== */
$('#add_terms_form :input').on('input change', function () {
    const name = $(this).attr('name');
    const value = $(this).val();
    const rules = validationRules[name];
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);

    if (!rules) return;

    let valid = true;

    if (rules.required && (!value || value.trim() === '')) valid = false;
    if (rules.minlength && value.length < rules.minlength) valid = false;
    if (rules.maxlength && value.length > rules.maxlength) valid = false;

    if (valid) errorDiv.text('');
});
