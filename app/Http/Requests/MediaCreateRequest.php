<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaCreateRequest extends FormRequest
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
            "picture" => [
                "required",
                "image",
                "mimes:png,jpg,jpeg,svg",
                "max:5000",
            ],
            "description_en" => [
                "nullable",
                "string",
                "max:2000",
            ],
            "description_ja" => [
                "nullable",
                "string",
                "max:2000",
            ],
        ];
    }
}
