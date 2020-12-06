<?php

namespace App\Controller;

use App\Domain\Home\Home;

class HomeController
{
    public function show()
    {
        // get all the categories
        $HomeHandler = new Home();
        $StockGroups = $HomeHandler->getStockGroups();
        $MainProduct = $HomeHandler->getProduct(93);


        echo view('home', [
            "item" => $MainProduct,
            "StockGroups" => $StockGroups,
        ]);
    }
}
