<?php

namespace App\Domain\Validation;

class AddressValidation extends Validation
{
    protected $rules = [
        "PhoneNumber" => "Phone",
        "Adress" => "Required",
        "City" => "Alphabetic",
        "PostalCode" => "PostalCode",
        "Country" => "Alphabetic",
        "Company" => "Nullable"
    ];
}