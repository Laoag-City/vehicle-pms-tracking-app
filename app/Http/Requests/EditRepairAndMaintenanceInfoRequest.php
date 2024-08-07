<?php

namespace App\Http\Requests;

use App\Models\RepairAndMaintenance;
use Illuminate\Foundation\Http\FormRequest;

class EditRepairAndMaintenanceInfoRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'component' => 'bail|required|exists:components,id',
            'description' => 'bail|required|string|min:3|max:120',
            'type' => 'bail|required|in:' . implode(',', array_keys(RepairAndMaintenance::$isRepairValues)),
            'estimated_cost' => 'bail|required|numeric|regex:/^[0-9]{1,8}+(\.[0-9]{1,2})?$/|between:1,99999999',
            'date_encoded' => 'bail|required|date|before_or_equal:now'
        ];
    }
}
