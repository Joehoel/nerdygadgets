<?php

namespace App\Domain\Cart;

use NerdyGadgests\Classes\CartDatabase;

class Cart
{
    public function emptyCart()
    {
        if(!isset($_SESSION['Cart'])) {
            return true;
        }
        return false;
    }

    /**
     * Deze functie returnt alle data uit de cart
     *
     * @return Cart
     * @author Tim Bentum <support@adjust-it.nl>
     */
    public function GetCartArray()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if($this->emptyCart()) {
            return [];
        };
        return $_SESSION['Cart'];
    }

    /**
     * Toevoegen item aan cart
     *
     * @param int $artNr
     * @param int $aantal
     * @return void
     * @author Tim Bentum <support@adjust-it.nl>
     */
    public function AddItemToCart($artNr, $aantal)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $cart = isset($_SESSION['Cart']) ? $_SESSION['Cart'] : null;
        if (isset($cart[$artNr])) {
            $cart[$artNr] += $aantal;
        }
        else {
            $cart[$artNr] = $aantal;
        }
        $_SESSION['Cart'] = $cart;
    }

    /**
     * Remove artNR data uit de cart
     *
     * @param int $artNr
     * @return void
     * @author Tim Bentum <support@adjust-it.nl>
     */
    public function RemoveFromCart($artNr)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $cart = isset($_SESSION['Cart'])? $_SESSION['Cart'] : null;
        unset($cart[$artNr]);
    }

    /**
     * Updaten van de cart
     *
     * @return void
     * @author Tim Bentum <support@adjust-it.nl>
     */
    public function UpdateCart()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //kijken op getallen te kunnen update in de cart en dit doen
    }

    public function GetProductData($artNr) {
        $connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($connection, 'latin1');

        if ($connection != null){
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
            $statement = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($statement, "i", $artNr);
            mysqli_stmt_execute($statement);
            $returnable_result =  mysqli_stmt_get_result($statement);
            $result = mysqli_fetch_all($returnable_result, MYSQLI_ASSOC)[0];

            return $result;
        }
    }

}
