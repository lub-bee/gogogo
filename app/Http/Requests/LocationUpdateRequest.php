<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationUpdateRequest extends FormRequest
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
                "max:255"
            ],
            "slug" => [
                "required",
                "string",
                "unique:event,slug",
                "alpha_dash",
                "max:128"
            ],
            "description_en" => [
                "nullable",
                "string",
                "max:2000"
            ],
            "description_ja" => [
                "nullable",
                "string",
                "max:2000"
            ],
            "gps_long" => [
                "nullable",
                "string",
                "max:15"
            ],
            "gps_lat" => [
                "nullable",
                "string",
                "max:15"
            ],
            "website_url" => [
                "nullable",
                "string",
                "max:200"
            ],
            //TO CHECK - Default value vs Nullable.
            "cost" => [
                "nullable",
                "string",
                "max:100000"
            ]
            //
        ];
    }
}
