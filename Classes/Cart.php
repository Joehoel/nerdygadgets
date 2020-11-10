<?php

namespace NerdyGadgests\Classes {
    class Cart
    {
        public function GetCartArray()
        {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            return $_SESSION['Cart'];
        }

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

        public function RemoveFromCart($artNr)
        {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $cart = isset($_SESSION['Cart'])? $_SESSION['Cart'] : null;
            unset($cart[$artNr]);
        }

        public function UpdateCart()
        {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            //kijken op getallen te kunnen update in de cart en dit doen
        }
    }
}
