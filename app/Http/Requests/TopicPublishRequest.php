<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicPublishRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // todo : add the permission here later
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
            // -Only used for PUBLISH
            // -Except for id, no param needed
        ];
    }
}
