<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventUpdateRequest extends FormRequest
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
                "exists:events,id"
            ],
            "name" => [
                "required",
                "string",
                "max:255"
            ],
            "slug" => [
                "required",
                "string",
                Rule::unique('events', "slug")->ignore($this->id, "id"),
                "alpha_dash",
                "max:128"
            ],
            "start_at" => [
                "required",
                "date"
            ],
            "end_at" => [
                "nullable",
                "date"
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
                "string",
                "max:128"
            ],
            "published_at" => [
                "nullable",
                Rule::requiredIf(function () {
                    return $this->status === 'published';
                }),
                "date",
            ],
            "topic_id" => [
                "nullable",
                "exists:topics,id"
            ],
            "location_id" => [
                "nullable",
                "exists:locations,id"
            ],
            "status" => [
                "required",
                "in:published,draft"
            ],
        ];
    }
}
