<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class HasRole implements Rule
{
    private $role;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($role)
    {
        $this->role = $role;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = new User($value);

        if (!$user->exists) {
            return false;
        }

        return $user->hasRole($this->role);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'User does not have the required roles.';
    }
}
