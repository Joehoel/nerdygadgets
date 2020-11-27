<?php

namespace App\Domain\Route;


class Header
{
    public function back()
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? base_url;
        return header('Location: '. $referer);
    }

    public function abort($errorCode)
    {
        echo view('error/' . $errorCode);
        exit;
    }
}