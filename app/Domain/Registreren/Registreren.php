<?php

namespace App\Domain\Registreren;

use App\Domain\Database\DatabaseInstance;

Class Registreren {

    public function GetGegevens() 
    {
        $voornaam = $_POST['Voornaam']??'';
        $achternaam = $_POST['achternaam']??'';
        $huisnummer = $_POST['huisnummer']??'';
        $postcode = $_POST['postcode']??'';
        $straat = $_POST['straat']??'';
        $email = $_POST['email']??'';
        $telefoonNummer = $_POST['telefoonNummer']??'';
        $bedrijf = $_POST['bedrijf']??'';
        $wachtwoord1 = $_POST['wachtwoord1']??'';
        $wachtwoord2 = $_POST['wachtwoord2']??'';        
    }

    public function InsertGegevens() {
        $connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($connection, 'latin1');

        $sql = "INSERT INTO users U (Email, FirstName, LastName, Password, PhoneNumber, Adress, City, PostalCode, Company)"
        VALUES ($email, );
    }
}
?>