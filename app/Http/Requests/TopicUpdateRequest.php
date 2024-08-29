<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TopicUpdateRequest extends FormRequest
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
        // dd($this->id);
        return [
            "id" => [
                "required",
                "exists:topics,id"
            ],
            "name" => [
                "required",
                "string",
                "max:60"
            ],
            "slug" => [
                "required",
                "string",
                Rule::unique('topics', "slug")->ignore($this->id, "id"),
                "alpha_dash",
                "max:128"
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
                Rule::requiredIf(function () {
                    return $this->status === 'published';
                    // Only required if status is "published"
                }),
                "date",
            ],
            "status" => [
                "required",
                "in:published,draft"
            ],
            //
        ];
    }
}
