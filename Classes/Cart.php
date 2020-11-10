<?php

namespace NerdyGadgests\Classes{
    class Cart
    {
        public function GetCartArray(){
            session_start();
            return $_SESSION['Cart'];
        }

        public function AddItemToCart($artNr, $aantal){
            session_start();
            //kijken of al in array is... dan aantal toevoegen aan dat getal
            //anders niewe line aan $_SESSION['Cart'] geven 
        }

        public function RemoveFromCart($artNr){
            session_start();
        }

        public function UpdateCart(){
            session_start();
            //kijken op getallen te kunnen update in de cart en dit doen
        }
    }
    
}