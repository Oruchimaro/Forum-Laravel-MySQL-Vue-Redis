<?php

namespace App\Rules;

use App\Inspections\Spam;
use Illuminate\Contracts\Validation\Rule;

class SpamFree implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //cause our spam class doesnt return a bool, we will use try/catch
        try {

            //detect spam using Spam class
            return !resolve(Spam::class)->detect($value);
        } catch (\Exception $e) {

            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute contains spam or invalid string';
    }
}
