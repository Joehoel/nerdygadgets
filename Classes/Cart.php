<?php

namespace NerdyGadgests\Classes {
    class Cart
    {
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
            $cart = isset($_SESSION['Cart'])? $_SESSION['Cart'] : null;
            if (isset($cart[$artNr])){
                $cart[$artNr] += $aantal;
            }
            else{
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
    }
}
