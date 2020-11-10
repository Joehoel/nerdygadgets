<?php

use App\Controller\HomeController;
use App\Controller\ProductController;

return [
    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    |  Here all available routes are defined. In order for a route to be added
    |  You have to 'bind' a route to a controller + function.
    |
    */
    "routes" => [
        "" => [ HomeController::class, 'show', [
            "type" => "GET",
        ]],
        "product/{id}" => [ ProductController::class, 'show', [
            "type" => "GET",
        ]],
    ]
];