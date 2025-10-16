// Validation Rules
const validationRules = {
    gallery_name: { 
        required: true, 
        minlength: 3, 
        maxlength: 150 
    },
    is_active: { 
        required: true 
    },
    gallary_image: { 
        required: true,
      
    },
    "gallery_images[]": { 
        extension: "jpg|jpeg|png" 
    },
    "youtube_links[]": { 
        url: true 
    }
};

// Validation Messages
const validationMessages = {
    gallery_name: { 
        required: "Gallery name is required", 
        minlength: "Gallery name must be at least 3 characters", 
        maxlength: "Gallery name must not exceed 150 characters" 
    },
    is_active: { 
        required: "Please select the status" 
    },
    gallary_image: { 
        required: "Main thumbnail is required", 
        
    },
    "gallery_images[]": { 
        extension: "Only JPG, JPEG, PNG images are allowed" 
    },
    "youtube_links[]": { 
        url: "Please enter a valid YouTube link" 
    }
};

// Validate all form fields

function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    $('#add_gallery :input').each(function () {
        const name = $(this).attr('name');
        const value = $(this).val();
        const rules = validationRules[name];
        const messages = validationMessages[name];
        const errorDiv = $(`.error-message[data-error-for="${name}"]`);

        if (!rules) return true;

        if (rules.required && (!value || value.trim() === '')) {
            errorDiv.text(messages.required);
            isValid = false;
            return;
        }
    });

    // ✅ THIS MUST STAY
    if (!$('#gallary_image_path').val()) {
        $(`.error-message[data-error-for="gallary_image"]`).text(validationMessages.gallary_image.required);
        isValid = false;
    }

    // ✅ Include YouTube validation too
    if (!validateYouTubeLinks()) {
        isValid = false;
    }

    return isValid;
}



// Image preview
$('#profileImage').on('change', function (e) 
{
    const file = e.target.files[0];
    if (file) {
        $('#previewImage').attr('src', URL.createObjectURL(file));
    }
});

// Submit button
$('#submitBtn').on('click', function (e) {
    // alert(1);
    e.preventDefault();
   
    if (!validateForm()) return;

    let formData = new FormData($('#add_gallery')[0]);

    $.ajax({
        url: submitGallary,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            // Show loader before sending request
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
            // Close loader & show success popup
            Swal.fire({
                icon: 'success',
                title: 'Form Submitted!',
                text: 'Your Gallary has been created successfully.',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = "/list_gallery";
            });
        },
        error: function (xhr) {
            Swal.close(); // close loader
        
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    let fieldKey = key.replace(/\.\d+$/, '[]'); // convert youtube_links.0 → youtube_links[]
                    $(`.error-message[data-error-for="${fieldKey}"]`).text(errors[key][0]);
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

// Live error removal
$('#add_gallery :input').on('input change', function () {
    const name = $(this).attr('name');
    const value = $(this).val();
    const rules = validationRules[name];
    const messages = validationMessages[name];
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);

    if (!rules) return true;

    let valid = true;

    if (rules.required && (!value || value.trim() === '')) valid = false;
    if (rules.number && value && isNaN(value)) valid = false;

    // Min length
    if (rules.minlength && value && value.length < rules.minlength) valid = false;

    // Max length
    if (rules.maxlength && value && value.length > rules.maxlength) valid = false;


    if (valid) errorDiv.text('');
});

// Helper function
function isValidUrl(url) {
    let pattern = /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/;
    return pattern.test(url);
}

// Add new YouTube link
$(document).on('click', '#addYoutubeLink', function() 
{
    let lastInput = $('#youtubeLinksWrapper .youtube-input').last();
    let errorDiv = $(`.error-message[data-error-for="youtube_links[]"]`);
    errorDiv.text('');

    // If there is already an input, check it before adding new one
    if (lastInput.length) {
        let val = lastInput.val().trim();
        if (val === '' || !isValidUrl(val)) {
            errorDiv.text("Please enter a valid YouTube link before adding another");
            lastInput.focus();
            return;
        }
    }

    // Append new input
    $('#youtubeLinksWrapper').append(`
        <div class="d-flex mb-2 youtube-link-row">
            <input type="url" class="form-control youtube-input" name="youtube_links[]" placeholder="Enter YouTube link">
            <button type="button" class="btn btn-danger ms-2 remove-link">-</button>
        </div>
    `);
});

// Remove link
$(document).on('click', '.remove-link', function() {
    $(this).closest('.youtube-link-row').remove();
});

// Validate all YouTube links on form submit
function validateYouTubeLinks() {
    let isValid = true;
    let errorDiv = $(`.error-message[data-error-for="youtube_links[]"]`);
    errorDiv.text('');

    $('#youtubeLinksWrapper .youtube-input').each(function() {
        let val = $(this).val().trim();
        if (val === '' || !isValidUrl(val)) {
            errorDiv.text("All YouTube links must be valid or removed");
            isValid = false;
            return false; // break
        }
    });

    return isValid;
}
// ✅ Limit gallery image uploads to max 2
function handleMultipleGalleryUpload() {
    const maxImages = 2;
    const $wrapper = $('#multiGalleryWrapper');
    const $button = $('#uploadMultipleGallery');

    // Count current images
    const currentCount = $wrapper.find('.gallery-thumb').length;

    if (currentCount >= maxImages) {
        Swal.fire({
            icon: 'warning',
            title: 'Limit Reached',
            text: `You can only upload up to ${maxImages} images.`,
            confirmButtonText: 'OK'
        });
        return;
    }

  
}

// ✅ Observe gallery wrapper for changes (add/remove images)
const observer = new MutationObserver(() => {
    const maxImages = 2;
    const $wrapper = $('#multiGalleryWrapper');
    const $button = $('#uploadMultipleGallery');
    const currentCount = $wrapper.find('.gallery-thumb').length;

    // Disable or enable button dynamically
    if (currentCount >= maxImages) {
        $button.prop('disabled', true).addClass('disabled');
    } else {
        $button.prop('disabled', false).removeClass('disabled');
    }
});

// ✅ Start observing for image count changes
observer.observe(document.getElementById('multiGalleryWrapper'), { childList: true });

// Optional CSS style for disabled button (add to your CSS)
const style = document.createElement('style');
style.textContent = `
    #uploadMultipleGallery.disabled {
        opacity: 0.6;
        pointer-events: none;
    }
`;
document.head.appendChild(style);




