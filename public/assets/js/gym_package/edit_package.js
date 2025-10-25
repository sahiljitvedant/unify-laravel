$(document).ready(function () {

    // --- Variables ---
    const form = $('#multiStepForm');
    const submitBtn = $('#submitBtn');
    const defaultImage = "{{ asset('assets/img/default.png') }}"; // fallback image

    // Validation rules
    const validationRules = {
        first_name: { required: true },
        middle_name: { required: true },
        last_name: { required: true },
        dob: { required: true },
        gender: { required: true },
        email: { required: true },
        mobile: { required: true },
        residence_address: { required: true },
        residence_area: { required: true },
        zipcode: { required: true },
        city: { required: true },
        state: { required: true },
        country: { required: true },
    };

    const validationMessages = {
        first_name: "Please enter first name",
        middle_name: "Please enter middle name",
        last_name: "Please enter last name",
        dob: "Please select date of birth",
        gender: "Please select gender",
        email: "Please enter email",
        mobile: "Please enter mobile number",
        residence_address: "Please enter residence address",
        residence_area: "Please enter residence area",
        zipcode: "Please enter zipcode",
        city: "Please select city",
        state: "Please select state",
        country: "Please select country",
    };

    // --- Image Preview Handling ---
    $('#uploadButton').off('click').on('click', function () {
        $('#profileImage').click();
    });

    $('#profileImage').off('change').on('change', function (e) {
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

    $('#cancelImageIcon').off('click').on('click', function () {
        $('#profileImage').val('');
        $('#previewImage').attr('src', defaultImage);
        $(this).addClass('d-none');
    });

    // --- Form Validation ---
    // function validateForm() {
    //     let isValid = true;
    //     $('.error-message').text('');

    //     form.find(':input').each(function () {
    //         const name = $(this).attr('name');
    //         const value = $(this).val();
    //         const rules = validationRules[name];
    //         const messages = validationMessages[name];
    //         const errorDiv = $(`.error-message[data-error-for="${name}"]`);

    //         if (!rules) return true; // skip fields without rules

    //         if (rules.required && (!value || value.trim() === '')) {
    //             errorDiv.text(messages);
    //             isValid = false;
    //         }
    //     });

    //     return isValid;
    // }
    function validateForm() {
        let isValid = true;
        $('.error-message').text('');
    
        let firstEmpty = null;
    
        form.find(':input').each(function () {
            const name = $(this).attr('name');
            const value = $(this).val();
            const rules = validationRules[name];
            const messages = validationMessages[name];
            const errorDiv = $(`.error-message[data-error-for="${name}"]`);
    
            if (!rules) return true;
    
            if (rules.required && (!value || value.trim() === '')) {
                errorDiv.text(messages);
                isValid = false;
    
                if (!firstEmpty) firstEmpty = $(this); // store first empty field
            }
        });
    
        if (firstEmpty) {
            $('html, body').animate({
                scrollTop: firstEmpty.offset().top - 100
            }, 600);
            firstEmpty.focus();
        }
    
        return isValid;
    }
    

    // --- AJAX Submit ---
    submitBtn.off('click').on('click', function (e) {
        e.preventDefault();

        if (!validateForm()) return;

        const formData = new FormData(form[0]);

        $.ajax({
            url: stepperEditUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                submitBtn.prop('disabled', true).text('Submitting...');
            },
            success: function (response) {
                // alert('Profile updated successfully!');
                Swal.fire({
                    icon: 'success',
                    title: 'Form Submitted!',
                    text: 'Your Profile has been updated successfully.',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = "/member_dashboard";
                });;
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                // alert('An error occurred. Check console for details.');
                let res = xhr.responseJSON;
                let message = res && res.message ? res.message : 'An error occurred. Check console for details.';
                
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: message,
                    confirmButtonText: 'OK'
                });
            },
            complete: function () {
                submitBtn.prop('disabled', false).text('Submit');
            }
        });
    });

});
