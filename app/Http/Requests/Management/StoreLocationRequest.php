<?php

namespace App\Http\Requests\Management;

use App\Models\Location;
use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Location::class);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description_en' => ['nullable', 'string'],
            'description_ja' => ['nullable', 'string'],
            'gps_lat' => ['nullable', 'numeric', 'between:-90,90'],
            'gps_lng' => ['nullable', 'numeric', 'between:-180,180'],
            'website_url' => ['nullable', 'url', 'max:500'],
            'cost' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
