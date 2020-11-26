<?php

namespace App\Controller;

use App\Domain\Inloggen\Inloggen;

class InloggenController
{
    public function show()
    {
        echo view('inloggen');
    }
    public  function login()
    {
        $inloggen = new Inloggen();
        $error = $inloggen->checkGegevens();
        if ($inloggen !== "") {
            return header('Location: ' . base_url . 'inloggen?error=' . $error);
        }
        return header('Location: ' . base_url . 'browse?ingelogd=true');
    }
}
