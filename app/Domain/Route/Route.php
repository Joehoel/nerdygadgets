<?php

namespace App\Domain\Route;

use App\Domain\Config\Config;

class Route
{
    private $config;

    public function __construct()
    {
        $this->config = new Config("routes");
    }

    public function match($slug)
    {
        foreach($this->config->get("routes") as $route => $data) {
            if($route === $slug)
            {
                echo $data[0];
                echo $data[1];
                print_r($data[2]);
            }
        }
    }

}