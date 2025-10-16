// Validation Rules
const validationRules = {
    gallery_name: { required: true, minlength: 3, maxlength: 150 },
    is_active: { required: true },
    gallary_image: { required: true },
    "gallery_images[]": { extension: "jpg|jpeg|png" },
    "youtube_links[]": { url: true }
};

// Validation Messages
const validationMessages = {
    gallery_name: { required: "Gallery name is required", minlength: "Gallery name must be at least 3 characters", maxlength: "Gallery name must not exceed 150 characters" },
    is_active: { required: "Please select the status" },
    gallary_image: { required: "Main thumbnail is required" },
    "gallery_images[]": { extension: "Only JPG, JPEG, PNG images are allowed" },
    "youtube_links[]": { url: "Please enter a valid YouTube link" }
};

$(document).ready(function() {
    // Pre-fill main thumbnail
    if ($('#gallary_image_path').val()) {
        $('#previewGallaryImage').attr('src', $('#gallary_image_path').val());
        $('#galleryThumbWrapper').removeClass('d-none');
    }

    // Pre-fill multiple gallery images
  
    // Pre-fill YouTube links
    let existingLinks = $('#youtube_links_json').val(); // hidden input with JSON
    if (existingLinks) {
        let links = JSON.parse(existingLinks);
        links.forEach(link => {
            $('#youtubeLinksWrapper').append(`
                <div class="d-flex mb-2 youtube-link-row">
                    <input type="url" class="form-control youtube-input" name="youtube_links[]" placeholder="Enter YouTube link" value="${link}">
                    <button type="button" class="btn btn-danger ms-2 remove-link">-</button>
                </div>
            `);
        });
    }
});


function validateForm() {
    let isValid = true;
    $('.error-message').text('');

    $('#edit_gallery :input').each(function () {
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

    // Main thumbnail
    if (!$('#gallary_image_path').val()) {
        $(`.error-message[data-error-for="gallary_image"]`).text(validationMessages.gallary_image.required);
        isValid = false;
    }

    // YouTube links
    if (!validateYouTubeLinks()) {
        isValid = false;
    }

    return isValid;
}


$('#submitBtn').on('click', function (e) {
    e.preventDefault();

    if (!validateForm()) return;

    let galleryId = $('#gallery_id').val(); // hidden input with current ID
    let formData = new FormData($('#edit_gallery')[0]);

    $.ajax({
        url: submitGalleryUpdate,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            Swal.fire({ title: 'Updating...', text: 'Please wait...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        },
        success: function (response) {
            Swal.fire({ icon: 'success', title: 'Updated!', text: 'Gallery updated successfully.', confirmButtonText: 'OK', allowOutsideClick: false })
                .then(() => { window.location.href = "/list_gallery"; });
        },
        error: function (xhr) {
            Swal.close();
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    let fieldKey = key.replace(/\.\d+$/, '[]');
                    $(`.error-message[data-error-for="${fieldKey}"]`).text(errors[key][0]);
                }
            } else {
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Something went wrong!' });
            }
        }
    });
});

$('#edit_gallery :input').on('input change', function () {
    const name = $(this).attr('name');
    const value = $(this).val();
    const rules = validationRules[name];
    const errorDiv = $(`.error-message[data-error-for="${name}"]`);

    if (!rules) return true;

    let valid = true;
    if (rules.required && (!value || value.trim() === '')) valid = false;
    if (rules.number && value && isNaN(value)) valid = false;
    if (rules.minlength && value && value.length < rules.minlength) valid = false;
    if (rules.maxlength && value && value.length > rules.maxlength) valid = false;

    if (valid) errorDiv.text('');
});


function isValidUrl(url) {
    let pattern = /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/;
    return pattern.test(url);
}

$(document).on('click', '#addYoutubeLink', function() {
    let lastInput = $('#youtubeLinksWrapper .youtube-input').last();
    let errorDiv = $(`.error-message[data-error-for="youtube_links[]"]`);
    errorDiv.text('');

    if (lastInput.length && (!isValidUrl(lastInput.val().trim()))) {
        errorDiv.text("Please enter a valid YouTube link before adding another");
        lastInput.focus();
        return;
    }

    $('#youtubeLinksWrapper').append(`
        <div class="d-flex mb-2 youtube-link-row">
            <input type="url" class="form-control youtube-input" name="youtube_links[]" placeholder="Enter YouTube link">
            <button type="button" class="btn btn-danger ms-2 remove-link">-</button>
        </div>
    `);
});

$(document).on('click', '.remove-link', function() {
    $(this).closest('.youtube-link-row').remove();
});

function validateYouTubeLinks() {
    let isValid = true;
    let errorDiv = $(`.error-message[data-error-for="youtube_links[]"]`);
    errorDiv.text('');

    $('#youtubeLinksWrapper .youtube-input').each(function() {
        let val = $(this).val().trim();
        if (val === '' || !isValidUrl(val)) {
            errorDiv.text("All YouTube links must be valid or removed");
            isValid = false;
            return false;
        }
    });

    return isValid;
}


function updateGalleryImagesInput() {
    let paths = [];
    $('#multiGalleryWrapper .gallery-thumb-wrapper, #multiGalleryWrapper .gallery-thumb').each(function() {
        let path = $(this).data('path') || $(this).find('img').attr('src');
        if (path) paths.push(path);
    });
    $('#gallery_images_path').val(paths.join(','));
}

$(document).on('click', '.remove-gallery-image, .remove-image', function() {
    $(this).closest('.gallery-thumb-wrapper, .gallery-thumb').remove();
    updateGalleryImagesInput(); // Update hidden input after removing
});
