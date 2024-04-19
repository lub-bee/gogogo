<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            "name" => [
                "required",
                "string",
                "max:60"
            ],
            "email" => [
                "required",
                "string",
                "email",
                Rule::unique('users', 'email')->ignore($this->user_id),
            ],
            // "password" => [
            //     "required",
            //     "current_password",
            // ],
            "rank" => [
                "required",
                "string",
                Rule::in(User::RANKS)
            ],
        ];
    }
}
