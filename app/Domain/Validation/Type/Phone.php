<?php

namespace App\Domain\Validation\Type;

class Phone
{
    public function rule($value)
    {
        if(preg_match('/^((\+|00(\s|\s?\-\s?)?)31(\s|\s?\-\s?)?(\(0\)[\-\s]?)?|0)[1-9]((\s|\s?\-\s?)?[0-9])((\s|\s?-\s?)?[0-9])((\s|\s?-\s?)?[0-9])\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]$/', $value)) {
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