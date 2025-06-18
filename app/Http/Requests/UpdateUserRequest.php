<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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

        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required','email','max:255',
                Rule::unique('users')->ignore(auth()->user()->id)
            ]
        ];

        if ($this->filled('password'))
        {
            $rules['password'] = 'nullable|string|min:8';
            $rules['passwordConfirm'] = ['required', 'same:password'];
        }

        return $rules;
    }
}
