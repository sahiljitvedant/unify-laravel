// ===============================
// Edit Career JS
// ===============================

const validationRules = {
    designation: { required: true, maxlength: 255 },
    experience: { required: true, maxlength: 255 },
    years_of_experience: { required: true },
    location: { required: true, maxlength: 255 },
    work_type: { required: true },
    job_description: { required: true },
    status: { required: true },
};

const validationMessages = {
    designation: {
        required: "Designation is required",
        maxlength: "Designation must not exceed 255 characters",
    },
    experience: {
        required: "Experience is required",
    },
    years_of_experience: {
        required: "Years of experience is required",
    },
    location: {
        required: "Location is required",
    },
    work_type: {
        required: "Please select work type",
    },
    job_description: {
        required: "Job description is required",
    },
    status: {
        required: "Please select status",
    },
};

function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    $('#career_edit_form :input').each(function () {
        const name = $(this).attr('name');
        const value = $(this).val();
        const rules = validationRules[name];
        const messages = validationMessages[name];
        const errorDiv = $(`.error-message[data-error-for="${name}"]`);

        if (!rules) return;

        if (rules.required && (!value || value.toString().trim() === '')) {
            errorDiv.text(messages.required);
            isValid = false;
        }

        if (rules.maxlength && value && value.length > rules.maxlength) {
            errorDiv.text(messages.maxlength);
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

    let formData = new FormData($('#career_edit_form')[0]);

    $.ajax({
        url: submitCareerPage,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
        },
        beforeSend: function () {
            Swal.fire({ 
                title: 'Updating...', 
                allowOutsideClick: false, 
                didOpen: () => Swal.showLoading() 
            });
        },
        success: function () {
            Swal.fire({ 
                icon: 'success', 
                title: 'Career Updated!' 
            }).then(() => {
                window.location.href = "/list_careers";
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
                    title: 'Something went wrong' 
                });
            }
        }
    });
});
