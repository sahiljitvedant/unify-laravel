<form id="multiStepForm" class="">
    <div class="step" data-step="1">
        <div class="row mb-1">
            <div class="col-12 col-md-3 text-center">
                <label class="form-label d-block mb-2">Upload Profile Image</label>

                <img id="previewImage"
                    class="mt-2 img-thumbnail mb-2"
                    style="max-height: 80px; display:block; margin: 0 auto; border-radius:10px;"
                    src="{{ $member->profile_image ? asset($member->profile_image) : asset('assets/img/default.png') }}">

                <button type="button" 
                        class="profilebtn" 
                        id="uploadButton" 
                        data-type="profile_image">
                    Upload Photo
                </button>
            </div>
            <div class="col-12 col-md-3 mb-3">
                <label class="form-label required">{{ __('global.first_name') }}</label>
                <input type="text" class="form-control" 
                    name="first_name" id="first_name" 
                    placeholder="{{ __('global.first_name_placeholder') }}"
                    value="{{ old('first_name', $member->first_name) }}" required>
                <div class="text-danger error-message" data-error-for="first_name" ></div>
            </div>

            <div class="col-12 col-md-3 mb-3">
                <label class="form-label required">{{ __('global.middle_name') }}</label>
                <input type="text" class="form-control" 
                    name="middle_name" id="middle_name" 
                    placeholder="{{ __('global.middle_name_placeholder') }}"
                    value="{{ old('middle_name', $member->middle_name) }}" required>
                <div class="text-danger error-message" data-error-for="middle_name" ></div>
            </div>

            <div class="col-12 col-md-3 mb-3">
                <label class="form-label required">{{ __('global.last_name') }}</label>
                <input type="text" class="form-control" 
                    name="last_name" id="last_name" 
                    placeholder="{{ __('global.last_name_placeholder') }}"
                    value="{{ old('last_name', $member->last_name) }}" required>
                <div class="text-danger error-message" data-error-for="last_name"></div>
            </div>
        </div>

        <div class="row mb-1">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label required">{{ __('global.dob') }}</label>
                <input type="date" class="form-control" 
                    name="dob" id="dob" 
                    value="{{ old('dob', $member->dob) }}" required>
                <div class="text-danger error-message" data-error-for="dob"></div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label class="form-label required">{{ __('global.gender_label') }}</label>
                <select class="form-control" name="gender" id="gender">
                    <option value="" disabled>{{ __('global.gender_placeholder') }}</option>
                    @foreach (config('app.gender_options') as $id => $gender)
                        <option value="{{ $id }}" 
                            {{ (isset($user) && $user->gender == $id) ? 'selected' : '' }}>
                            {{ __('global.' . $gender) }}
                        </option>
                    @endforeach
                </select>
                <div class="text-danger error-message" data-error-for="gender"></div>
            </div>

        </div>

        <div class="row mb-1">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label required">{{ __('global.email_label') }}</label>
                <input type="email" class="form-control" 
                    name="email" id="email" 
                    placeholder="{{ __('global.email_placeholder') }}"
                    value="{{ old('email', $member->email) }}" required>
                <div class="text-danger error-message" data-error-for="email"></div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label class="form-label required">{{ __('global.mobile_label') }}</label>
                <input type="text" class="form-control" 
                    name="mobile" id="mobile" 
                    placeholder="{{ __('global.mobile_placeholder') }}"
                    value="{{ old('mobile', $member->mobile) }}" required>
                <div class="text-danger error-message" data-error-for="mobile"></div>
            </div>
        </div>

        <div class="row mb-1">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label required">{{ __('global.residence_address_label') }}</label>
                <input type="text" class="form-control" 
                    name="residence_address" id="residence_address" 
                    placeholder="{{ __('global.residence_address_placeholder') }}"
                    value="{{ old('residence_address', $member->residence_address) }}" required>
                <div class="text-danger error-message" data-error-for="residence_address"></div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label class="form-label required">{{ __('global.residence_area_label') }}</label>
                <input type="text" class="form-control" 
                    name="residence_area" id="residence_area" 
                    placeholder="{{ __('global.residence_area_placeholder') }}"
                    value="{{ old('residence_area', $member->residence_area) }}" required>
                <div class="text-danger error-message" data-error-for="residence_area"></div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label class="form-label required">{{ __('global.zipcode_label') }}</label>
                <input type="text" class="form-control" 
                    name="zipcode" id="zipcode" 
                    placeholder="{{ __('global.zipcode_placeholder') }}"
                    value="{{ old('zipcode', $member->zipcode) }}" required>
                <div class="text-danger error-message" data-error-for="zipcode"></div>
            </div>
        </div>

        <div class="row mb-1">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label required">{{ __('global.city_label') }}</label>
                <select class="form-control" name="city" id="city">
                    <option disabled>{{ __('global.select_option') }}</option>
                    <option value="city1" {{ old('city', $member->city) == 'city1' ? 'selected' : '' }}>City 1</option>
                    <option value="city2" {{ old('city', $member->city) == 'city2' ? 'selected' : '' }}>City 2</option>
                    <option value="city3" {{ old('city', $member->city) == 'city3' ? 'selected' : '' }}>City 3</option>
                </select>
                <div class="text-danger error-message" data-error-for="city"></div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label class="form-label required">{{ __('global.state_label') }}</label>
                <select class="form-control" name="state" id="state">
                    <option disabled>{{ __('global.select_option') }}</option>
                    <option value="state1" {{ old('state', $member->state) == 'state1' ? 'selected' : '' }}>State 1</option>
                    <option value="state2" {{ old('state', $member->state) == 'state2' ? 'selected' : '' }}>State 2</option>
                    <option value="state3" {{ old('state', $member->state) == 'state3' ? 'selected' : '' }}>State 3</option>
                </select>
                <div class="text-danger error-message" data-error-for="state"></div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label class="form-label required">{{ __('global.country_label') }}</label>
                <select class="form-control" name="country" id="country">
                    <option disabled>{{ __('global.select_option') }}</option>
                    <option value="country1" {{ old('country', $member->country) == 'country1' ? 'selected' : '' }}>Country 1</option>
                    <option value="country2" {{ old('country', $member->country) == 'country2' ? 'selected' : '' }}>Country 2</option>
                    <option value="country3" {{ old('country', $member->country) == 'country3' ? 'selected' : '' }}>Country 3</option>
                </select>
                <div class="text-danger error-message" data-error-for="country"></div>
            </div>
        </div>
    </div>
    <div class="text-end mt-4">
        <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
    </div>
</form>
<div class="modal fade" id="cropImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex flex-column">

                <!-- Image Preview -->
                <div class="text-center mb-3" id="imagePreviewContainer" style="display:none;">
                    <img id="imageToCrop" style="max-width: 100%; border-radius:10px;">
                </div>

                <!-- Progress Bar -->
                <div class="progress mb-3" id="uploadProgress" style="display:none;">
                    <div class="progress-bar" role="progressbar" style="width:0%">0%</div>
                </div>

                <!-- Controls -->
                <div class="d-flex justify-content-center gap-2 mt-auto">
                    <input type="file" id="browseImage" accept="image/*" class="d-none">
                    <button type="button" id="browseBtn" class="btn btn-secondary">Browse</button>
                    <button type="button" id="uploadCropped" class="btn btn-primary" disabled>Upload</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const stepperEditUrl = "{{ route('stepper.update_profile', ['id' => $member->id]) }}";
const uploadUrl = "{{ route('profile.cropUpload') }}";
</script>
<script src="{{ asset('assets/js/gym_package/edit_package.js') }}"></script>
<script src="{{ asset('assets/js/global/image_crop.js') }}"></script>
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
$('#multiStepForm').on('submit', function(e) {
    let firstEmpty = $(this).find('input[required], select[required], textarea[required]').filter(function() {
        return !$(this).val();
    }).first();

    if (firstEmpty.length) {
        $('html, body').animate({
            scrollTop: firstEmpty.offset().top - 100
        }, 600);

        firstEmpty.focus();

        // Optional: highlight the empty field
        firstEmpty.addClass('border border-danger');
        setTimeout(() => firstEmpty.removeClass('border border-danger'), 3000);

        e.preventDefault();
    }
});


</script>
<style>
    #submitBtn
    {
        background: #0b1061;
        color: #fff;
        border: 5px solid #0b1061 !important;
        border-radius: 30px;
        font-size: 12px;
        padding: 5px;
    }
    .profilebtn{
        font-size: 12px !important;
        background: #0b1061;
        color: #fff;
        border: 5px solid #0b1061 !important;
        border-radius: 30px
    }
    .progressbar {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #ddd;
        color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    .circle.active {
        background: #0b1061;  /* Bootstrap primary blue */
        color: #fff;
    }
    .circle.completed {
        background: #28a745; /* green */
        color: #fff;
    }
    .line {
        flex: 1;
        height: 4px;
        background: #ddd;
    }
    .line.active {
        background: #28a745; /* green */
    }

    /* MOBILE FIXS */
    @media (max-width: 1023px) 
    {
        /* 1. Force labels to left */
        .form-label {
            text-align: left !important;
            display: block; /* make sure block */
        }

        /* 2. Reduce vertical spacing between rows */
        .row.mb-3 {
            margin-bottom: 0.5rem !important;
        }

        /* Reduce spacing inside columns */
        .col-12.mb-3,
        .col-12.col-md-3.mb-3,
        .col-12.col-md-4.mb-3,
        .col-12.col-md-6.mb-3 {
            margin-bottom: 0.5rem !important;
        }

        /* 3. Profile image column alignment */
        .col-12.col-md-3.text-center {
            text-align: left !important; /* left align for image & upload */
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        #previewImage {
            margin: 0 0 5px 0 !important;
            max-height: 60px;
        }

        .profilebtn {
            margin-top: 5px !important;
            align-self: flex-start; /* keep button left */
        }

        /* 4. Optional: smaller input padding */
        .form-control {
            padding: 0.35rem 0.5rem;
            font-size: 10px;
        }
        .form-label
        {
            font-size: 11px!important;
        }
        .error-message{
            font-size: 10px!important;
            text-align: left !important;
            display: block; /* make sure block */
        }
        .profilebtn {
            font-size: 12px !important;
            padding: 3px 10px !important;
            border-radius: 15px !important;
            border: 2px solid #0b1061 !important;
            margin-top: 5px !important;
            align-self: flex-start;
        }
    
    }


</style>