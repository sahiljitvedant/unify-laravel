$(document).ready(function() {

    // Unique validation rules for membership tab
    const validationRulesMembership = {
        membership_type: { required: true },
        joining_date: { required: true },
        expiry_date: { required: true },
        amount_paid: { required: true },
        payment_method: { required: true },
        trainer_assigned: { required: true },
    };

    const validationMessagesMembership = {
        membership_type: { required: "Please select membership type" },
        joining_date: { required: "Please select joining date" },
        expiry_date: { required: "Please select expiry date" },
        amount_paid: { required: "Please enter amount paid" },
        payment_method: { required: "Please select payment method" },
        trainer_assigned: { required: "Please select trainer" },
    };

    function validateMembershipForm() {
        let isValid = true;
        $('.error-message').text('');

        $('#memebrStepForm :input').each(function () {
            const name = $(this).attr('name');
            const value = $(this).val();
            const rules = validationRulesMembership[name];
            const messages = validationMessagesMembership[name];
            const errorDiv = $(`.error-message[data-error-for="${name}"]`);

            if (!rules) return true; // skip

            if (rules.required && (!value || value.trim() === '')) {
                errorDiv.text(messages.required);
                isValid = false;
            }
        });

        return isValid;
    }

    // Handle submit
    $('#submitMemebrBtn').off('click').on('click', function(e) {
        e.preventDefault();
    
        if (!validateMembershipForm()) return;
    
        let formData = new FormData($('#memebrStepForm')[0]);
    
        $.ajax({
            url: steppermemberEditUrl,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert('Success: ' + response.message);
            },
            error: function(xhr) {
                console.log(xhr.status);
                console.log(xhr.responseText);
                alert("An error occurred. Check console for details.");
            }
        });
    });
    

});
