// ===============================
// CKEDITOR INIT
// ===============================
let jobEditor;

ClassicEditor
    .create(document.querySelector('#job_description'), {
        toolbar: [
            'heading', '|',
            'bold', 'italic', 'underline', 'strikethrough', 'link',
            'bulletedList', 'numberedList', 'blockQuote',
            'undo', 'redo', 'fontSize'
        ],
        fontSize: {
            options: [10, 12, 14, 'default', 18, 20, 24, 28]
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
        jobEditor = editor;
    })
    .catch(error => console.error('CKEditor error:', error));


// ===============================
// VALIDATION RULES
// ===============================
const validationRules = {
    designation: { required: true, maxlength: 255 },
    years_of_experience: { required: true },
    vacancies: { required: true },
    application_start_date: { required: true },
    application_end_date: { required: true },
    location: { required: true, maxlength: 255 },
    work_type: { required: true },
    job_description: { required: true },
    status: { required: true },
};

const validationMessages = {
    designation: { required: "Designation is required" },
    years_of_experience: { required: "Years of experience is required" },
    vacancies: { required: "Number of vacancies is required" },
    application_start_date: { required: "Start date is required" },
    application_end_date: { required: "End date is required" },
    location: { required: "Location is required" },
    work_type: { required: "Select work type" },
    job_description: { required: "Job description is required" },
    status: { required: "Select status" },
};


// ===============================
// VALIDATE FORM
// ===============================
function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    // ✅ Handle CKEditor content
    let descriptionText = '';
    if (jobEditor) {
        descriptionText = jobEditor.getData().replace(/<[^>]*>/g, '').trim();
        $('#job_description').val(jobEditor.getData()); // sync editor to textarea
    }

    if (!descriptionText) {
        $('[data-error-for="job_description"]').text(validationMessages.job_description.required);
        isValid = false;
    }

    $('#career_edit_form :input').each(function () {
        const name = $(this).attr('name');
        const value = $(this).val();
        const rules = validationRules[name];
        const messages = validationMessages[name];
        const errorDiv = $(`.error-message[data-error-for="${name}"]`);

        if (!rules || name === 'job_description') return;

        if (rules.required && (!value || value.trim() === '')) {
            errorDiv.text(messages.required);
            isValid = false;
        }
    });

    // Date validation
    let start = $('input[name="application_start_date"]').val();
    let end = $('input[name="application_end_date"]').val();

    if (start && end && end < start) {
        $('[data-error-for="application_end_date"]').text("End date must be after start date");
        isValid = false;
    }

    return isValid;
}


// ===============================
// SUBMIT FORM
// ===============================
$('#submitBtn').on('click', function (e) {
    e.preventDefault();

    if (!validateForm()) return;

    let formData = new FormData($('#career_edit_form')[0]);

    $.ajax({
        url: submitCareerPage,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },

        beforeSend: () => Swal.fire({
            title: 'Updating...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        }),

        success: () => Swal.fire({
            icon: 'success',
            title: 'Career Updated!'
        }).then(() => window.location.href = "/list_careers"),

        error: function (xhr) {
            Swal.close();

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    $(`.error-message[data-error-for="${key}"]`).text(errors[key][0]);
                }
            } else {
                Swal.fire({ icon: 'error', title: 'Something went wrong' });
            }
        }
    });
});


// ===============================
// LIVE ERROR REMOVAL
// ===============================
$('#career_edit_form :input').on('input change', function () {
    const name = $(this).attr('name');
    const value = $(this).val();
    const rules = validationRules[name];
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);

    if (!rules) return;

    let valid = true;
    if (rules.required && (!value || value.trim() === '')) valid = false;
    if (rules.maxlength && value && value.length > rules.maxlength) valid = false;

    if (valid) errorDiv.text('');
});
