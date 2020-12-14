<?php

namespace App\Domain\Validation\Type;

class Required
{
    public function rule($value)
    {
        if(strlen($value) > 0 && $value !== null) {
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
        return 'Make sure all required fields are filled in.';
    }
}