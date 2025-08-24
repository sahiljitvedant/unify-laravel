<!-- In <head> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Before </body> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5">
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Create Gym Package</h4>
        </div>
        <div class="card-body">
            <form id="createPackageForm">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Package Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                    <div class="invalid-feedback">Package name is required.</div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description (optional)</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select name="type" id="type" class="form-select">
                        <option value="">-- Select Type --</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Quarterly">Quarterly</option>
                        <option value="Yearly">Yearly</option>
                        <option value="Session">Session</option>
                    </select>
                    <div class="invalid-feedback">Type is required.</div>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-control">
                    <div class="invalid-feedback">Price is required.</div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Create Package</button>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#createPackageForm').on('submit', function(e) {
        e.preventDefault();

        let isValid = true;

        const name = $('#name');
        const type = $('#type');
        const price = $('#price');

        // Check required fields
        [name, type, price].forEach(field => {
            if (!field.val().trim()) {
                field.addClass('is-invalid');
                isValid = false;
            } else {
                field.removeClass('is-invalid');
            }
        });

        if (!isValid) {
            // Stop form submission
            return;
        }

        // Proceed with AJAX if valid
        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('store_package') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Package Created',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#createPackageForm')[0].reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'An error occurred.'
                    });
                }
            },
            error: function(xhr) {
                console.error(xhr);
                let message = 'Something went wrong, please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message
                });
            }
        });
    });

    // Remove validation error on typing/select change
    $('#name, #type, #price').on('input change', function() {
        if ($(this).val().trim()) {
            $(this).removeClass('is-invalid');
        }
    });
});
</script>


