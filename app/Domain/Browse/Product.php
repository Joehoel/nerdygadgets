<?php

namespace App\Domain\Browse;

class Product
{

    public function SortProducts($ReturnableResult)
    {
        if (isset($_GET['sort'])) {
            $SortOnPage = $_GET['sort'];
            $_SESSION["sort"] = $_GET['sort'];
        } else if (isset($_SESSION["sort"])) {
            $SortOnPage = $_SESSION["sort"];
        } else {
            $SortOnPage = "price_low_high";
            $_SESSION["sort"] = "price_low_high";
        }

        switch ($SortOnPage) {
            case 'price_high_low':
                usort($ReturnableResult, function ($a, $b) {
                    $a = $a["SellPrice"];
                    $b = $b["SellPrice"];
                    if ($a == $b) {
                        return 0;
                    }
                    return ($a > $b) ? -1 : 1;
                });
                break;
            case 'price_low_high':
                usort($ReturnableResult, function ($a, $b) {
                    $a = $a["SellPrice"];
                    $b = $b["SellPrice"];
                    if ($a == $b) {
                        return 0;
                    }
                    return ($a < $b) ? -1 : 1;
                });
                break;
            case 'name_low_high':
                usort($ReturnableResult, function ($a, $b) {
                    $a = $a["StockItemName"];
                    $b = $b["StockItemName"];
                    if ($a == $b) {
                        return 0;
                    }
                    return ($a < $b) ? -1 : 1;
                });
                break;
            case 'name_high_low':
                usort($ReturnableResult, function ($a, $b) {
                    $a = $a["StockItemName"];
                    $b = $b["StockItemName"];
                    if ($a == $b) {
                        return 0;
                    }
                    return ($a > $b) ? -1 : 1;
                });
                break;
        }
        return $ReturnableResult;
    }

    public function getProducts()
    {
        $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets", 3306);
        mysqli_set_charset($Connection, 'latin1');


        // set all the variables
        $CategoryID = $_GET['category_id'] ?? "";
        $SearchString = $_GET['search_string'] ?? "";
        $searchValues = explode(" ", $SearchString);
        $ProductsOnPage = $_GET["products_on_page"] ?? 50;
        $PageNumber = $_GET["page_number"] ?? 0;
        $Offset = $PageNumber * $ProductsOnPage;   
        $queryBuildResult = "";
        if ($SearchString != "") {
            for ($i = 0; $i < count($searchValues); $i++) {
                if ($i != 0) {
                    $queryBuildResult .= "AND ";
                }
                $queryBuildResult .= "SI.SearchDetails LIKE '%$searchValues[$i]%' ";
            }
            if ($queryBuildResult != "") {
                $queryBuildResult .= " OR ";
            }
            if ($SearchString != "" || $SearchString != null) {
                $queryBuildResult .= "SI.StockItemID ='$SearchString'";
            }
        }


        if ($SearchString !== "") {
            if (strpos("\\", $SearchString) === FALSE) {
                for ($i = 0; $i < count($searchValues); $i++) {
                    if ($i != 0) {
                        $queryBuildResult .= "AND ";
                    }
                    $queryBuildResult .= "SI.SearchDetails LIKE '%$searchValues[$i]%' ";
                }
                if ($queryBuildResult != "") {
                    $queryBuildResult .= " OR ";
                }
                if ($SearchString != "" || $SearchString != null) {
                    $queryBuildResult .= "SI.StockItemID ='$SearchString'";
                }
            } else {
                $SearchString = "";
            }
        }
        if ($CategoryID == "") {
            if ($queryBuildResult != "") {
                $queryBuildResult = "WHERE " . $queryBuildResult;
            }

            $Query = "
                        SELECT SI.StockItemID, SI.StockItemName, SI.MarketingComments, ROUND(TaxRate * RecommendedRetailPrice / 100 + RecommendedRetailPrice,2) as SellPrice,
                        (CASE WHEN (SIH.QuantityOnHand) >= ? THEN 'Ruime voorraad beschikbaar.' ELSE CONCAT('Voorraad: ',QuantityOnHand) END) AS QuantityOnHand,
                        (SELECT ImagePath
                        FROM stockitemimages
                        WHERE StockItemID = SI.StockItemID LIMIT 1) as ImagePath,
                        (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath
                        FROM stockitems SI
                        JOIN stockitemholdings SIH USING(stockitemid)
                        " . $queryBuildResult . "
                        GROUP BY StockItemID";

            $Statement = mysqli_prepare($Connection, $Query);
            mysqli_stmt_bind_param($Statement, "iii", $ShowStockLevel, $ProductsOnPage);

            mysqli_stmt_execute($Statement);
            $ReturnableResult = mysqli_stmt_get_result($Statement);
            $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

            $Query = "
                    SELECT count(*)
                    FROM stockitems SI
                    $queryBuildResult";
            $Statement = mysqli_prepare($Connection, $Query);
            mysqli_stmt_execute($Statement);
            $Result = mysqli_stmt_get_result($Statement);
            $Result = mysqli_fetch_all($Result, MYSQLI_ASSOC);
        } else {

            if ($queryBuildResult != "") {
                $queryBuildResult .= " AND ";
            }

            $Query = "
                        SELECT SI.StockItemID, SI.StockItemName, SI.MarketingComments, QuantityOnHand as voorraad,
                        ROUND(SI.TaxRate * SI.RecommendedRetailPrice / 100 + SI.RecommendedRetailPrice,2) as SellPrice,
                        (CASE WHEN (SIH.QuantityOnHand) >= ? THEN 'Ruime voorraad beschikbaar.' ELSE CONCAT('Voorraad: ',QuantityOnHand) END) AS QuantityOnHand,
                        (SELECT ImagePath FROM stockitemimages WHERE StockItemID = SI.StockItemID LIMIT 1) as ImagePath,
                        (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath
                        FROM stockitems SI
                        JOIN stockitemholdings SIH USING(stockitemid)
                        JOIN stockitemstockgroups USING(StockItemID)
                        JOIN stockgroups ON stockitemstockgroups.StockGroupID = stockgroups.StockGroupID
                        WHERE " . $queryBuildResult . " ? IN (SELECT StockGroupID from stockitemstockgroups WHERE StockItemID = SI.StockItemID)
                        GROUP BY StockItemID";

            $Statement = mysqli_prepare($Connection, $Query);
            mysqli_stmt_bind_param($Statement, "ii", $ShowStockLevel, $CategoryID);

            mysqli_stmt_execute($Statement);
            $ReturnableResult = mysqli_stmt_get_result($Statement);
            $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

            $Query = "
                        SELECT count(*)
                        FROM stockitems SI
                        WHERE " . $queryBuildResult . " ? IN (SELECT SS.StockGroupID from stockitemstockgroups SS WHERE SS.StockItemID = SI.StockItemID)";
            $Statement = mysqli_prepare($Connection, $Query);
            mysqli_stmt_bind_param($Statement, "i", $CategoryID);
            mysqli_stmt_execute($Statement);
            $Result = mysqli_stmt_get_result($Statement);
            $Result = mysqli_fetch_all($Result, MYSQLI_ASSOC);
            $_SESSION["results"] = $Result[0]["count(*)"];
        }

        foreach ($ReturnableResult as $key => $StockName) {
            $ReturnableResult[$key]["StockItemName"] = str_replace('"', "", $StockName["StockItemName"]);
        }
        $SortedArray = $this->SortProducts($ReturnableResult);

        $ReturnThisArray = [];
        $min = min((count($SortedArray) - $Offset), $ProductsOnPage);
        for ($i = 0; $i < $min; $i++) {
            array_push($ReturnThisArray, $SortedArray[$i + $Offset]);
        }
        return  $ReturnThisArray;
    }
}
