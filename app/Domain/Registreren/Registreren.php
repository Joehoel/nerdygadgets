<?php

namespace App\Domain\Registreren;

use App\Domain\Database\DatabaseInstance;
use mysqli;
use mysqli_stmt;

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

    public function InsertGegevens()
    {
        $connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($connection, 'latin1');

        $sql = "INSERT INTO users U (Email, FirstName, LastName, Password, PhoneNumber, Adress, City, PostalCode, Company)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stm = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stm, "iiiiiiiii", $email, $voornaam, $achternaam, $wachtwoord, $telefoonNummer, $straat, $stad, $postcode, $bedrijf);
        mysqli_stmt_execute($stm);
        $result = mysqli_stmt_get_result($stm);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function EmailCheck()
    {
        $connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($connection, 'latin1');

        $sql = "SELECT Email
                FROM users U
                WHERE Email IN ?";

        $stm = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stm, "i", $email);
    }
}
