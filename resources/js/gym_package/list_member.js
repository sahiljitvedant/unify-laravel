// Profile Image Preview JS:-

$(document).ready(function () 
{
    alert('hi');
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