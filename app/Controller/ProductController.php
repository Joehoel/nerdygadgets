<?php

namespace App\Controller;

class ProductController
{
    public function show($id)
    {
        echo view('product', ["id" => $id]);
    }
}