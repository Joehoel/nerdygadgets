<?php

namespace App\Domain\Config;

class Config
{
    private $name;
    private $config;

    public function __construct($name)
    {
        $path = realpath(base_dir . DIRECTORY_SEPARATOR
            . 'config' . DIRECTORY_SEPARATOR . $name . '.php');

        $this->config = include($path);
    }

    public function get($name)
    {
        return $this->config[$name];
    }
}