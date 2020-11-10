<?php

namespace App\Domain\Cart;

use App\Domain\Database\DatabaseInstance;

class CartController
{
    public function index()
    {
        $CartHandeler = new Cart();
        $cart = $CartHandeler->GetCartArray();

        $database = new DatabaseInstance();

        echo view('cart', [
            'database' => $database,
            'cart' => $cart
        ]);
    }
}