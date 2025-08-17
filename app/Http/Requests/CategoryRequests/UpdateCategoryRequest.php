<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\CategoryTraits\CategoryRulesTrait;
use App\Http\Requests\Traits\CategoryTraits\CategoryMessagesTrait;

class UpdateCategoryRequest extends FormRequest
{
    use CategoryRulesTrait, CategoryMessagesTrait;

    /**
     * Determine if the user is authorized to make this request
     */
    public function authorize(): bool
    {
        // Must be authenticated AND an admin to update categories
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request
     */
    public function rules(): array
    {
        return $this->categoryRules('sometimes', $this->route('category'));
    }

    /**
     * Get the validation error messages that apply to the request
     */
    public function messages(): array
    {
        return $this->categoryMessages();
    }
}
