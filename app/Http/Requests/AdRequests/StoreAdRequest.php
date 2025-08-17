<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\AdTraits\AdRulesTrait;
use App\Http\Requests\Traits\AdTraits\AdMessagesTrait;

class StoreAdRequest extends FormRequest
{
    use AdRulesTrait, AdMessagesTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Must be authenticated to create ads
        return auth()->check();
    }

    public function rules(): array
    {
        // Use the trait to get rules; 'required' by default
        return $this->adRules('required');
    }

    /**
     * Get the validation error messages that apply to the request
     */
    public function messages(): array
    {
        return $this->adMessages();
    }
}
