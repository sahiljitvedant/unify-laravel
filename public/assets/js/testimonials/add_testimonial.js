// ================= VALIDATION RULES =================
const validationRules = {
    name: { required: true, minlength: 3, maxlength: 100 },
    testimonial_text: { required: true, minlength: 10, maxlength: 300 },
    is_active: { required: true }
};

// ================= VALIDATION MESSAGES =================
const validationMessages = {
    name: { required: "Client name is required", minlength: "Minimum 3 characters required", maxlength: "Max 100 characters allowed" },
    testimonial_text: { required: "Testimonial text is required", minlength: "Minimum 10 characters required", maxlength: "Max 300 characters allowed" },
    is_active: { required: "Please select status" }
};

// ================= VALIDATE FORM =================
function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    $('#testimonial_add_form :input').each(function () {
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

// ================= SUBMIT FORM =================
$('#testimonial_add_form').on('submit', function (e) {
    e.preventDefault();
    if (!validateForm()) return;

    let formData = new FormData(this);

    $.ajax({
        url: submitTestimonial,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        beforeSend: () => Swal.fire({ title: 'Submitting...', allowOutsideClick: false, didOpen: () => Swal.showLoading() }),
        success: () => Swal.fire({ icon: 'success', title: 'Success!' }).then(() => window.location.href = "/list_testimonials"),
        error: xhr => {
            Swal.close();
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    $(`.error-message[data-error-for="${key}"]`).text(errors[key][0]);
                }
            } else {
                Swal.fire("Error", "Something went wrong!", "error");
            }
        }
    });
});

// ================= LIVE ERROR CLEAR =================
$('#testimonial_add_form :input').on('input change', function () {
    const name = $(this).attr('name');
    const value = $(this).val();
    const rules = validationRules[name];
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);

    if (!rules) return;
    let valid = true;

    if (rules.required && (!value || value.trim() === '')) valid = false;
    if (rules.minlength && value && value.length < rules.minlength) valid = false;
    if (rules.maxlength && value && value.length > rules.maxlength) valid = false;

    if (valid) errorDiv.text('');
});
// When crop script sets preview image, store path into hidden input
$(document).ajaxSuccess(function (event, xhr, settings) {
    if (settings.url.includes('cropUpload')) {
        let res = xhr.responseJSON;

        if (res && res.path) {
            $('#profile_pic').val(res.path); // store DB path
        }
    }
});