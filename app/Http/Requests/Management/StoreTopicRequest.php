<?php

namespace App\Http\Requests\Management;

use App\Models\Topic;
use Illuminate\Foundation\Http\FormRequest;

class StoreTopicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Topic::class);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'memo' => ['nullable', 'string', 'max:1000'],
            'description_en' => ['nullable', 'string'],
            'description_ja' => ['nullable', 'string'],
        ];
    }
}
