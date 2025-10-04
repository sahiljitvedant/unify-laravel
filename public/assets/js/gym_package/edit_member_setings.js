$(document).ready(function () {
    // Validation Rules & Messages
    const validationsettingRules = {
        fitness_goals: { required: true },
        preferred_workout_time: { required: true },
     
    };

    const validationsettingmessage = {
        fitness_goals: { required: "Please select a fitness goal" },
        preferred_workout_time: { required: "Please select preferred workout time" },
  
    };

    // Validate Form Function
    function validateForm() {
        let isValid = true;
        $('.error-message').text('');

        $('#formSettings :input').each(function () {
            const name = $(this).attr('name');
            const value = $(this).val();
            const rules = validationsettingRules[name];
            const messages = validationsettingmessage[name];
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

    // Button Click Handler
    $('#profiesubmitBtn').on('click', function (e) {
        e.preventDefault(); // Prevent normal submit
        // alert("🟢 Button clicked!");

        if (!validateForm()) return;

        let formData = new FormData($('#formSettings')[0]);

        $.ajax({
            url: stepperEditSettings, // make sure this variable exists in Blade
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                alert('Success: ' + response.message);
            },
            error: function (xhr) {
                console.log(xhr.status);
                console.log(xhr.responseText);
                alert("An error occurred. Check console for details.");
            }
        });
    });

    // Live error removal
    $('#formSettings :input').on('input change', function () {
        const name = $(this).attr('name');
        const value = $(this).val();
        const rules = validationRules[name];
        const errorDiv = $(`.error-message[data-error-for="${name}"]`);

        if (!rules) return;

        let valid = true;
        if (rules.required && (!value || value.trim() === '')) valid = false;
        if (rules.number && value && isNaN(value)) valid = false;

        if (valid) errorDiv.text('');
    });
});
