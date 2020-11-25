<?php

namespace App\Controller;

use App\Domain\Registreren\Registreren;

class RegistrerenController
{
    public function show()
    {
        echo view('registreren');
    }

    public function addNewUser()
    {
        $user = new Registreren();
        $checkInfo = $user->checkGegevens();
        if ($checkInfo != "") {
            return header('Location: ' . base_url . 'registreren?error=' . $checkInfo);
        }
        return header('Location: ' . base_url . 'registreren');
    }
}
