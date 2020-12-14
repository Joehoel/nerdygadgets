<?php

namespace App\Domain\Validation\Type;

class PostalCode
{
    public function rule($value)
    {
        $remove = str_replace(" ","", $value);
        $upper = strtoupper($remove);
        if( preg_match("/^\W*[1-9]{1}[0-9]{3}\W*[a-zA-Z]{2}\W*$/",  $upper)) {
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
        return 'Invalid postal code';
    }
}
