<?php

namespace App\Controller;


class RegistrerenController
{
    public function show()
    {
        echo view('registreren');
    }

    public function addNewUser()
    {
        return header('Location: ' . base_url . 'registreren');
    }
}
