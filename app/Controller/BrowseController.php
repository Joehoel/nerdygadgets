<?php

namespace App\Controller;

use App\Domain\Browse\Product;

class BrowseController
{
    public function show()
    {
        $product = new Product();
        $products = $product->GetProducts();
        echo view('browse', [
            "products" => $products,
        ]);
    }
}
