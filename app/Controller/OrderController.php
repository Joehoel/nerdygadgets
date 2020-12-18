<?php

namespace App\Controller;

class OrderController
{
    public function show()
    {
        print_r($_POST);
        if (isset($_POST['method']) && $_POST['method'] === 'credit') {
            if (empty($_POST['card-number']) || empty($_POST['card-cvc']) || empty($_POST['card-name']) || empty($_POST['card-date'])) {
                return header("Location: " . base_url . "checkout?error=Je moet alle velden invullen");
            } else {
                echo view('order');
            }
        } else if (isset($_POST['method']) && $_POST['method'] === 'paypal') {
            echo view('order');
        } else  if (isset($_POST['method']) && $_POST['method'] === 'ideal') {
            if(empty($_POST['bank-name'])) {
                return header("Location: " . base_url . "checkout?error=Je moet een bank naam invullen");
            }
            echo view('order');
        } else {
            return header("Location: " . base_url . "checkout?error=Je moet alle velden invullen");
        }
    }
}
