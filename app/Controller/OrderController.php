<?php

namespace App\Controller;


use App\Domain\Cart\Cart;
use App\Domain\Orders\Order;


class OrderController
{
    public function show()
    {
        $order = new Order;
        $controller = new Cart;
        $cart = null;
        $total = $controller->GetTotalCartPrice()['total'];


        foreach ($_SESSION['Cart'] as $key => $value) {
            $cart[$key] = $controller->GetProductData($key);
        }

        if (isset($_POST['method']) && $_POST['method'] === 'credit') {
            if (empty($_POST['card-number']) || empty($_POST['card-cvc']) || empty($_POST['card-name']) || empty($_POST['card-date'])) {
                return header("Location: " . base_url . "checkout?error=Je moet alle velden invullen");
            } else {
                [$order, $products] = $order->createOrder($_SESSION['User']['UserID'], $_POST['method'], $_POST['bank-name'], $_POST['card-cvc'], $_POST['card-name'], $_POST['card-date'], $total);

                echo view('order', [
                    'order' => $order,
                    'products' => $products,
                ]);
            }
        } else if (isset($_POST['method']) && $_POST['method'] === 'paypal') {
            [$order, $products] = $order->createOrder($_SESSION['User']['UserID'], $_POST['method'], null, null, null, null, $total);

            echo view('order', [
                'order' => $order,
                'products' => $products,
            ]);
        } else  if (isset($_POST['method']) && $_POST['method'] === 'ideal') {
            if (empty($_POST['bank-name'])) {
                return header("Location: " . base_url . "checkout?error=Je moet een bank naam invullen");
            }
            [$order, $products] = $order->createOrder($_SESSION['User']['UserID'], $_POST['method'], $_POST['bank-name'], null, null, null, $total);

            echo view('order', [
                'order' => $order,
                'products' => $products
            ]);
        } else {
            return header("Location: " . base_url . "checkout?error=Je moet alle velden invullen");
        }
    }

    // private function createOrder($userId, $method, $bank_name, $card_cvc, $card_holder, $card_date)
    // {
    //     $controller = new Cart;
    //     $cart = null;

    //     foreach ($_SESSION['Cart'] as $key => $value) {
    //         $cart[$key] = $controller->GetProductData($key);
    //     }

    //     $db = new DatabaseInstance;
    //     $conn = $db->create();

    //     $stmt = $conn->prepare("INSERT INTO `weborders`(`UserID`,`PaymentMethod`, `BankName`, `CartCVC`,`CartHolder`, `ExpDate`) VALUES( ? , ? , ? , ? , ?, ?)");

    //     $stmt->execute([$userId, $method, $bank_name, $card_cvc, $card_holder, $card_date]);

    //     $stmt->fetchAll();

    //     $id = $conn->lastInsertId();

    //     foreach ($cart as $item) {
    //         $stmt = $conn->prepare("INSERT INTO weborderlines(OrderID,ProductID) VALUES (?, ?)");
    //         $stmt->execute([$id, $item['StockItemID']]);
    //         $stmt->fetch();
    //     }


    //     $stmt = $conn->prepare("SELECT * FROM weborders WHERE OrderID = ?");
    //     $stmt->execute([$id]);

    //     $order = $stmt->fetch();

    //     return $order;
    // }
}
