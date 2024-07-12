<?php

namespace App\Http\Requests;

use App\Rules\AlphaDashSpaceDot;
use Illuminate\Foundation\Http\FormRequest;

class AddNewUserRequest extends FormRequest
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
            'name' => ['bail', 'required', 'string', 'min:3', 'max:100', new AlphaDashSpaceDot],
            'username' => 'bail|required|string|min:3|max:20|alpha_dash:ascii|unique:users,username',
            'password' => 'bail|required|string|min:4|max:15|confirmed',
            'office' => 'bail|required|exists:offices,id',
            'role' => 'bail|required|exists:roles,id'
        ];
    }
}
