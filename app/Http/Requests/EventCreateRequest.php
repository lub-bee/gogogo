<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventCreateRequest extends FormRequest
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
            "start_at" => [
                "required",
                "date"
            ],
            "end_at" => [
                "nullable",
                "date",
            ],
            "description_en" => [
                "nullable",
                "string",
                "max:20000"
            ],
            "description_ja" => [
                "nullable",
                "string",
                "max:20000"
            ],
            "cost" => [
                "nullable",
                "numeric",
                "max:100000"
            ],
        ];
    }
}
