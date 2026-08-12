<?php

namespace App\Http\Requests\Management;

use App\Enums\EventType;
use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Event::class);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
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
