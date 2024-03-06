<?php

namespace App\Http\Requests;

use App\Models\Topic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TopicCreateRequest extends FormRequest
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
            "memo" => [
                "nullable",
                "string",
                "max:255"
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
            "published_at" => [
                "nullable",
                "date",
            ],
            "status" => [
                "required",
                "in:published,draft"
            ],
        ];
    }
}
