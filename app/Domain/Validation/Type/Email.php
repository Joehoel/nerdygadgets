<?php

namespace App\Domain\Validation\Type;

class Email
{
    public function rule($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public function validate($value)
    {
        return $this;
    }

    public function getMessage()
    {
        return 'Invalid email address';
    }
}