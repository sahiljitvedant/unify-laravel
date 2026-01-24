let ckEditorInstance;

// ===============================
// CKEditor Init
// ===============================
ClassicEditor
    .create(document.querySelector('#description'), {
        toolbar: [
            'heading', '|',
            'bold', 'italic', 'underline', 'strikethrough',
            'bulletedList', 'numberedList', 'blockQuote',
            'undo', 'redo',
            'fontSize'
        ],
        fontSize: {
            options: [10, 12, 14, 'default', 18, 20, 24, 28]
        },
        removePlugins: [
            'EasyImage', 'Image', 'ImageUpload',
            'CKFinder', 'CKFinderUploadAdapter', 'MediaEmbed'
        ]
    })
    .then(editor => {
        ckEditorInstance = editor;
    });

// ===============================
// Validation Rules
// ===============================
const validationRules = {
    title: { required: true },
    slug: { required: true },
    header_id: { required: true }, // MANDATORY
    description: { required: true },
    page_image: { required: true }, // IMAGE MANDATORY
    is_active: { required: true },
};

const validationMessages = {
    title: { required: "Title is required" },
    slug: { required: "Slug is required" },
    header_id: { required: "Please select a header" },
    description: { required: "Description is required" },
    page_image: { required: "Page image is required" },
    is_active: { required: "Please select status" },
};

// ===============================
// Validate Form
// ===============================
function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    // ===============================
    // CKEditor validation
    // ===============================
    const descriptionText = ckEditorInstance.getData()
        .replace(/<[^>]*>/g, '')
        .replace(/&nbsp;/g, '')
        .trim();

    if (!descriptionText) {
        $('[data-error-for="description"]').text("Description is required");
        isValid = false;
    }

    // ===============================
    // Page Image validation (FIX)
    // ===============================
    const pageImage = $('#page_image').val();
    if (!pageImage) {
        $('[data-error-for="page_image"]').text("Page image is required");
        isValid = false;
    }

    // ===============================
    // Other fields validation
    // ===============================
    $('#about_add_form :input').each(function () {
        const name = $(this).attr('name');

        // 🚫 Skip fields handled manually
        if (name === 'description' || name === 'page_image') return;

        const value = $(this).val();
        const rules = validationRules[name];
        const msg = validationMessages[name];
        const errorDiv = $(`[data-error-for="${name}"]`);

        if (!rules) return;

        if (rules.required && (!value || value.trim() === '')) {
            errorDiv.text(msg.required);
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

    let formData = new FormData($('#about_add_form')[0]);
    formData.set('description', ckEditorInstance.getData());

    $.ajax({
        url: submitAboutPage,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: () => Swal.fire({
            title: 'Submitting...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        }),
        success: () => {
            Swal.fire('Success', 'About Page Added!', 'success')
                .then(() => window.location.href = "/about_page");
        },
        error: () => {
            Swal.fire('Error', 'Something went wrong', 'error');
        }
    });
});
