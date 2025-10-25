// ✅ Validation Rules
const validationRules = {
    membership_id: { required: true },
    price: { required: true, number: true, min: 50 },
    discount: { required: true, number: true, min: 0 }
};

// ✅ Validation Messages
const validationMessages = {
    membership_id: {
        required: "Please select a membership"
    },
    price: { 
        required: "Price is required",
        number: "Please enter a valid number",
        min: "Minimum payment should be 50"
    },
    discount: { 
        required: "Discount is required",
        number: "Please enter a valid number",
        min: "Discount cannot be negative"
    }
};

// ✅ Validate Form Function
function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    $('#add_payment :input').each(function () {
        const name = $(this).attr('name');
        const value = $(this).val();
        const rules = validationRules[name];
        const messages = validationMessages[name];
        const errorDiv = $(`.error-message[data-error-for="${name}"]`);

        if (!rules) return true;

        if (rules.required && (!value || value === '')) {
            errorDiv.text(messages.required);
            isValid = false;
            return;
        }

        if (rules.number && value && isNaN(value)) {
            errorDiv.text(messages.number);
            isValid = false;
            return;
        }

        if (rules.min && value < rules.min) {
            errorDiv.text(messages.min);
            isValid = false;
            return;
        }
    });

    // ✅ Extra Balance Validations (PLACE INSIDE validateForm)
    const remaining = parseFloat($('#remaining_balance').val()) || 0;
    const price = parseFloat($('#price').val()) || 0;
    const discount = parseFloat($('#discount').val()) || 0;

    // 1. Price > remaining
    if (price > remaining) {
        $(`.error-message[data-error-for="price"]`).text(
            "Price cannot be greater than remaining balance"
        );
        isValid = false;
    }

    // 2. Discount > remaining
    if (discount > remaining) {
        $(`.error-message[data-error-for="discount"]`).text(
            "Discount cannot be greater than remaining balance"
        );
        isValid = false;
    }

    // 3. Price + Discount > remaining
    if ((price + discount) > remaining) {
        $(`.error-message[data-error-for="price"]`).text(
            "Price + Discount cannot exceed remaining balance"
        );
        isValid = false;
    }

    return isValid;
}

$('#submitBtn').on('click', function (e) {
    e.preventDefault();

    if (!validateForm()) return;

    let formData = new FormData($('#add_payment')[0]);

    $.ajax({
        url: submitblog,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Submitting...',
                text: 'Please wait while we process your form.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Payment Added!',
                text: 'Payment has been added successfully.',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = "/list_payment";
            });
        },
        error: function (xhr) {
            Swal.close();

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    $(`.error-message[data-error-for="${key}"]`).text(errors[key][0]);
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again.'
                });
            }
        }
    });
});

// ✅ Live Error Removal
$('#add_payment :input').on('input change', function () {
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
