<?php

namespace App\Domain\Validation\Type;

class Nullable
{
    public function rule($value)
    {
        return true;
    }

    public function validate()
    {
        return $this;
    }

    public function getMessage()
    {
        return '';
    }
}