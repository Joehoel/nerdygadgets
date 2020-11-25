<?php

namespace App\Domain\Registreren;

use App\Domain\Database\DatabaseInstance;

class Registreren
{
    public function checkGegevens()
    {
        $user = [
            "voornaam" => $_POST["f-name"] ?? "",
            "achternaam" => $_POST['l-name'] ?? "",
            "adres" => $_POST['address'] ?? "",
            "postcode" => $_POST['p-c'] ?? "",
            "email" => $_POST['email'] ?? "",
            "telefoonNummer" => $_POST['tel'],
            "bedrijf" => $_POST['c-name'] ?? "",
            "city" => $_POST['city'] ?? "",
            "wachtwoord" => $_POST['password-1'] ?? ""
        ];
        foreach ($user as $key => $value) {
            switch ($value) {
                case '':
                    return "missende " . $key;
                    break;
                case 'wachtwoord':
                    if ($value != $_POST['password-2']) {
                        return "Password do not match";
                    }
                    break;
            }
        }
        $this->InsertGegevens($user);
    }


    public function GetGegevens()
    {
        // $voornaam = $_POST['Voornaam'] ?? '';
        // $achternaam = $_POST['achternaam'] ?? '';
        // $huisnummer = $_POST['huisnummer'] ?? '';
        // $postcode = $_POST['postcode'] ?? '';
        // $straat = $_POST['straat'] ?? '';
        // $email = $_POST['email'] ?? '';
        // $telefoonNummer = $_POST['telefoonNummer'] ?? '';
        // $bedrijf = $_POST['bedrijf'] ?? '';
        // $wachtwoord1 = $_POST['wachtwoord1'] ?? '';
        // $wachtwoord2 = $_POST['wachtwoord2'] ?? '';
    }

    public function InsertGegevens()
    {
        $connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($connection, 'latin1');

        // $sql = "INSERT INTO users U (Email, FirstName, LastName, Password, PhoneNumber, Adress, City, PostalCode, Company)"
        // VALUES ($email, );
    }
}
