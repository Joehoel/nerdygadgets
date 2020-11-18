<?php

namespace App\Controller;

use App\Domain\Product\Product;

class HomeController
{
    public function show()
    {
        $ProductHandler = new Product();
        $result = $ProductHandler->getProduct(93);

        echo view('home', [
            "item" => $result,
        ]);
    }
}
