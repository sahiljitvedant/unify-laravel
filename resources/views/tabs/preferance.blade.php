<form id="formSettings" class="">
    <div class="container mt-3">
        <div class="row g-3 text-center">

        @php
            $preferencesList = [
                'Profile Pic' => 'image',
                'Name'        => 'name',
                'Email'       => 'email',
                'Mobile'      => 'mobile',
                'Preferred Time' => 'preferred_time',
                'Date of Birth'  => 'dob',
                'Address'        => 'address',
                'Goal'           => 'goal',
            ];

            // Map user preferences for easy lookup
            $userPrefMap = [];
            foreach ($userPreferences as $pref) {
                $userPrefMap[$pref->preference->name] = $pref->is_active;
            }
        @endphp

        @foreach ($preferencesList as $label => $id)
            <div class="col-12 col-md-4 d-flex align-items-center justify-content-between px-4">
                <label class="form-label mb-0">{{ $label }}</label>
                <div class="form-check form-switch">
                    <input class="form-check-input theme-toggle" 
                        type="checkbox" 
                        id="{{ $id }}" 
                        {{ isset($userPrefMap[$label]) ? ($userPrefMap[$label] ? 'checked' : '') : 'checked' }}>
                </div>
            </div>
        @endforeach

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
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Preference saved successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
            },
            error: function(err) {
                console.error('Error saving preference', err);
                $toggle.prop('checked', !$toggle.is(':checked'));

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to save preference.',
                });
            }
        });
    });
});
</script>



