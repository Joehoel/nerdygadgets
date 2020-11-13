<?php

namespace App\Domain\Cart;

use App\Domain\Database\DatabaseInstance;

class CartController
{
    public function index()
    {
        $CartHandeler = new Cart();

        $database = new DatabaseInstance();

        echo view('cart', [
            'database' => $database,
            'cart' => $CartHandeler->GetCartArray(),
            'cartClass' => $CartHandeler
        ]);
    }

    public function add($id) {
        if (isset($_POST['aantal']) && !empty($_POST['aantal'])){
            $cart = new Cart();
            $cart->AddItemToCart($id, $_POST['aantal']);
        }
        return header('Location: ' . base_url . 'product/'. $id);
    }

    public function update($id)
    {
        if (isset($_POST['aantal']) && !empty($_POST['aantal'])){
            $cart = new Cart();
            // $cart->AddItemToCart($id, $_POST['aantal']);
            $cart->UpdateCart($id, $_POST['aantal']);
        }
        // return header('Location: ' . base_url . '/product/'. $id);
        return header('Location: ' . base_url . 'cart');
    }

    public function delete($id){
        $cart = new Cart();
        $cart->RemoveFromCart($id);
        return header('Location: ' . base_url . 'cart');

    }
}
