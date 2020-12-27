<?php

use App\Controller\BrowseController;
use App\Controller\CheckoutController;
use App\Controller\CategoryController;
use App\Controller\HomeController;
use App\Controller\LocaleController;
use App\Controller\LoginController;
use App\Controller\ProductController;
use App\Controller\ReviewController;
use App\Controller\RegisterController;
use App\Controller\ProfileController;
use App\Controller\InloggenController;
use App\Controller\OrderController;
use App\Controller\TempController;
use App\Domain\Cart\CartController;

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
        "" => [
            HomeController::class, 'show', [
                "type" => "GET",
            ]
        ],
        "product/{id}" => [
            ProductController::class, 'show', [
                "type" => "GET",
            ]
        ],
        "update-cart/{id}" => [
            CartController::class, 'update', [
                "type" => "POST",
            ]
        ],
        "add-to-cart-product/{id}" => [
            CartController::class, 'add_product', [
                "type" => "POST",
            ]
        ],
        "add-to-cart-browse/{id}" => [
            CartController::class, 'add_browse', [
                "type" => "POST",
            ]
        ],
        "delete-from-cart/{id}" => [
            CartController::class, 'delete', [
                "type" => "GET",
            ]
        ],
        "browse" => [
            BrowseController::class, 'show', [
                "type" => "GET",
            ]
        ],
        "checkout" => [
            CheckoutController::class, 'index', [
                "type" => "GET",
            ]
        ],
        "cart" => [
            CartController::class, 'index', [
                "type" => "GET",
            ]
        ],
        "taal/{language}" => [
            LocaleController::class, 'set', [
                "type" => "GET",
            ]
        ],
        "register" => [
            RegisterController::class, 'show', [
                "type" => "GET",
            ]
        ],
        "addNewUser" => [
            RegisterController::class, 'addNewUser', [
                "type" => "POST",
            ]
        ],
        "inloggen" => [
            LoginController::class, 'show', [
                "type" => "GET",
            ]
        ],
        "login" => [
            LoginController::class, 'login', [
                "type" => "POST",
            ]
        ],
        "create-review/{id}" => [
            ReviewController::class, 'create', [
                "type" => "POST",
            ]
        ],
        "profile" => [
            ProfileController::class, 'show', [
                "type" => "GET",
            ]
        ],
        "profile/address-update" => [
            ProfileController::class, 'updateAddress', [
                "type" => "POST",
            ]
        ],
        "profile/profile-update" => [
            ProfileController::class, 'updateProfile', [
                "type" => "POST",
            ]
        ],
        "profile/password-update" => [
            ProfileController::class, 'updatePassword', [
                "type" => "POST",
            ]
        ],
        "uitloggen" => [
            ProfileController::class, 'uitloggen', [
                "type" => "GET",
            ]
        ],
        "AddTempMeting" => [TempController::class, 'voegmetingtoe', [
            "type" => "POST",
        ]],
        "order" => [
            OrderController::class, 'show', [
                "type" => "POST",
            ]
        ],
    ]
];
