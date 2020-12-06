<?php

namespace App\Domain\Browse;

use App\Domain\Database\DatabaseInstance;

class Product
{
    /**
     * Get all the products
     *
     * @return array products
     */
    public function getProducts()
    {
        /**
         * Set all the varibles
         */
        $categoryID = $_GET['category_id'] ?? "";

        $searchString = $_GET['search_string'] ?? "";
        $queryBuildResult = $this->createSearchString($searchString);

        if (isset($_GET['page_number'])) {
            $pageNumber = $_GET['page_number'];
        } else {
            $pageNumber = 0;
            $_GET['page_number'] = $pageNumber;
        }

        if (isset($_GET["products_on_page"])) {
            $productsOnPage = $_GET["products_on_page"];
        } else {
            $productsOnPage = 50;
            $_GET['products_on_page'] = $productsOnPage;
        }

        if (isset($_GET['sort'])) {
            $sortType = $_GET['sort'];
        } else {
            $sortType = "price_low_high";
            $_GET["sort"] = "price_low_high";
        }


        $offset = $pageNumber * $productsOnPage;

        // Fetch all the products from the database
        $products = $this->fetchProducts($categoryID, $queryBuildResult);

        // set the ammount of found products
        $_GET["results"] = count($products);

        // Sort all the products
        $products = $this->sortProducts($products, $sortType);

        // Cut the array
        $products = $this->cutArray($products, $offset, $productsOnPage);

        // return the results
        return  $products;
    }

    /**
     * Cut a specific ammount off the start of an array
     *
     * @return array cutArray
     */
    public function cutArray($arrayToCut, $offset, $amount)
    {
        $cutArray = array();
        $min = min((count($arrayToCut) - $offset), $amount);

        for ($i = 0; $i < $min; $i++) {
            array_push($cutArray, $arrayToCut[$i + $offset]);
        }

        return $cutArray;
    }

    /**
     * Create a searchString you can use in a query from searchValues
     *
     * @return string queryBuildResult
     */
    public function createSearchString($searchString)
    {
        $searchValues = explode(" ", $searchString);

        $queryBuildResult = "";
        if ($searchString !== "") {
            if (strpos("\\", $searchString) === FALSE) {
                for ($i = 0; $i < count($searchValues); $i++) {
                    if ($i != 0) {
                        $queryBuildResult .= "AND ";
                    }
                    $queryBuildResult .= "SI.SearchDetails LIKE '%$searchValues[$i]%' ";
                }
                if ($queryBuildResult != "") {
                    $queryBuildResult .= " OR ";
                }
                if ($searchString != "" || $searchString != null) {
                    $queryBuildResult .= "SI.StockItemID ='$searchString'";
                }
            } else {
                $searchString = "";
            }
        }

        return $queryBuildResult;
    }

    /**
     * Sort a array an given way
     *
     * @return string queryBuildResult
     */
    public function sortProducts($arrayToSort, $sortType)
    {
        foreach ($arrayToSort as $key => $itemName) {
            $arrayToSort[$key]["StockItemName"] = str_replace('"', "", $itemName["StockItemName"]);
        }

        switch ($sortType) {
            case 'price_high_low':
                usort($arrayToSort, function ($a, $b) {
                    $a = $a["SellPrice"];
                    $b = $b["SellPrice"];
                    if ($a == $b) {
                        return 0;
                    }
                    return ($a > $b) ? -1 : 1;
                });
                break;
            case 'price_low_high':
                usort($arrayToSort, function ($a, $b) {
                    $a = $a["SellPrice"];
                    $b = $b["SellPrice"];
                    if ($a == $b) {
                        return 0;
                    }
                    return ($a < $b) ? -1 : 1;
                });
                break;
            case 'name_low_high':
                usort($arrayToSort, function ($a, $b) {
                    $a = $a["StockItemName"];
                    $b = $b["StockItemName"];
                    if ($a == $b) {
                        return 0;
                    }
                    return ($a < $b) ? -1 : 1;
                });
                break;
            case 'name_high_low':
                usort($arrayToSort, function ($a, $b) {
                    $a = $a["StockItemName"];
                    $b = $b["StockItemName"];
                    if ($a == $b) {
                        return 0;
                    }
                    return ($a > $b) ? -1 : 1;
                });
                break;
        }
        return $arrayToSort;
    }

    /**
     * fetch from the database
     *
     * @return string queryBuildResult
     */
    public function fetchProducts($categoryID, $queryBuildResult)
    {
        $db = new DatabaseInstance();
        $conn = $db->create();

        if ($categoryID === "") {

            if ($queryBuildResult != "") {
                $queryBuildResult = "WHERE " . $queryBuildResult;
            }

            $stmt = $conn->prepare("SELECT stockitemstockgroups.StockGroupID AS CategoryID, SI.StockItemID, SI.StockItemName, SI.MarketingComments, QuantityOnHand,
            ROUND(TaxRate * RecommendedRetailPrice / 100 + RecommendedRetailPrice,2) as SellPrice,
            (SELECT ImagePath
            FROM stockitemimages
            WHERE StockItemID = SI.StockItemID LIMIT 1) as ImagePath,
            (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath
            FROM stockitems SI
            JOIN stockitemholdings SIH USING(stockitemid)
            JOIN stockitemstockgroups USING(StockItemID)
            " . $queryBuildResult . " 
            GROUP BY StockItemID");

            $stmt->execute();

            return $stmt->fetchAll();
        } else {

            if ($queryBuildResult != "") {
                $queryBuildResult .= " AND ";
            }

            $stmt = $conn->prepare(" SELECT stockitemstockgroups.StockGroupID AS CategoryID, SI.StockItemID, SI.StockItemName, SI.MarketingComments, QuantityOnHand,
            ROUND(SI.TaxRate * SI.RecommendedRetailPrice / 100 + SI.RecommendedRetailPrice,2) AS SellPrice,
            (SELECT ImagePath 
            FROM stockitemimages 
            WHERE StockItemID = SI.StockItemID LIMIT 1) AS ImagePath,
            (SELECT ImagePath 
            FROM stockgroups 
            JOIN stockitemstockgroups 
            USING(StockGroupID) 
            WHERE StockItemID = SI.StockItemID LIMIT 1) AS BackupImagePath
            FROM stockitems AS SI
            JOIN stockitemholdings AS SIH USING(stockitemid)
            JOIN stockitemstockgroups USING(StockItemID)
            JOIN stockgroups ON stockitemstockgroups.StockGroupID = stockgroups.StockGroupID
            WHERE " . $queryBuildResult . " :categoryID IN (SELECT StockGroupID from stockitemstockgroups WHERE StockItemID = SI.StockItemID)
            GROUP BY StockItemID;");

            $stmt->bindParam(':categoryID', $categoryID);

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }
}
