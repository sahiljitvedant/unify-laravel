$(document).ready(function () {
    let cropper;
    let imageType = null;

    const $browseImage = $("#browseImage");
    const $browseBtn = $("#browseBtn");
    const $uploadButton = $(".profilebtn"); // works for profile/blog/faq
    const $imageToCrop = $("#imageToCrop");
    const $imagePreviewContainer = $("#imagePreviewContainer");
    const $uploadCropped = $("#uploadCropped");
    const $progressContainer = $("#uploadProgress");
    const $progressBar = $progressContainer.find(".progress-bar");

    // Open modal when upload button is clicked
    $uploadButton.on("click", function () {
        imageType = $(this).data("type") || null;

        // Ensure hidden input exists BEFORE upload
        if (imageType === "profile_image" && $("#profile_image_path").length === 0) {
            $("#multiStepForm").append('<input type="hidden" name="profile_image" id="profile_image_path">');
        }
        if (imageType === "blog_image" && $("#blog_image_path").length === 0) {
            $("#add_blogs").append('<input type="hidden" name="blog_image" id="blog_image_path">');
        }
        if (imageType === "faq_image" && $("#faq_image_path").length === 0) {
            $("#faqForm").append('<input type="hidden" name="faq_image" id="faq_image_path">');
        }

        const modal = new bootstrap.Modal($("#cropImageModal")[0]);
        modal.show();
    });

    // Trigger file input inside modal
    $browseBtn.on("click", function () {
        $browseImage.val("");
        $browseImage.click();
    });

    // When user selects an image
    $browseImage.on("change", function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (event) {
            $imageToCrop.attr("src", event.target.result);
            $imagePreviewContainer.show();
            $uploadCropped.prop("disabled", false);

            if (cropper) cropper.destroy();

            let aspect = imageType === "blog_image" ? 16 / 9 : 1; // blog 16:9, profile/faq 1:1

            cropper = new Cropper($imageToCrop[0], {
                aspectRatio: aspect,
                viewMode: 0,
                zoomable: false,
                scalable: false,
                movable: false,
                cropBoxResizable: true,
                dragMode: 'move'
            });
        };
        reader.readAsDataURL(file);
    });

    // Upload cropped image
    $uploadCropped.on("click", function () {
        if (!cropper) return;

        // Set size based on type
        let width, height;
        if (imageType === "blog_image") {
            width = 1280; height = 720;
        } else if (imageType === "faq_image") {
            width = 500; height = 500;
        } else {
            width = 600; height = 600; // profile_image default
        }

        cropper.getCroppedCanvas({ width: width, height: height }).toBlob(function (blob) {
            const formData = new FormData();
            const fieldName = imageType === "blog_image" ? "blog_image" : (imageType === "faq_image" ? "faq_image" : "profile_image");

            formData.append(fieldName, blob, "image.png");
            formData.append("type", imageType);
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: uploadUrl,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                xhr: function () {
                    const xhr = $.ajaxSettings.xhr();
                    if (xhr.upload) {
                        xhr.upload.addEventListener("progress", function (e) {
                            if (e.lengthComputable) {
                                const percent = Math.round((e.loaded / e.total) * 100);
                                $progressBar.css("width", percent + "%").text(percent + "%");
                                $progressContainer.show();
                            }
                        }, false);
                    }
                    return xhr;
                },
                success: function (data) {
                    if (data.success) {
                        if (imageType === "profile_image") {
                            $("#previewImage").attr("src", data.url);
                            $("#profile_image_path").val(data.path);
                        } else if (imageType === "blog_image") {
                            $("#previewBlogImage").attr("src", data.url);
                            $("#blogImageWrapper").removeClass("d-none");
                            $("#blog_image_path").val(data.path);
                        }else if (imageType === "faq_image") {
                            $("#previewFaqImage").attr("src", data.url);
                            $("#faqImageWrapper").removeClass("d-none"); // <-- show the wrapper
                            if ($("#faq_image_path").length === 0) {
                                $("#faq_add_form").append('<input type="hidden" name="faq_image" id="faq_image_path">');
                            }
                            $("#faq_image_path").val(data.path);
                        }

                        bootstrap.Modal.getInstance($("#cropImageModal")[0]).hide();
                        $progressContainer.hide();
                        $progressBar.css("width", "0%").text("0%");
                    } else {
                        alert("Upload failed!");
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert("An error occurred while uploading.");
                }
            });
        });
    });

    // Reset modal
    $('#cropImageModal').on('hidden.bs.modal', function () {
        if (cropper) cropper.destroy();
        $imageToCrop.attr("src", "");
        $imagePreviewContainer.hide();
        $uploadCropped.prop("disabled", true);
        $progressContainer.hide();
        $progressBar.css("width", "0%").text("0%");
        imageType = null;
    });
});
