<?php

namespace App\Domain\Validation;

class AddressValidation extends Validation
{
    protected $rules = [
        "PhoneNumber" => "Phone",
        "Adress" => "Required",
        "City" => "Required",
        "PostalCode" => "PostalCode",
        "Country" => "Required",
        "Company" => "Nullable"
    ];
}