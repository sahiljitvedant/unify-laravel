<form id="formSettings" class="">
<div class="container mt-3">
    <div class="row g-3 text-center">

        <div class="col-12 col-md-4 d-flex align-items-center justify-content-between px-4">
            <label class="form-label mb-0">Profile Pic</label>
            <div class="form-check form-switch">
                <input class="form-check-input theme-toggle" type="checkbox" id="image" checked>
            </div>
        </div>

        <div class="col-12 col-md-4 d-flex align-items-center justify-content-between px-4">
            <label class="form-label mb-0">Name</label>
            <div class="form-check form-switch">
                <input class="form-check-input theme-toggle" type="checkbox" id="name" checked>
            </div>
        </div>

        <div class="col-12 col-md-4 d-flex align-items-center justify-content-between px-4">
            <label class="form-label mb-0">Email</label>
            <div class="form-check form-switch">
                <input class="form-check-input theme-toggle" type="checkbox" id="email" checked>
            </div>
        </div>

        <div class="col-12 col-md-4 d-flex align-items-center justify-content-between px-4">
            <label class="form-label mb-0">Mobile</label>
            <div class="form-check form-switch">
                <input class="form-check-input theme-toggle" type="checkbox" id="mobile" checked>
            </div>
        </div>

        <div class="col-12 col-md-4 d-flex align-items-center justify-content-between px-4">
            <label class="form-label mb-0">Preferred Time</label>
            <div class="form-check form-switch">
                <input class="form-check-input theme-toggle" type="checkbox" id="preferred_time" checked>
            </div>
        </div>

        <div class="col-12 col-md-4 d-flex align-items-center justify-content-between px-4">
            <label class="form-label mb-0">Date of Birth</label>
            <div class="form-check form-switch">
                <input class="form-check-input theme-toggle" type="checkbox" id="dob" checked>
            </div>
        </div>

        <div class="col-12 col-md-4 d-flex align-items-center justify-content-between px-4">
            <label class="form-label mb-0">Address</label>
            <div class="form-check form-switch">
                <input class="form-check-input theme-toggle" type="checkbox" id="address" checked>
            </div>
        </div>

        <div class="col-12 col-md-4 d-flex align-items-center justify-content-between px-4">
            <label class="form-label mb-0">Goal</label>
            <div class="form-check form-switch">
                <input class="form-check-input theme-toggle" type="checkbox" id="goal" checked>
            </div>
        </div>

    </div>
</div>

</div>

    
</form>
<style>
    .theme-toggle {
        cursor: pointer;
        accent-color: #0B1061 ;
        width: 2.5em;
        height: 1.3em;
    }

    .form-label {
        font-size: 14px;
        color: #333;
    }
    .form-check-input:checked {
        background-color: #0B1061;
        border-color: #0B1061;
    }
    .col-md-4 {
        background-color: #f2f2f2;
        border-radius: 8px;
        padding: 10px 15px;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const stepperEditSettings = "{{ route('stepper.update_setings', ['id' => $member->id]) }}";
</script>
<script>

$(document).ready(function() 
{
    $('.theme-toggle').on('change', function() {
        let preferenceName = $(this).closest('div.col-md-4').find('label').text().trim();
        let isActive = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: "{{ route('save_user_preference') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                preference_name: preferenceName,
                is_active: isActive
            },
            success: function(res) {
                console.log(res.message);
            },
            error: function(err) {
                console.error('Error saving preference', err);
            }
        });
    });
});
</script>



