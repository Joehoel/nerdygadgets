<?php

namespace App\Domain\Validation\Type;

class Phone
{
    public function rule($value)
    {
        if(filter_var($value, FILTER_SANITIZE_NUMBER_INT)) {
            return true;
        }
        return false;
    }

    public function validate()
    {
        return $this;
    }

    public function getMessage()
    {
        return 'Invalid phone number';
    }
}