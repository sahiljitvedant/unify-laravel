<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainerStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'trainer_name' => 'required|string|max:255|unique:tbl_trainer,trainer_name',
            'mobile_number' => 'required|digits:10|unique:tbl_trainer,mobile_number',
            'joining_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:joining_date',
            'is_active' => 'required|boolean',
        ];
    }
    

    public function messages()
    {
        return 
        [
            // Required
            'trainer_name.required' => 'Trainer name is mandatory',
            'mobile_number.required' => 'Mobile number is mandatory',
            'joining_date.required' => 'Joining date is mandatory',
            'is_active.required' => 'Status is required',
    
            // Unique Validation
            'trainer_name.unique' => 'Trainer name must be unique',
            'mobile_number.unique' => 'Mobile number must be unique',
    
            // Date Validation
            'expiry_date.after' => 'Expiry date must be greater than joining date',
        ];
    }
}
