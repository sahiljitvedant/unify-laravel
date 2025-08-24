<div class="step" data-step="1">
    <div class="row mb-3">
        <div class="col-12 col-md-3 text-center">
            <label class="form-label d-block mb-2">Upload Profile Image</label>
            <img id="previewImage" 
     class="mt-2 img-thumbnail mb-2" 
     style="max-height: 80px; display:block; margin: 0 auto;" 
     src="{{ $member->profile_image ? asset($member->profile_image) : asset('assets/img/default.png') }}">

            <input type="file" class="form-control d-none" id="profileImage" name="profile_image" accept="image/*">
            <button type="button" class="btn btn-primary rounded-pill" id="uploadButton">Upload Photo</button>
        </div>

        <div class="col-12 col-md-3 mb-3">
            <label class="form-label">{{ __('global.first_name') }}</label>
            <input type="text" class="form-control" 
                   name="first_name" id="first_name" 
                   placeholder="{{ __('global.first_name_placeholder') }}"
                   value="{{ old('first_name', $member->first_name) }}">
            <div class="text-danger error-message" data-error-for="first_name"></div>
        </div>

        <div class="col-12 col-md-3 mb-3">
            <label class="form-label">{{ __('global.middle_name') }}</label>
            <input type="text" class="form-control" 
                   name="middle_name" id="middle_name" 
                   placeholder="{{ __('global.middle_name_placeholder') }}"
                   value="{{ old('middle_name', $member->middle_name) }}">
            <div class="text-danger error-message" data-error-for="middle_name"></div>
        </div>

        <div class="col-12 col-md-3 mb-3">
            <label class="form-label">{{ __('global.last_name') }}</label>
            <input type="text" class="form-control" 
                   name="last_name" id="last_name" 
                   placeholder="{{ __('global.last_name_placeholder') }}"
                   value="{{ old('last_name', $member->last_name) }}">
            <div class="text-danger error-message" data-error-for="last_name"></div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-md-6 mb-3">
            <label class="form-label">{{ __('global.dob') }}</label>
            <input type="date" class="form-control" 
                   name="dob" id="dob" 
                   value="{{ old('dob', $member->dob) }}">
            <div class="text-danger error-message" data-error-for="dob"></div>
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label class="form-label">{{ __('global.gender_label') }}</label>
            <select class="form-select" name="gender" id="gender">
                <option value="" disabled>{{ __('global.gender_placeholder') }}</option>
                <option value="male"   {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>{{ __('global.male') }}</option>
                <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>{{ __('global.female') }}</option>
                <option value="other"  {{ old('gender', $member->gender) == 'other' ? 'selected' : '' }}>{{ __('global.other') }}</option>
            </select>
            <div class="text-danger error-message" data-error-for="gender"></div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-md-6 mb-3">
            <label class="form-label">{{ __('global.email_label') }}</label>
            <input type="email" class="form-control" 
                   name="email" id="email" 
                   placeholder="{{ __('global.email_placeholder') }}"
                   value="{{ old('email', $member->email) }}">
            <div class="text-danger error-message" data-error-for="email"></div>
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label class="form-label">{{ __('global.mobile_label') }}</label>
            <input type="text" class="form-control" 
                   name="mobile" id="mobile" 
                   placeholder="{{ __('global.mobile_placeholder') }}"
                   value="{{ old('mobile', $member->mobile) }}">
            <div class="text-danger error-message" data-error-for="mobile"></div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-md-4 mb-3">
            <label class="form-label">{{ __('global.residence_address_label') }}</label>
            <input type="text" class="form-control" 
                   name="residence_address" id="residence_address" 
                   placeholder="{{ __('global.residence_address_placeholder') }}"
                   value="{{ old('residence_address', $member->residence_address) }}">
            <div class="text-danger error-message" data-error-for="residence_address"></div>
        </div>

        <div class="col-12 col-md-4 mb-3">
            <label class="form-label">{{ __('global.residence_area_label') }}</label>
            <input type="text" class="form-control" 
                   name="residence_area" id="residence_area" 
                   placeholder="{{ __('global.residence_area_placeholder') }}"
                   value="{{ old('residence_area', $member->residence_area) }}">
            <div class="text-danger error-message" data-error-for="residence_area"></div>
        </div>

        <div class="col-12 col-md-4 mb-3">
            <label class="form-label">{{ __('global.zipcode_label') }}</label>
            <input type="text" class="form-control" 
                   name="zipcode" id="zipcode" 
                   placeholder="{{ __('global.zipcode_placeholder') }}"
                   value="{{ old('zipcode', $member->zipcode) }}">
            <div class="text-danger error-message" data-error-for="zipcode"></div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-md-4 mb-3">
            <label class="form-label">{{ __('global.city_label') }}</label>
            <select class="form-select" name="city" id="city">
                <option disabled>{{ __('global.select_option') }}</option>
                <option value="city1" {{ old('city', $member->city) == 'city1' ? 'selected' : '' }}>City 1</option>
                <option value="city2" {{ old('city', $member->city) == 'city2' ? 'selected' : '' }}>City 2</option>
                <option value="city3" {{ old('city', $member->city) == 'city3' ? 'selected' : '' }}>City 3</option>
            </select>
            <div class="text-danger error-message" data-error-for="city"></div>
        </div>

        <div class="col-12 col-md-4 mb-3">
            <label class="form-label">{{ __('global.state_label') }}</label>
            <select class="form-select" name="state" id="state">
                <option disabled>{{ __('global.select_option') }}</option>
                <option value="state1" {{ old('state', $member->state) == 'state1' ? 'selected' : '' }}>State 1</option>
                <option value="state2" {{ old('state', $member->state) == 'state2' ? 'selected' : '' }}>State 2</option>
                <option value="state3" {{ old('state', $member->state) == 'state3' ? 'selected' : '' }}>State 3</option>
            </select>
            <div class="text-danger error-message" data-error-for="state"></div>
        </div>

        <div class="col-12 col-md-4 mb-3">
            <label class="form-label">{{ __('global.country_label') }}</label>
            <select class="form-select" name="country" id="country">
                <option disabled>{{ __('global.select_option') }}</option>
                <option value="country1" {{ old('country', $member->country) == 'country1' ? 'selected' : '' }}>Country 1</option>
                <option value="country2" {{ old('country', $member->country) == 'country2' ? 'selected' : '' }}>Country 2</option>
                <option value="country3" {{ old('country', $member->country) == 'country3' ? 'selected' : '' }}>Country 3</option>
            </select>
            <div class="text-danger error-message" data-error-for="country"></div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   
    // Profile Image Preview JS:-
$(document).ready(function () 
{
    // alert('hi');
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
</script>