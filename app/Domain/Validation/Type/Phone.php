<?php

namespace App\Domain\Validation\Type;

class Phone
{
    public function rule($value)
    {
        if(preg_match('/^[0-9\-\(\)\/\+\s]*$/', $value)) {
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