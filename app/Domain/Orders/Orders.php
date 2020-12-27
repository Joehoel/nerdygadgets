<?php


namespace App\Domain\Orders;

use App\Domain\Cart\Cart;
use App\Domain\Database\DatabaseInstance;

class Order


{
    public function createOrder($userId, $method, $bank_name = null, $card_cvc = null, $card_holder = null, $card_date = null, $totalPrice)
    {

        $controller = new Cart;
        $cart = null;

        foreach ($_SESSION['Cart'] as $key => $value) {
            $cart[$key] = $controller->GetProductData($key);
        }

        $db = new DatabaseInstance;
        $conn = $db->create();

        $stmt = $conn->prepare("INSERT INTO `weborders`(`UserID`,`PaymentMethod`, `BankName`, `CartCVC`,`CartHolder`, `ExpDate`, `TotalPrice`) VALUES( ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([$userId, $method, $bank_name, $card_cvc, $card_holder, $card_date, $totalPrice]);

        $stmt->fetch();

        $id = $conn->lastInsertId();

        foreach ($cart as $item) {
            $stmt = $conn->prepare("INSERT INTO weborderlines(OrderID,ProductID) VALUES (?, ?)");
            $stmt->execute([$id, $item['StockItemID']]);
            $stmt->fetch();
        }


        $stmt = $conn->prepare("SELECT * FROM weborders WHERE OrderID = ?");
        $stmt->execute([$id]);

        $order = $stmt->fetch();

        $stmt = $conn->prepare("SELECT * FROM weborderlines WHERE OrderID = ?");
        $stmt->execute([$id]);
        $orderLine = $stmt->fetchAll();

        $map  = function ($line) {
            $controller = new Cart;

            return $controller->GetProductData($line['ProductID']);
        };

        $products = array_map($map, $orderLine);

        $controller->clearCart();

        return [$order, $products];
    }

    // public function getProducts($arr) {
    //     $controller = new Cart;

    //     $products = [];

    //     foreach ($arr as $item) {
    //         $products[$item['OrderID']] = $controller->GetProductData($item['OrderID']);
    //     }

    //     return $products;
    // }
}
