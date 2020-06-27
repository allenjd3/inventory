<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckRegistrationKey implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return $value === env('REGISTRATION_KEY');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is invalid. Please Contact the System Administrator for more information.';
    }
}
