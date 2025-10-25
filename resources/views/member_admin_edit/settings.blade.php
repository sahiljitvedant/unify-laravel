<form id="formSettings" class="">
    <div class="step" data-step="3">
        <div class="row g-3">
            <!-- Fitness Goals -->
            <div class="col-md-6 col-12">
                <label class="form-label">{{ __('global.fitness_goals_label') }}</label>
                <select class="form-control" name="fitness_goals" id="fitness_goals" >
                    <option value="" disabled {{ empty($member->fitness_goals) ? 'selected' : '' }}>
                        {{ __('global.select_option') }}
                    </option>
                    @foreach(config('app.fitness_goals', []) as $key => $value)
                        <option value="{{ $value }}" {{ old('fitness_goals', $member->fitness_goals ?? '') == $value ? 'selected' : '' }}>
                            {{ __('global.' . $value) }}
                        </option>
                    @endforeach
                </select>
                <div class="text-danger error-message" data-error-for="fitness_goals"></div>
            </div>


            <!-- Preferred Workout Time -->
            <div class="col-md-6 col-12">
                <label class="form-label">{{ __('global.preferred_workout_time_label') }}</label>
                <select class="form-control" name="preferred_workout_time" id="preferred_workout_time">
                    <option value="" disabled {{ old('preferred_workout_time', $member->preferred_workout_time ?? '') == '' ? 'selected' : '' }}>
                        {{ __('global.select_option') }}
                    </option>
                    @foreach(config('app.preferred_workout_time', []) as $key => $value)
                        <option value="{{ $value }}" {{ old('preferred_workout_time', $member->preferred_workout_time ?? '') == $value ? 'selected' : '' }}>
                            {{ __('global.' . $value) }}
                        </option>
                    @endforeach

                </select>
                <div class="text-danger error-message" data-error-for="preferred_workout_time"></div>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <!-- Height (ft) -->
            <!-- <div class="col-6 col-md-3">
                <label class="form-label">{{ __('global.height_ft_label') }}</label>
                <select class="form-select" name="height_ft" id="height_ft">
                    <option value="" disabled {{ old('height_ft', $member->height_ft ?? '') == '' ? 'selected' : '' }}>
                        {{ __('global.select_option') }}
                    </option>
                    @foreach(config('app.height_ft', []) as $key => $value)
                        <option value="{{ $value }}" {{ old('height_ft', $member->height_ft ?? '') == $value ? 'selected' : '' }}>
                            {{ $value }} {{ __('global.ft') }}
                        </option>
                    @endforeach

                </select>
                <div class="text-danger error-message" data-error-for="height_ft"></div>
            </div> -->

            <!-- Height (inches) -->
            <!-- <div class="col-6 col-md-3">
                <label class="form-label">{{ __('global.height_in_label') }}</label>
                <select class="form-select" name="height_in" id="height_in">
                    <option value="" disabled {{ old('height_in', $member->height_in ?? '') == '' ? 'selected' : '' }}>
                        {{ __('global.select_option') }}
                    </option>
               
                    @foreach(config('app.height_in', []) as $key => $value)
                        <option value="{{ $value }}" {{ old('height_in', $member->height_in ?? '') == $value ? 'selected' : '' }}>
                            {{ $value }} {{ __('global.inches') }}
                        </option>
                    @endforeach
                </select>
                <div class="text-danger error-message" data-error-for="height_in"></div>
            </div> -->

            <!-- Current Weight -->
            <div class="col-12 col-md-6">
                <label class="form-label">{{ __('global.current_weight_label') }}</label>
                <input type="number" class="form-control" 
                       name="current_weight" 
                       id="current_weight" 
                       placeholder="{{ __('global.current_weight_placeholder') }}"
                       value="{{ old('current_weight', $member->current_weight ?? '') }}">
                <div class="text-danger error-message" data-error-for="current_weight"></div>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <!-- Additional Notes -->
            <div class="col-12">
                <label class="form-label">{{ __('global.additional_notes_label') }}</label>
                <textarea class="form-control" 
                          name="additional_notes" 
                          id="additional_notes" 
                          placeholder="{{ __('global.additional_notes_placeholder') }}" 
                          rows="3">{{ old('additional_notes', $member->additional_notes ?? '') }}</textarea>
                <div class="text-danger error-message" data-error-for="additional_notes"></div>
            </div>
        </div>
    </div>

    <div class="text-end mt-4">
        <button type="submit" class="btn" id="profiesubmitBtn">Submit</button>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const stepperEditSettings = "{{ route('stepper.update_setings', ['id' => $member->id]) }}";
</script>
<script src="{{ asset('assets/js/gym_package/edit_member_setings.js') }}"></script>

<style>
     #profiesubmitBtn
    {
        background: #0b1061;
        color: #fff;
        border: 5px solid #0b1061 !important;
        border-radius: 30px;
        font-size: 12px;
        padding: 5px;
    }
</style>