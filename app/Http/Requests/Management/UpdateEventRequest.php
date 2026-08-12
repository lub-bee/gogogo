<?php

namespace App\Http\Requests\Management;

use App\Enums\EventType;
use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('event'));
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('events', 'slug')->ignore($this->route('event')),
            ],
            'type' => ['required', Rule::enum(EventType::class)],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'description_en' => ['nullable', 'string'],
            'description_ja' => ['nullable', 'string'],
            'cost' => ['nullable', 'integer', 'min:0'],
            'location_id' => ['nullable', 'exists:locations,id'],
            'topic_id' => ['nullable', 'exists:topics,id'],
        ];
    }
}
