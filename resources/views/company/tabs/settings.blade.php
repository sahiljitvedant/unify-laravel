{{--<div class="step " data-step="3">
    <div class="row g-3">
        <div class="col-md-6 col-12">
            <label class="form-label">{{ __('global.fitness_goals_label') }}</label>
            <select class="form-select" name="fitness_goals" id="fitness_goals">
                <option value="weight_loss" {{ old('fitness_goals', $member->fitness_goals ?? '') == 'weight_loss' ? 'selected' : '' }}>
                    {{ __('global.weight_loss') }}
                </option>
                <option value="muscle_gain" {{ old('fitness_goals', $member->fitness_goals ?? '') == 'muscle_gain' ? 'selected' : '' }}>
                    {{ __('global.muscle_gain') }}
                </option>
                <option value="flexibility" {{ old('fitness_goals', $member->fitness_goals ?? '') == 'flexibility' ? 'selected' : '' }}>
                    {{ __('global.flexibility') }}
                </option>
                <option value="general_fitness" {{ old('fitness_goals', $member->fitness_goals ?? '') == 'general_fitness' ? 'selected' : '' }}>
                    {{ __('global.general_fitness') }}
                </option>
            </select>
            <div class="text-danger error-message" data-error-for="fitness_goals"></div>
        </div>

        <div class="col-md-6 col-12">
            <label class="form-label">{{ __('global.preferred_workout_time_label') }}</label>
            <select class="form-select" name="preferred_workout_time" id="preferred_workout_time">
                <option disabled {{ old('preferred_workout_time', $member->preferred_workout_time ?? '') == '' ? 'selected' : '' }}>
                    {{ __('global.select_option') }}
                </option>
                <option value="morning" {{ old('preferred_workout_time', $member->preferred_workout_time ?? '') == 'morning' ? 'selected' : '' }}>
                    {{ __('global.morning') }}
                </option>
                <option value="afternoon" {{ old('preferred_workout_time', $member->preferred_workout_time ?? '') == 'afternoon' ? 'selected' : '' }}>
                    {{ __('global.afternoon') }}
                </option>
                <option value="evening" {{ old('preferred_workout_time', $member->preferred_workout_time ?? '') == 'evening' ? 'selected' : '' }}>
                    {{ __('global.evening') }}
                </option>
            </select>
            <div class="text-danger error-message" data-error-for="preferred_workout_time"></div>
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-6 col-md-3">
            <label class="form-label">{{ __('global.height_ft_label') }}</label>
            <select class="form-select" name="height_ft" id="height_ft">
                <option disabled {{ old('height_ft', $member->height_ft ?? '') == '' ? 'selected' : '' }}>
                    {{ __('global.select_option') }}
                </option>
                @for ($i = 3; $i <= 7; $i++)
                    <option value="{{ $i }}" {{ old('height_ft', $member->height_ft ?? '') == $i ? 'selected' : '' }}>
                        {{ $i }} {{ __('global.ft') }}
                    </option>
                @endfor
            </select>
            <div class="text-danger error-message" data-error-for="height_ft"></div>
        </div>

        <div class="col-6 col-md-3">
            <label class="form-label">{{ __('global.height_in_label') }}</label>
            <select class="form-select" name="height_in" id="height_in">
                <option disabled {{ old('height_in', $member->height_in ?? '') == '' ? 'selected' : '' }}>
                    {{ __('global.select_option') }}
                </option>
                @for ($i = 0; $i < 12; $i++)
                    <option value="{{ $i }}" {{ old('height_in', $member->height_in ?? '') == $i ? 'selected' : '' }}>
                        {{ $i }} {{ __('global.inches') }}
                    </option>
                @endfor
            </select>
            <div class="text-danger error-message" data-error-for="height_in"></div>
        </div>

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

    <div class="text-center mt-3">
        <!-- Buttons come here -->
    </div>
</div>--}}
