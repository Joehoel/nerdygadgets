<?php

use App\Controller\HomeController;

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
        "home/{id}/mondje/{help}" => [ HomeController::class, 'show', [
            "type" => "GET",
        ]],
    ]

];