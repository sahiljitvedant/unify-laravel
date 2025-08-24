// Validation Rules
const validationRules = {
    membership_type: { required: true },
    joining_date: { required: true },
    expiry_date: { required: true },
    amount_paid: { required: true, number: true },
    payment_method: { required: true },
    trainer_assigned: { required: true },
};

// Validation Messages
const validationMessages = {
    membership_type: { required: "Please select a membership type" },
    joining_date: { required: "Joining date is required" },
    expiry_date: { required: "Expiry date is required" },
    amount_paid: {
        required: "Amount paid is required",
        number: "Amount paid must be numeric"
    },
    payment_method: { required: "Please select a payment method" },
    trainer_assigned: { required: "Please select a trainer" },
};

// Validate all form fields
function validateForm() 
{
    let isValid = true;

    // Clear previous errors
    $('.error-message').text('');

    $('#multiStepForm :input').each(function () {
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
    });

    return isValid;
}

// Image preview
$('#profileImage').on('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        $('#previewImage').attr('src', URL.createObjectURL(file));
    }
});

// Submit button
$('#submitBtn').on('click', function (e) {
    e.preventDefault();
   
    if (!validateForm()) return;

    let formData = new FormData($('#multiStepForm')[0]);

    $.ajax({
        url: stepperEditUrl,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            alert('Success: ' + response);
        },
        error: function (xhr) {
            console.log(xhr.status);
            console.log(xhr.responseText);
            alert("An error occurred. Check console for details.");
        }
    });
});

// Live error removal
$('#multiStepForm :input').on('input change', function () {
    const name = $(this).attr('name');
    const value = $(this).val();
    const rules = validationRules[name];
    const messages = validationMessages[name];
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);

    if (!rules) return true;

    let valid = true;

    if (rules.required && (!value || value.trim() === '')) valid = false;
    if (rules.number && value && isNaN(value)) valid = false;

    if (valid) errorDiv.text('');
});
