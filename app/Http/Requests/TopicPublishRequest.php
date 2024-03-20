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
}
