<?php

namespace App\Domain\Validation;

class ProfileValidation extends Validation
{
    protected $rules = [
        "Email" => "Email",
        "FirstName" => "Required",
        "LastName" => "Required",
    ];
}