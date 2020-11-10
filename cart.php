<?php

include "header.php";

include 'Classes/Cart.php';

use NerdyGadgests\Classes\Cart;

$CartHandeler = new Cart();


print_r($CartHandeler->GetCartArray());





include "footer.php";
