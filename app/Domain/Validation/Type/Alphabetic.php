<?php

namespace App\Domain\Validation\Type;

class Alphabetic
{
    public function rule($value)
    {
        if(ctype_alpha(str_replace(' ', '', $value))) {
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
        return 'Field may only contain alphabetic characters';
    }
}