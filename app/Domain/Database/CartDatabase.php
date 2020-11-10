<?php

namespace NerdyGadgests\Classes;

class CartDatabase
{
    public $connection = null;

    public function MakeConnection()
    {
        $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($Connection, 'latin1');
        $this->connection = $Connection;
        return $this->connection;
    }

    public function CloseConnection()
    {
        mysqli_close($this->connection);
        $this->connection = null;
    }

    public function GetProductData($artNr){
        if ($this->connection != null){
            $sql = "SELECT SI.StockItemID, SI.StockItemName, SI.MarketingComments, 
                    ROUND(SI.TaxRate * SI.RecommendedRetailPrice / 100 + SI.RecommendedRetailPrice,2) as SellPrice, 
                    (CASE WHEN (SIH.QuantityOnHand) >= 1000 THEN 'Ruime voorraad beschikbaar.' ELSE CONCAT('Voorraad: ',QuantityOnHand) END) AS QuantityOnHand,
                    (SELECT ImagePath FROM stockitemimages WHERE StockItemID = SI.StockItemID LIMIT 1) as ImagePath,
                    (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath           
                    FROM stockitems SI 
                    JOIN stockitemholdings SIH USING(stockitemid)
                    JOIN stockitemstockgroups USING(StockItemID)
                    JOIN stockgroups ON stockitemstockgroups.StockGroupID = stockgroups.StockGroupID
                    where StockItemID = ?
                    limit 1;
            ";
            $Statement = mysqli_prepare($this->connection, $sql);
            mysqli_stmt_bind_param($Statement, "i", $artNr);
            mysqli_stmt_execute($Statement);
            $ReturnableResult =  mysqli_stmt_get_result($Statement);
            $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
            return $Result;
        }
    }
}

