<?php

namespace App\Rules;

use App\Services\MailerliteService;
use Illuminate\Contracts\Validation\Rule;

class MailerLiteApiTokenRule implements Rule
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
     * @param  mixed   $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (new MailerliteService())->validateToken($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your MailerLite API token is invalid. Please paste in a valid API token.';
    }
}
