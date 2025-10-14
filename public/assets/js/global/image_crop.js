$(document).ready(function () {
    let cropper;
    let imageType = null;

    const $browseImage = $("#browseImage");
    const $browseBtn = $("#browseBtn");
    const $uploadButton = $(".profilebtn"); // works for profile/blog/faq/gallery
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
        if (imageType === "gallary_image" && $("#gallary_image_path").length === 0) {
            $("#add_gallery").append('<input type="hidden" name="gallary_image" id="gallary_image_path">');

        }
        // if (imageType === "gallery_multiple" && $("#gallery_images_path").length === 0) {
        //     $("#add_gallery").append('<input type="hidden" name="gallery_images" id="gallery_images_path">');
        // }

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

            let aspect = imageType === "blog_image" ? 16 / 9 : 1; // blog 16:9, profile/faq/gallery 1:1

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

        let width, height;
        switch (imageType) {
            case "blog_image":
                width = 1280; height = 720; break;
            case "faq_image":
                width = 500; height = 500; break;
            case "gallary_image":
                width = 700; height = 700; break;
            case "gallery_multiple":
                width = 500; height = 500; break;
            default:
                width = 600; height = 600; // profile_image default
        }

        cropper.getCroppedCanvas({ width, height }).toBlob(function (blob) {
            const formData = new FormData();
            let fieldName;

            switch (imageType) {
                case "blog_image": fieldName = "blog_image"; break;
                case "faq_image": fieldName = "faq_image"; break;
                case "profile_image": fieldName = "profile_image"; break;
                case "gallary_image": fieldName = "gallary_image"; break;
                case "gallery_multiple": fieldName = "gallery_images[]"; break;
                default: fieldName = "image";
            }

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
                        // profile, blog, faq, gallery thumbnail
                        if (imageType === "profile_image") {
                            $("#previewImage").attr("src", data.url);
                            $("#profile_image_path").val(data.path);
                        } else if (imageType === "blog_image") {
                            $("#previewBlogImage").attr("src", data.url);
                            $("#blogImageWrapper").removeClass("d-none");
                            $("#blog_image_path").val(data.path);
                        } else if (imageType === "faq_image") {
                            $("#previewFaqImage").attr("src", data.url);
                            $("#faqImageWrapper").removeClass("d-none");
                            if ($("#faq_image_path").length === 0) {
                                $("#faq_add_form").append('<input type="hidden" name="faq_image" id="faq_image_path">');
                            }
                            $("#faq_image_path").val(data.path);
                        } else if (imageType === "gallary_image") {
                            $("#previewGallaryImage").attr("src", data.url);
                            $("#galleryThumbWrapper").removeClass("d-none");
                            $("#gallary_image_path").val(data.path);
                        } 
                        // Multiple gallery images
                        else if (imageType === "gallery_multiple") {
                            const currentVal = $("#gallery_images_path").val();
                            const newVal = currentVal ? currentVal + ',' + data.path : data.path;
                            $("#gallery_images_path").val(newVal);

                            $('#multiGalleryWrapper').append(`
                                <div class="position-relative d-inline-block" style="max-width:100px;">
                                    <img src="${data.url}" style="max-width:100px; max-height:100px; border:1px solid #ddd; border-radius:5px;">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image">&times;</button>
                                </div>
                            `);

                            // Reset modal for next image upload
                            $browseImage.val("");
                            $uploadCropped.prop("disabled", true);
                            $imageToCrop.attr("src", "");
                            $imagePreviewContainer.hide();
                            if (cropper) cropper.destroy();
                        }

                        if (imageType !== "gallery_multiple") {
                            bootstrap.Modal.getInstance($("#cropImageModal")[0]).hide();
                        }

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

    // Remove gallery image
    $(document).on("click", ".remove-image", function () {
        $(this).parent().remove();
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
