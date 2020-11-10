<?php

namespace App\Controller;

use App\Domain\Config\Config;

class HomeController
{
    public function show(Config $config)
    {
        echo 'Show the homepage.';
    }

}