<?php

namespace App\Http\Requests\Management;

use App\Models\Topic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTopicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('topic'));
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('topics', 'slug')->ignore($this->route('topic')),
            ],
            'memo' => ['nullable', 'string', 'max:1000'],
            'description_en' => ['nullable', 'string'],
            'description_ja' => ['nullable', 'string'],
        ];
    }
}
