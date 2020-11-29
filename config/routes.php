<?php

use App\Controller\BrowseController;
use App\Controller\CheckoutController;
use App\Controller\CategoryController;
use App\Controller\HomeController;
use App\Controller\ProductController;
use App\Controller\ReviewController;
use App\Controller\RegistrerenController;
use App\Controller\ProfileController;
use App\Controller\InloggenController;
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
        "" => [HomeController::class, 'show', [
            "type" => "GET",
        ]],
        "product/{id}" => [ProductController::class, 'show', [
            "type" => "GET",
        ]],
        "update-cart/{id}" => [CartController::class, 'update', [
            "type" => "POST",
        ]],
        "add-to-cart-product/{id}" => [CartController::class, 'add_product', [
            "type" => "POST",
        ]],
        "add-to-cart-browse/{id}" => [CartController::class, 'add_browse', [
            "type" => "POST",
        ]],
        "delete-from-cart/{id}" => [CartController::class, 'delete', [
            "type" => "GET",
        ]],
        "browse" => [BrowseController::class, 'show', [
            "type" => "GET",
        ]],
        "categories" => [CategoryController::class, 'index', [
            "type" => "GET",
        ]],
        "payment" => [PaymentController::class, 'index', []],
        "checkout" => [CheckoutController::class, 'index', [
            "type" => "GET",
        ]],
        "cart" => [CartController::class, 'index', [
            "type" => "GET",
        ]],
        "create-review/{id}" => [ReviewController::class, 'create', [
            "type" => "POST",
        ]],
        "registreren" => [RegistrerenController::class, 'show', [
            "type" => "GET",
        ]],
        "addNewUser" => [RegistrerenController::class, 'addNewUser', [
            "type" => "POST",
        ]],
        "inloggen" => [InloggenController::class, 'show', [
            "type" => "GET",
        ]],
        "login" => [InloggenController::class, 'login', [
            "type" => "POST",
        ]],
        "profile" => [ProfileController::class, 'show', [
            "type" => "GET",
        ]],
        "uitloggen" => [ProfileController::class, 'uitloggen', [
            "type" => "GET",
        ]],
    ]
];
