<?php

namespace App\Http\Requests\Traits\CustomerTraits;

trait CustomerMessagesTrait
{
    public function customerMessages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be valid text.',
            'name.min' => 'Name must be at least 2 characters.',
            'name.max' => 'Name may not exceed 255 characters.',

            'email.required' => 'Email is required.',
            'email.string' => 'Email must be valid text.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email cannot exceed 255 characters.',
            'email.unique' => 'This email is already taken.',

            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.string' => 'Password must be valid text.',
        ];
    }
}
