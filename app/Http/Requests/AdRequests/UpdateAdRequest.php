<?php

namespace App\Http\Requests\AdRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\AdTraits\AdRulesTrait;
use App\Http\Requests\Traits\AdTraits\AdMessagesTrait;

class UpdateAdRequest extends FormRequest
{
    use AdRulesTrait, AdMessagesTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Must be authenticated to update ads
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request
     */
    public function rules(): array
    {
        return $this->adRules('sometimes');
    }

    /**
     * Get the validation error messages that apply to the request
     */
    public function messages(): array
    {
        return $this->adMessages();
    }
}
