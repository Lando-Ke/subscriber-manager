<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DomainIsActiveRule implements Rule
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
        $domain = explode("@",$value)[1];
        return $this->pingDomain($domain);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be an active domain';
    }

    protected function pingDomain($domain)
    {
        if(checkdnsrr($domain,"MX")) {
            return true;
        } else {
            return false;
        }
    }
}
