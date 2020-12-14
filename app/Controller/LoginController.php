<?php

namespace App\Controller;

use App\Domain\Inloggen\Inloggen;

class LoginController
{
    public function show()
    {
        return view('inloggen');
    }

    public  function login()
    {
        $inloggen = new Inloggen();
        $error = $inloggen->checkGegevens();
        if ($error !== null && $error !== true) {
            return header('Location: ' . base_url . 'inloggen?error=' . $error);
        }
        if ($error === true) {
            return header('Location: ' . base_url . 'browse?ingelogd=true');
        } else {
            return header('Location: ' . base_url . 'inloggen?error=' . "combinatie email en wachtwoord klopt niet");
        }
    }
}
