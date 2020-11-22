<?php

namespace App\Domain\Cart;

use App\Domain\Database\DatabaseInstance;
use NerdyGadgests\Classes\CartDatabase;

class Cart
{
    /**
     * Deze functie geeft een bool die als info geeft of er een winkelwagen bestaat
     *
     * @return void
     */
    public function emptyCart()
    {
        if (!isset($_SESSION['Cart'])) {
            return true;
        }
        return false;
    }

    /**
     * Deze functie returned alle data uit de cart
     *
     * @return Cart
     * @author Tim Bentum
     */
    public function GetCartArray()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if ($this->emptyCart()) {
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
     * @author Tim Bentum
     */
    public function AddItemToCart($artNr, $aantal)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $cart = isset($_SESSION['Cart']) ? $_SESSION['Cart'] : null;
        if (isset($cart[$artNr]) && $aantal > 0) {
            $cart[$artNr] += $aantal;
        } else if ($aantal > 0) {
            $cart[$artNr] = $aantal;
        }
        $_SESSION['Cart'] = $cart;
    }

    /**
     * Remove artNR data uit de cart
     *
     * @param int $artNr
     * @return void
     * @author Tim Bentum
     */
    public function RemoveFromCart($artNr)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['Cart']) && !empty($_SESSION['Cart'])) {
            unset($_SESSION['Cart'][$artNr]);
        }
    }

    /**
     * Update cart
     *
     * @param int $artNr
     * @param int $aantal
     * @return void
     * @author Tim Bentum
     */
    public function UpdateCart($artNr, $aantal)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $cart = isset($_SESSION['Cart']) ? $_SESSION['Cart'] : null;
        if (isset($cart[$artNr])) {
            $cart[$artNr] = $aantal;
        }
        $_SESSION['Cart'] = $cart;
        //kijken op getallen te kunnen update in de cart en dit doen
    }

    public function GetProductData($artNr)
    {
        $connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($connection, 'latin1');
        if ($connection != null) {
            $sql = "SELECT SI.StockItemID, SI.StockItemName, SI.MarketingComments,
                        ROUND(SI.TaxRate * SI.RecommendedRetailPrice / 100 + SI.RecommendedRetailPrice,2) as SellPrice,
                        (CASE WHEN (SIH.QuantityOnHand) >= 1000 THEN 'Ruime voorraad beschikbaar.' ELSE CONCAT('Voorraad: ',QuantityOnHand) END) AS QuantityOnHand,
                        QuantityOnHand as voorraad,
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

    public function GetTotalCartPrice()
    {
        $cartItems = $this->GetCartArray();

        $articleTotal = null;

        foreach ($cartItems as $id => $amount) {
            $price = $this->GetProductData($id)["SellPrice"];
            $articleTotal += $price * $amount;
        }

        $prices = [
            'articleTotal' => $articleTotal,
            'discount' => 0.00, // Verander zodat het berekent wordt
            'shipping' => 5.00, // Verander zodat het berekent wordt
        ];

        $total = 0;

        if ($articleTotal > 80.00) {
            $prices['shipping'] = 0.00;
        }

        foreach ($prices as $key => $value) {
            $total += $value;
            $prices[$key] = sprintf("€%0.2f", $value);
        }

        $prices['total'] = sprintf("€%0.2f", $total);

        return $prices;
    }
}
