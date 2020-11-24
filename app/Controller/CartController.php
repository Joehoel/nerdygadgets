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

    public function add($id)
    {
        if (isset($_POST['aantal']) && !empty($_POST['aantal']) && $_POST['aantal'] > 0) {
            $cart = new Cart();
            $cart->AddItemToCart($id, $_POST['aantal']);
        }
    }

    public function add_browse($id)
    {
        $this->add($id);
        return header('Location: ' . base_url . 'browse' . '?category_id=' . $_POST["category_id"]  . '&aantal=' . $_POST['aantal']);
    }
    public function add_product($id)
    {
        $this->add($id);
        return header('Location: ' . base_url . 'product/' . $id . '?aantal=' . $_POST['aantal']);
    }

    public function update($id)
    {
        if (isset($_POST['aantal']) && !empty($_POST['aantal']) && $_POST['aantal'] > 0) {
            $cart = new Cart();
            $cart->UpdateCart($id, $_POST['aantal']);
        } else if (isset($_POST['aantal']) && $_POST['aantal'] === "0") {
            $cart = new Cart();
            $cart->RemoveFromCart($id);
        }
        // return header('Location: ' . base_url . '/product/'. $id);
        return header('Location: ' . base_url . 'cart?update=true');
    }

    public function delete($id)
    {
        $cart = new Cart();
        $cart->RemoveFromCart($id);
        return header('Location: ' . base_url . 'cart?update=true');
    }
}
