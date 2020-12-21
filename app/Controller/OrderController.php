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
            } else if (!$this->validate_cc($_POST['card-number'])) {
                return header("Location: " . base_url . "checkout?error=Foute kaart nummer");
            } else if (!preg_match('/^[0-9]{3,4}$/', $_POST['card-cvc'])) {
                return header("Location: " . base_url . "checkout?error=Foute CVC");
            } else if (!preg_match('/\b(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})\b/', $_POST['card-date'])) {
                return header("Location: " . base_url . "checkout?error=Foute verval datum");
            }else {
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

    /**
     * Validate credit card number
     * Returns true if $ccNum is in the proper credit card format.
     *
     * @param string $ccNum credit card number to validate
     * @param string|array $type if $type is set to 'fast', it validates the data against the major credit cards’ numbering formats.
     *        If $type is set to 'all', it validates the data against with all the credit card types.
     *        $type can also be set as array to validate against types you wish to match. For more accurate result use all.
     *		  Example: array('amex', 'bankcard', 'maestro')
     * @param string $regex A custom regex can also be passed, this will be used instead of the defined regex values.
     * @return bool Success
     *
     */
    function validate_cc($ccNum, $type = 'all', $regex = null)
    {

        $ccNum = str_replace(array('-', ' '), '', $ccNum);
        if (mb_strlen($ccNum) < 13) {
            return false;
        }

        if ($regex !== null) {
            if (is_string($regex) && preg_match($regex, $ccNum)) {
                return true;
            }
            return false;
        }

        $cards = array(
            'all' => array(
                'amex'        => '/^3[4|7]\\d{13}$/',
                'bankcard'    => '/^56(10\\d\\d|022[1-5])\\d{10}$/',
                'diners'    => '/^(?:3(0[0-5]|[68]\\d)\\d{11})|(?:5[1-5]\\d{14})$/',
                'disc'        => '/^(?:6011|650\\d)\\d{12}$/',
                'electron'    => '/^(?:417500|4917\\d{2}|4913\\d{2})\\d{10}$/',
                'enroute'    => '/^2(?:014|149)\\d{11}$/',
                'jcb'        => '/^(3\\d{4}|2100|1800)\\d{11}$/',
                'maestro'    => '/^(?:5020|6\\d{3})\\d{12}$/',
                'mc'        => '/^5[1-5]\\d{14}$/',
                'solo'        => '/^(6334[5-9][0-9]|6767[0-9]{2})\\d{10}(\\d{2,3})?$/',
                'switch'    =>
                '/^(?:49(03(0[2-9]|3[5-9])|11(0[1-2]|7[4-9]|8[1-2])|36[0-9]{2})\\d{10}(\\d{2,3})?)|(?:564182\\d{10}(\\d{2,3})?)|(6(3(33[0-4][0-9])|759[0-9]{2})\\d{10}(\\d{2,3})?)$/',
                'visa'        => '/^4\\d{12}(\\d{3})?$/',
                'voyager'    => '/^8699[0-9]{11}$/'
            ),
            'fast' =>
            '/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6011[0-9]{12}|3(?:0[0-5]|[68][0-9])[0-9]{11}|3[47][0-9]{13})$/'
        );

        if (is_array($type)) {
            foreach ($type as $value) {
                $regex = $cards['all'][strtolower($value)];

                if (is_string($regex) && preg_match($regex, $ccNum)) {
                    return true;
                }
            }
        } elseif ($type === 'all') {
            foreach ($cards['all'] as $value) {
                $regex = $value;

                if (is_string($regex) && preg_match($regex, $ccNum)) {
                    return true;
                }
            }
        } else {
            $regex = $cards['fast'];

            if (is_string($regex) && preg_match($regex, $ccNum)) {
                return true;
            }
        }
        return false;
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
