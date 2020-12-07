<?php

namespace App\Domain\Validation;

class Validation
{
    private $errors = [];

    public function make($data)
    {
        foreach($data as $key => $value)
        {
            if(isset($this->rules[$key])) {

                // Check the type of validation we need to execute:
                $namespace = 'App\Domain\Validation\Type\\' . $this->rules[$key];
                $class = new $namespace();

                $result = call_user_func([$class, 'validate']);

                if(!$result->rule($value)) {
                    $this->errors[] = $result->getMessage();
                }
            }
        }
        return $this;
    }

    public function errors()
    {
        return $this->errors;
    }
}