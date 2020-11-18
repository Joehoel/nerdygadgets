<?php

namespace App\Controller;

use App\Domain\Database\DatabaseInstance;

class PaymentController
{
    public function index()
    {

        $stockItemID = array();
        $ids = "";


        foreach ($_SESSION['Cart'] as $key => $value) {
            $stockItemID[] = $key;
            $ids .= $key . ',';
        }

        $ids = substr($ids, 0, -1);

        $in  = str_repeat('?,', count($stockItemID) - 1) . '?';

        $sql = "SELECT SI.StockItemID, 
                ROUND(SI.TaxRate * SI.RecommendedRetailPrice / 100 + SI.RecommendedRetailPrice,2) as SellPrice       
                FROM stockitems SI 
                where StockItemID IN ($ids);";
        $db = new DatabaseInstance();
        $stm = $db->create()->prepare($sql);
        $stm->execute($stockItemID);
        $result = $stm->fetchAll();

        echo view('payment', [
            "stockitem" => $result
        ]);
    }
}
