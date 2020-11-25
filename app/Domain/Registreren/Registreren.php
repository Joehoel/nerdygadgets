<?php

namespace App\Domain\Registreren;

use App\Domain\Database\DatabaseInstance;
use mysqli;
use mysqli_stmt;

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
        $stad = $_POST['city']??'';        
    }


    public function InsertGegevens() {
        $connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($connection, 'latin1');

        $sql = "INSERT INTO users U (Email, FirstName, LastName, Password, PhoneNumber, Adress, City, PostalCode, Company)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

        $stm = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stm,"iiiiiiiii",$email,$voornaam,$achternaam,$wachtwoord,$telefoonNummer,$straat,$stad,$postcode,$bedrijf);
        mysqli_stmt_execute($stm);
        $result = mysqli_stmt_get_result($stm);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC); 
    }

    public function EmailCheck() {
        $connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($connection, 'latin1');

        $sql = "SELECT Email
                FROM users U
                WHERE Email IN ?";

        $stm = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stm,"i",$email);
    }
}
?>