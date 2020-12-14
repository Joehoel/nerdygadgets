<?php

namespace App\Controller;

use App\Domain\User\Register;

class RegisterController
{
    public function show()
    {
<<<<<<< HEAD:app/Controller/RegistrerenController.php
        $user = new Registreren();
        $countries = $user->getCountries();
        echo view('registreren', [
            "countries" => $countries,
        ]);
=======
        return view('register');
>>>>>>> master:app/Controller/RegisterController.php
    }

    public function addNewUser()
    {
        // add a new user
<<<<<<< HEAD:app/Controller/RegistrerenController.php
        $user = new Registreren();
        $checkInfo = $user->checkGegevens();

=======
        $user = new Register();
        $checkInfo = $user->checkData();
>>>>>>> master:app/Controller/RegisterController.php
        // error's are returned from checkinfo, if there is no return then there are no error's
        if ($checkInfo != "") {
            return header('Location: ' . base_url . 'registreren?error=' . $checkInfo);
        }

        // the page we go to when the user is registered
        return header('Location: ' . base_url . 'inloggen?newuser=true');
    }
}
