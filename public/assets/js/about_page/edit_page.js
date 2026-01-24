let ckEditorInstance;

// ===============================
// CKEditor
// ===============================
ClassicEditor
    .create(document.querySelector('#description'), {
        toolbar: [
            'heading', '|',
            'bold', 'italic', 'underline',
            'bulletedList', 'numberedList',
            'undo', 'redo', 'fontSize'
        ],
        fontSize: { options: [10, 12, 14, 'default', 18, 20, 24] },
        removePlugins: [
            'EasyImage', 'Image', 'ImageUpload',
            'CKFinder', 'CKFinderUploadAdapter', 'MediaEmbed'
        ]
    })
    .then(editor => ckEditorInstance = editor);

// ===============================
// Validation
// ===============================
function validateForm() {
    let valid = true;
    $('.error-message').text('');

    const descText = ckEditorInstance.getData()
        .replace(/<[^>]*>/g, '')
        .replace(/&nbsp;/g, '')
        .trim();

    if (!descText) {
        $('[data-error-for="description"]').text('Description is required');
        valid = false;
    }

    $('#about_edit_form :input').each(function () {
        const name = $(this).attr('name');
        if (name === 'description') return;

        const value = $(this).val();
        if (!value && ['title','slug','header_id','is_active'].includes(name)) {
            $(`[data-error-for="${name}"]`).text('This field is required');
            valid = false;
        }
    });

    return valid;
}

// ===============================
// Submit
// ===============================
$('#submitBtn').on('click', function (e) {
    e.preventDefault();

    if (!validateForm()) return;

    let formData = new FormData($('#about_edit_form')[0]);
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
            title: 'Updating...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        }),
        success: () => {
            Swal.fire('Success', 'About Page Updated!', 'success')
                .then(() => window.location.href = "/about_page");
        },
        error: () => Swal.fire('Error', 'Something went wrong', 'error')
    });
});
