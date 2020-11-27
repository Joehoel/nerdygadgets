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
        // add a new user
        $user = new Registreren();
        $checkInfo = $user->checkGegevens();
        // error's are returned from checkinfo, if there is no return then there are no error's
        if ($checkInfo != "") {
            return header('Location: ' . base_url . 'registreren?error=' . $checkInfo);
        }

        // the page we go to when the user is registered
        return header('Location: ' . base_url . 'browse?newuser=true');
    }
}