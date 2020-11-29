<?php

namespace App\Controller;

class ProfileController
{
    public function show()
    {
        echo view('profile');
    }

    public function uitloggen() {
        unset($_SESSION["User"]);
        return header('Location: ' . base_url . 'browse?uitgelogd=true');
    }
}