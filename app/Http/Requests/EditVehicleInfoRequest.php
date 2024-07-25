<?php

namespace App\Http\Requests;

use App\Models\Vehicle;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AlphaNumDashSpaceDot;
use App\Rules\AlphaNumSpace;
use Illuminate\Validation\Rule;

class EditVehicleInfoRequest extends FormRequest
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
    public function rules(Vehicle $vehicle): array
    {
        $yearNow = date('Y', strtotime('now'));

        return [
            'edit_mode' => 'bail|required|accepted',
            'vehicle_classification' => 'bail|required|exists:vehicle_classifications,id',
            'vehicle_make' => 'bail|required_if_accepted:show_make_list|exists:vehicle_makes,id',
            'new_vehicle_make' => 'bail|required_if_declined:show_make_list|alpha:ascii|min:2|max:50|unique:vehicle_makes,make',
            'show_make_list' => 'bail|required|boolean',
            'office_issued_to' => 'bail|required|exists:offices,id',
            'model' => ['bail', 'required', 'string', new AlphaNumDashSpaceDot],
            'year_model' => "bail|required|integer|min:1950|max:$yearNow",
            'plate_number' => [
                                'bail',
                                'required', 
                                'string', 
                                'min:1', 
                                'max:20', 
                                new AlphaNumSpace,
                                Rule::unique('vehicles', 'plate_number')->ignore($vehicle->id)
                            ]
        ];
    }
}
