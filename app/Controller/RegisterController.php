<?php

namespace App\Controller;

use App\Domain\User\Register;

class RegisterController
{
    public function show()
    {
        $user = new Register();
        $countries = $user->getCountries();
        view('register', [
            "countries" => $countries,
        ]);
        // return view('register');
    }

    public function addNewUser()
    {
        // add a new user
        $user = new Register();
        $checkInfo = $user->checkData();
        // error's are returned from checkinfo, if there is no return then there are no error's
        if ($checkInfo != "") {
            return header('Location: ' . base_url . 'register?error=' . $checkInfo);
        }

        // the page we go to when the user is registered
        return header('Location: ' . base_url . 'inloggen?newuser=true');
    }
}
