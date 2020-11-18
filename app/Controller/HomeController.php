<?php

namespace App\Controller;

use App\Domain\Database\DatabaseInstance;

class HomeController
{
    public function show()
    {
        $result = array();

        $db = new DatabaseInstance();
        $conn = $db->create();

        $stmt = $conn->prepare("SELECT StockItemID, StockItemName, SearchDetails, (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice FROM stockitems WHERE StockItemID = 93");
        $stmt->execute();

        $result = $stmt->fetchAll()[0];

        echo view('home', [
            "item" => $result,
        ]);
    }
}
