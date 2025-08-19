<?php

namespace App\Http\Requests\CustomerRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Traits\CustomerRulesTrait;
use App\Traits\CustomerMessagesTrait;

class UpdateCustomerRequest extends FormRequest
{
    use CustomerRulesTrait, CustomerMessagesTrait;

    public function authorize(): bool
    {
        // Must be authenticated AND an admin to create customers
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        // Pass the customer model for unique email ignoring
        return $this->customerRules('sometimes', $this->route('customer'));
    }

    public function messages(): array
    {
        return $this->customerMessages();
    }
}
