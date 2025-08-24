// Profile Image Preview JS:-
$(document).ready(function () 
{
    // alert('hi');
    const defaultImage = 'https://via.placeholder.com/150x150?text=Profile';

    // Trigger file input on upload button click
    $('#uploadButton').on('click', function () {
        $('#profileImage').click();
    });

    // Preview selected image
    $('#profileImage').on('change', function (e) 
    {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#previewImage').attr('src', e.target.result);
                $('#cancelImageIcon').removeClass('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    // Cancel/reset image
    $('#cancelImageIcon').on('click', function () {
        $('#profileImage').val('');
        $('#previewImage').attr('src', defaultImage);
        $(this).addClass('d-none');
    });
});

// Stepper Form Logic:-
let currentStep = 1;
const totalSteps = 3;

// Stepper Form Validation Rules
const validationRules = {
    first_name: { required: true, minlength: 2, maxlength: 10 },
    last_name: { required: true, minlength: 2, maxlength: 10 },
    email: { required: true, email: true },
    mobile: { required: true, number: true, minlength: 10, maxlength: 10 },
    gender: { required: true },
    dob: { required: true },
    residence_address: { required: true },
    zipcode: { required: true, number: true, minlength: 6, maxlength: 6 },
    city: { required: true },
    state: { required: true },
    country: { required: true },

    // Step 2:-
    membership_type: { required: true },
    joining_date: { required: true },
    expiry_date: { required: true },
    amount_paid: { required: true, number: true },
    payment_method: { required: true },
    trainer_assigned: { required: true },

    // Step 3
    fitness_goals: { required: true },
    preferred_workout_time: { required: true },
    
};


// Stepper Form Validation Messages
const validationMessages = {
    first_name: {
        required: "First name is required",
        minlength: "First name must be at least 2 characters",
        maxlength: "First name cannot exceed 10 characters"
    },
    last_name: {
        required: "Last name is required",
        minlength: "Last name must be at least 2 characters",
        maxlength: "Last name cannot exceed 10 characters"
    },
    email: {
        required: "Email is required",
        email: "Please enter a valid email address"
    },
    mobile: {
        required: "Mobile number is required",
        number: "Mobile number must be numeric",
        minlength: "Mobile number must be exactly 10 digits",
        maxlength: "Mobile number must be exactly 10 digits"
    },
    gender: { 
        required: "Please select a gender" 
    },
    dob: { 
        required: "Date of birth is required" 
    },
    residence_address: { 
        required: "Residence address is required" 
    },
    zipcode: {
        required: "Zipcode is required",
        number: "Zipcode must be numeric",
        minlength: "Zipcode must be exactly 6 digits",
        maxlength: "Zipcode must be exactly 6 digits"
    },
    city: { 
        required: "Please select a city" 
    },
    state: { 
        required: "Please select a state" 
    },
    country: { 
        required: "Please select a country" 
    },

    // Step 2:-
    membership_type: { required: "Please select a membership type" },
    joining_date: { required: "Joining date is required" },
    expiry_date: { required: "Expiry date is required" },
    amount_paid: {
        required: "Amount paid is required",
        number: "Amount paid must be numeric"
    },
    payment_method: { required: "Please select a payment method" },
    trainer_assigned: { required: "Please select a trainer" },

    // Step 3
    fitness_goals: { required: "Please select a fitness goal" },
    preferred_workout_time: { required: "Please select a preferred workout time" },
};


function showStep(step) 
{
    $('.step').addClass('d-none');
    $(`.step[data-step="${step}"]`).removeClass('d-none');

    // Show/hide Prev button
    if (step === 1) {
        $('#prevBtn').css('visibility', 'hidden'); // hide but keep space
    } else {
        $('#prevBtn').css('visibility', 'visible');
    }

    // Show/hide Next button
    if (step === totalSteps) {
        $('#nextBtn').hide();
        $('#submitBtn').show();
    } else {
        $('#nextBtn').show();
        $('#submitBtn').hide();
    }
}


$('#nextBtn').click(function () {
    if (validateCurrentStep()) {
        currentStep++;
        showStep(currentStep);
    }
});

$('#prevBtn').click(function ()
{
    if (currentStep > 1) 
    {
        currentStep--;
        showStep(currentStep);
    }
});


// Validate current step fields before moving to next
function validateCurrentStep() 
{
    let isValid = true;

    // Clear previous errors
    $('.error-message').text('');

    $(`.step[data-step="${currentStep}"] :input`).each(function () {
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
        if (rules.number && value && !/^\d+$/.test(value)) {
            errorDiv.text(messages.number);
            isValid = false;
            return;
        }

        // Minlength check
        if (rules.minlength && value.length < rules.minlength) {
            errorDiv.text(messages.minlength);
            isValid = false;
            return;
        }

        // Maxlength check
        if (rules.maxlength && value.length > rules.maxlength) {
            errorDiv.text(messages.maxlength);
            isValid = false;
            return;
        }

        // Email check
        if (rules.email && value) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(value)) {
                errorDiv.text(messages.email);
                isValid = false;
                return;
            }
        }

        // Radio buttons
        if ($(this).is(':radio') && $(`input[name="${name}"]:checked`).length === 0) {
            errorDiv.text(messages.required);
            isValid = false;
            return;
        }
    });

    return isValid;
}


// Initial
showStep(currentStep);

// Optional: Image preview
$('#profileImage').on('change', function (e) 
{
    const file = e.target.files[0];
    if (file) {
        $('#previewImage').attr('src', URL.createObjectURL(file));
    }
});


// Submit button call:-
$('#submitBtn').on('click', function (e) 
{
    // alert('hiii');
    e.preventDefault();
    if (!validateCurrentStep()) return;

    let formData = new FormData($('#multiStepForm')[0]);

    $.ajax
    ({
        url: stepperSubmitUrl, 
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: 
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            alert('Success: ' + response);
        },
        error: function (xhr) {
            console.log(xhr.status);
            console.log(xhr.responseText); // This may include the Sfdump HTML
            alert("An error occurred. Check console for details.");
        }
    });
});


// Remove error on change/input
$(`.step :input`).on('input change', function () {
    const name = $(this).attr('name');
    const value = $(this).val();
    const rules = validationRules[name];
    const messages = validationMessages[name];
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);

    if (!rules) return true;

    let valid = true;

    // Required check
    if (rules.required && (!value || value.trim() === '')) valid = false;

    // Email check
    if (rules.email && value) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(value)) valid = false;
    }

    // Minlength check
    if (rules.minlength && value.length < rules.minlength) valid = false;

    // Maxlength check
    if (rules.maxlength && value.length > rules.maxlength) valid = false;

    // Number check
    if (rules.number && value && isNaN(value)) valid = false;

    // Radio buttons
    if ($(this).is(':radio') && $(`input[name="${name}"]:checked`).length === 0) valid = false;

    // Only clear error if field is valid
    if (valid) {
        errorDiv.text('');
    }
});


