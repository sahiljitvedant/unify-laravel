// Validation Rules
const homeValidationRules  = {
    company_name: { required: true, minlength: 2, maxlength: 10 },
    company_mailing_name: { required: true, minlength: 2, maxlength: 10 },
    address: { required: true },
    country: { required: true },
    state: { required: true },
    pincode: { required: true, number: true },
    phone: { required: true, number: true },
    mobile: { required: true },
    email: { required: true }
};

// Validation Messages
const homevalidationMessages = {
    company_name: {
        required: "Company name is required",
        minlength: "At least 2 characters",
        maxlength: "Cannot exceed 10 characters"
    },
    company_mailing_name: {
        required: "Company Mailing Name is required",
        minlength: "At least 2 characters",
        maxlength: "Cannot exceed 10 characters"
    },
    address: { required: "Address is required" },
    country: { required: "Please select a country" },
    state: { required: "Please select a state" },
    pincode: {
        required: "Pincode is required",
        number: "Pincode must be numeric"
    },
    phone: {
        required: "Phone is required",
        number: "Phone must be numeric"
    },
    mobile: { required: "Mobile number is required" },
    email: { required: "Email is required" }
};


// Validate all form fields
function validateFormhome() 
{
    let isValid = true;

    // Clear previous errors
    $('.error-message').text('');

    $('#multiStepHomeForm :input').each(function () {
        const name = $(this).attr('name');
        const value = $(this).val();
        const rules = homeValidationRules[name];
        const messages = homevalidationMessages[name];
        const errorDiv = $(`.error-message[data-error-for="${name}"]`);

        if (!rules) return true; // skip if no rules

        // Required check
        if (rules.required) {
            if (!value || value.trim() === '' || value === 'Select option') {  // ✅ handle selects
                errorDiv.text(messages.required);
                isValid = false;
                return;
            }
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


// Submit button
$('#submit_home').on('click', function (e) {
    // alert(1);
    e.preventDefault();
   
    if (!validateFormhome()) return;

    alert(validateFormhome());

    let formData = new FormData($('#multiStepHomeForm')[0]);

    $.ajax({
        url: submithome,
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
$('#multiStepHomeForm :input').on('input change', function () {
    const name = $(this).attr('name');
    const value = $(this).val();
    const rules = homeValidationRules [name];
    const messages = homevalidationMessages[name];
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);

    if (!rules) return true;

    let valid = true;

    if (rules.required && (!value || value.trim() === '')) valid = false;
    if (rules.number && value && isNaN(value)) valid = false;

    if (valid) errorDiv.text('');
});
