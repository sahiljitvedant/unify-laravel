@extends('layouts.app')

@section('title', 'Add Member')

@section('content')
<form id="multiStepForm" class="p-4 bg-light rounded shadow" 
      style="max-width: 100%; width: 95%; margin: 0 auto;">

    <div class="progressbar d-flex justify-content-center align-items-center mb-4">
        <div class="circle active" data-step="1">1</div>
        <div class="line"></div>
        <div class="circle" data-step="2">2</div>
        <div class="line"></div>
        <div class="circle" data-step="3">3</div>
    </div>
    <!-- Step 1 -->
    <div class="step" data-step="1">
        <div class="row mb-3">
            <div class="col-12 col-md-3 text-center">
                <label class="form-label d-block mb-2">Upload Profile Image</label>
                <img id="previewImage" class="mt-2 img-thumbnail mb-2" style="max-height: 80px; display:block; margin: 0 auto;" src="{{ asset('assets/img/default.png') }}">
                <input type="file" class="form-control d-none" id="profileImage"  name="profile_image" accept="image/*">
                <button type="button" class="btn btn-primary rounded-pill" id="uploadButton">Upload Photo</button>
            </div>

            <div class="col-12 col-md-3 mb-3">
                <label class="form-label">{{ __('global.first_name') }}</label>
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="{{ __('global.first_name_placeholder') }}">
                <div class="text-danger error-message" data-error-for="first_name"></div>
            </div>

            <div class="col-12 col-md-3 mb-3">
                <label class="form-label">{{ __('global.middle_name') }}</label>
                <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="{{ __('global.middle_name_placeholder') }}">
                <div class="text-danger error-message" data-error-for="middle_name"></div>
            </div>

            <div class="col-12 col-md-3 mb-3">
                <label class="form-label">{{ __('global.last_name') }}</label>
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="{{ __('global.last_name_placeholder') }}">
                <div class="text-danger error-message" data-error-for="last_name"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">{{ __('global.dob') }}</label>
                <input type="date" class="form-control" name="dob" id="dob" placeholder="{{ __('global.dob_placeholder') }}">
                <div class="text-danger error-message" data-error-for="dob"></div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">{{ __('global.gender_label') }}</label>
                <select class="form-select" name="gender" id="gender">
                    <option value="" selected disabled>{{ __('global.gender_placeholder') }}</option>
                    <option value="male">{{ __('global.male') }}</option>
                    <option value="female">{{ __('global.female') }}</option>
                    <option value="other">{{ __('global.other') }}</option>
                </select>
                <div class="text-danger error-message" data-error-for="gender"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">{{ __('global.email_label') }}</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="{{ __('global.email_placeholder') }}">
                <div class="text-danger error-message" data-error-for="email"></div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">{{ __('global.mobile_label') }}</label>
                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="{{ __('global.mobile_placeholder') }}">
                <div class="text-danger error-message" data-error-for="mobile"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">{{ __('global.residence_address_label') }}</label>
                <input type="text" class="form-control" name="residence_address" id="residence_address" placeholder="{{ __('global.residence_address_placeholder') }}">
                <div class="text-danger error-message" data-error-for="residence_address"></div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">{{ __('global.residence_area_label') }}</label>
                <input type="text" class="form-control" name="residence_area" id="residence_area" placeholder="{{ __('global.residence_area_placeholder') }}">
                <div class="text-danger error-message" data-error-for="residence_area"></div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">{{ __('global.zipcode_label') }}</label>
                <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="{{ __('global.zipcode_placeholder') }}">
                <div class="text-danger error-message" data-error-for="zipcode"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">{{ __('global.city_label') }}</label>
                <select class="form-select" name="city" id="city">
                    <option selected disabled>{{ __('global.select_option') }}</option>
                    <option value="city1">City 1</option>
                    <option value="city2">City 2</option>
                    <option value="city3">City 3</option>
                </select>
                <div class="text-danger error-message" data-error-for="city"></div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">{{ __('global.state_label') }}</label>
                <select class="form-select" name="state" id="state">
                    <option selected disabled>{{ __('global.select_option') }}</option>
                    <option value="state1">State 1</option>
                    <option value="state2">State 2</option>
                    <option value="state3">State 3</option>
                </select>
                <div class="text-danger error-message" data-error-for="state"></div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">{{ __('global.country_label') }}</label>
                <select class="form-select" name="country" id="country">
                    <option selected disabled>{{ __('global.select_option') }}</option>
                    <option value="country1">Country 1</option>
                    <option value="country2">Country 2</option>
                    <option value="country3">Country 3</option>
                </select>
                <div class="text-danger error-message" data-error-for="country"></div>
            </div>
        </div>
    </div>

    <!-- Step 2 -->
    <div class="step d-none" data-step="2">
        <div class="row g-3">
            <div class="col-md-6 col-12">
                <label class="form-label">{{ __('global.membership_type_label') }}</label>
                <select class="form-select" name="membership_type" id="membership_type">
                    <option selected disabled>{{ __('global.select_option') }}</option>
                    <option value="basic">{{ __('global.basic') }}</option>
                    <option value="premium">{{ __('global.premium') }}</option>
                    <option value="vip">{{ __('global.vip') }}</option>
                </select>
                <div class="text-danger error-message" data-error-for="membership_type"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label">{{ __('global.joining_date_label') }}</label>
                <input type="date" class="form-control" name="joining_date" id="joining_date" placeholder="{{ __('global.joining_date_placeholder') }}">
                <div class="text-danger error-message" data-error-for="joining_date"></div>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-md-6 col-12">
                <label class="form-label">{{ __('global.expiry_date_label') }}</label>
                <input type="date" class="form-control" name="expiry_date" id="expiry_date" placeholder="{{ __('global.expiry_date_placeholder') }}">
                <div class="text-danger error-message" data-error-for="expiry_date"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label">{{ __('global.amount_paid_label') }}</label>
                <input type="number" class="form-control" name="amount_paid" id="amount_paid" placeholder="{{ __('global.amount_paid_placeholder') }}">
                <div class="text-danger error-message" data-error-for="amount_paid"></div>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-md-6 col-12">
                <label class="form-label">{{ __('global.payment_method_label') }}</label>
                <select class="form-select" name="payment_method" id="payment_method">
                    <option selected disabled>{{ __('global.select_option') }}</option>
                    <option value="cash">{{ __('global.cash') }}</option>
                    <option value="card">{{ __('global.card') }}</option>
                    <option value="upi">{{ __('global.upi') }}</option>
                </select>
                <div class="text-danger error-message" data-error-for="payment_method"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label">{{ __('global.trainer_assigned_label') }}</label>
                <select class="form-select" name="trainer_assigned" id="trainer_assigned">
                    <option selected disabled>{{ __('global.select_option') }}</option>
                    <option value="trainer1">{{ __('global.trainer1') }}</option>
                    <option value="trainer2">{{ __('global.trainer2') }}</option>
                    <option value="trainer3">{{ __('global.trainer3') }}</option>
                </select>
                <div class="text-danger error-message" data-error-for="trainer_assigned"></div>
            </div>
        </div>
    </div>

    <!-- Step 3 -->
    <div class="step d-none" data-step="3">
        <div class="row g-3">
            <div class="col-md-6 col-12">
                <label class="form-label">{{ __('global.fitness_goals_label') }}</label>
                <select class="form-select" name="fitness_goals" id="fitness_goals">
                    <option value="weight_loss">{{ __('global.weight_loss') }}</option>
                    <option value="muscle_gain">{{ __('global.muscle_gain') }}</option>
                    <option value="flexibility">{{ __('global.flexibility') }}</option>
                    <option value="general_fitness">{{ __('global.general_fitness') }}</option>
                </select>
                <div class="text-danger error-message" data-error-for="fitness_goals"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label">{{ __('global.preferred_workout_time_label') }}</label>
                <select class="form-select" name="preferred_workout_time" id="preferred_workout_time">
                    <option selected disabled>{{ __('global.select_option') }}</option>
                    <option value="morning">{{ __('global.morning') }}</option>
                    <option value="afternoon">{{ __('global.afternoon') }}</option>
                    <option value="evening">{{ __('global.evening') }}</option>
                </select>
                <div class="text-danger error-message" data-error-for="preferred_workout_time"></div>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-6 col-md-3">
                <label class="form-label">{{ __('global.height_ft_label') }}</label>
                <select class="form-select" name="height_ft" id="height_ft">
                    <option selected disabled>{{ __('global.select_option') }}</option>
                    @for ($i = 3; $i <= 7; $i++)
                        <option value="{{ $i }}">{{ $i }} {{ __('global.ft') }}</option>
                    @endfor
                </select>
                <div class="text-danger error-message" data-error-for="height_ft"></div>
            </div>

            <div class="col-6 col-md-3">
                <label class="form-label">{{ __('global.height_in_label') }}</label>
                <select class="form-select" name="height_in" id="height_in">
                    <option selected disabled>{{ __('global.select_option') }}</option>
                    @for ($i = 0; $i < 12; $i++)
                        <option value="{{ $i }}">{{ $i }} {{ __('global.inches') }}</option>
                    @endfor
                </select>
                <div class="text-danger error-message" data-error-for="height_in"></div>
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label">{{ __('global.current_weight_label') }}</label>
                <input type="number" class="form-control" name="current_weight" id="current_weight" placeholder="{{ __('global.current_weight_placeholder') }}">
                <div class="text-danger error-message" data-error-for="current_weight"></div>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-12">
                <label class="form-label">{{ __('global.additional_notes_label') }}</label>
                <textarea class="form-control" name="additional_notes" id="additional_notes" placeholder="{{ __('global.additional_notes_placeholder') }}" rows="3"></textarea>
                <div class="text-danger error-message" data-error-for="additional_notes"></div>
            </div>
        </div>

        <div class="text-center mt-3">
          
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="d-flex justify-content-between mt-3">
        <!-- Prev Button (left) -->
        <button type="button" id="prevBtn" class="btn btn-secondary rounded-pill">Prev</button>

        <!-- Next/Submit Button (right) -->
        <button type="button" id="nextBtn" class="btn btn-secondary rounded-pill">Next</button>

        <button type="submit" id="submitBtn" class="btn btn-success rounded-pill">Submit</button>
    </div>
</form>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const stepperSubmitUrl = "{{ route('stepper.submit') }}";
</script>

<script src="{{ asset('assets/js/gym_package/add_package.js') }}"></script>
<script>
    function showStep(step) 
    {
        $('.step').addClass('d-none');
        $(`.step[data-step="${step}"]`).removeClass('d-none');

        // Prev button
        if (step === 1) {
            $('#prevBtn').css('visibility', 'hidden');
        } else {
            $('#prevBtn').css('visibility', 'visible');
        }

        // Next / Submit button
        if (step === totalSteps) {
            $('#nextBtn').hide();
            $('#submitBtn').show();
        } else {
            $('#nextBtn').show();
            $('#submitBtn').hide();
        }

        // 🔹 Update stepper indicators
        $('.circle').removeClass('active completed');
        $('.line').removeClass('active');

        $('.circle').each(function () {
            const s = $(this).data('step');
            if (s < step) {
                $(this).addClass('completed');
                $(this).next('.line').addClass('active');
            } else if (s === step) {
                $(this).addClass('active');
            }
        });
    }
</script>
@endsection

<style>
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
    background: #0d6efd;  /* Bootstrap primary blue */
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
</style>