<?php

namespace App\Http\Requests\CustomerRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\CustomerRulesTrait;
use App\Traits\CustomerMessagesTrait;

class StoreCustomerRequest extends FormRequest
{
    use CustomerRulesTrait, CustomerMessagesTrait;

    public function authorize(): bool
    {
        // Must be authenticated AND an admin to create customers
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request
     */
    public function rules(): array
    {
        return $this->customerRules('required');
    }

    /**
     * Get the validation error messages that apply to the request
     */
    public function messages(): array
    {
        return $this->customerMessages();
    }
}
