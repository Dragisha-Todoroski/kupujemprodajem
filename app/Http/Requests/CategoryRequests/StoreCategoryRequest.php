<?php

namespace App\Http\Requests\CategoryRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\CategoryTraits\CategoryRulesTrait;
use App\Http\Requests\Traits\CategoryTraits\CategoryMessagesTrait;

class StoreCategoryRequest extends FormRequest
{
    use CategoryRulesTrait, CategoryMessagesTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Must be authenticated AND an admin to create categories
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request
     */
    public function rules(): array
    {
        return $this->categoryRules('required');
    }

    /**
     * Get the validation error messages that apply to the request
     */
    public function messages(): array
    {
        return $this->categoryMessages();
    }
}
