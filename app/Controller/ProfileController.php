<?php

namespace App\Controller;

use App\Domain\User\User;
use App\Domain\Validation\AddressValidation;
use App\Domain\Validation\ProfileValidation;

class ProfileController
{
    public function show()
    {
        if (!isset($_SESSION["User"])) {
            return redirect('inloggen');
        }

        $user = new User();
        $user = $user->find($_SESSION["User"]["UserID"]);

        return view('profile', compact('user'));
    }

    public function updateAddress()
    {
        $data = $_POST;

        $verify = new AddressValidation();
        $results = $verify->make($data);

        if(!$results->errors()) {
            $user = new User();
            $user->updateAddress($data);
        } else {
            $_SESSION['errors'] = $results->errors();
        }

        return redirect('profile');
    }

    public function updateProfile()
    {
        $data = $_POST;

        $verify = new ProfileValidation();
        $results = $verify->make($data);

        if(!$results->errors()) {
            $user = new User();
            $user->updateProfile($data);
        } else {
            $_SESSION['errors'] = $results->errors();
        }

        return redirect('profile');
    }

    public function updatePassword()
    {
        $data = $_POST;

        $user = new User();
        $user->updatePassword($data);

        return redirect('profile');
    }

    public function uitloggen()
    {
        unset($_SESSION["User"]);
        return header('Location: ' . base_url . 'browse?uitgelogd=true');
    }

    public function update()
    {

    }
}