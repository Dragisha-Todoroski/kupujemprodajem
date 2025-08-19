<?php

namespace App\Http\Requests\Traits\CustomerTraits;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

trait CustomerRulesTrait
{
    public function customerRules(string $requirement = 'required', ?User $customer = null): array
    {
        // Inspired by RegisterUserController's store() method validations
        return [
            'name' => [$requirement, 'string', 'min:2', 'max:255'],
            'email' => [
                $requirement,
                'string',
                'email',
                'max:255',

                // On updates, customers' own emails won't cause "unique" validation errors for themselves
                $customer
                    ? Rule::unique('users', 'email')->ignore($customer->getKey())
                    : Rule::unique('users', 'email'),
            ],
            // On updates, password doesn't need to be provided
            'password' => array_merge([$requirement, 'confirmed'], Password::defaults()),
        ];
    }
}
