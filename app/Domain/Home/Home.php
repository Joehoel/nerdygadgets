<?php

namespace App\Domain\Home;

use App\Domain\Database\DatabaseInstance;

class Home
{
    /**
     * Get all the StockGroups
     *
     * @return array StockGroups
     */
    public function getStockGroups()
    {
        $db = new DatabaseInstance();
        $conn = $db->create();

        $stmt = $conn->prepare("SELECT StockGroupID, StockGroupName, ImagePath
        FROM stockgroups
        WHERE StockGroupID IN 
        (
            SELECT StockGroupID
            FROM stockitemstockgroups
        ) 
        AND ImagePath IS NOT NULL
        ORDER BY StockGroupID ASC");

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Get a single product
     *
     * @param int $id
     * 
     * @return array product
     */
    public function getProduct($id)
    {
        $db = new DatabaseInstance();
        $conn = $db->create();

        $stmt = $conn->prepare("SELECT StockItemID, StockItemName, SearchDetails, (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice FROM stockitems WHERE StockItemID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch();
    }
}
