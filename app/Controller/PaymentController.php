<?php

namespace App\Controller;

use App\Domain\Database\DatabaseInstance;

class PaymentController
{
    public function index()
    {

        $stockItemID = array();

        foreach($_SESSION['Cart'] as $key => $value) {
                $stockItemID[] = $key;
        }

        $in  = str_repeat('?,', count($stockItemID) - 1) . '?';
        $sql = "SELECT StockItemID, StockItemName, UnitPrice
                FROM stockitems
                WHERE StockItemID IN ($in)";
        $db = new DatabaseInstance();
        $stm = $db->create()->prepare($sql);
        $stm->execute($stockItemID);
        $result = $stm->fetchAll();    
        echo view('payment',[
            "stockitem"=>$result
        ]);
    }
}