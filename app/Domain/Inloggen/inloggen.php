<?php

namespace App\Domain\Inloggen;

use App\Domain\Database\DatabaseInstance;
use mysqli;
use mysqli_stmt;

class Inloggen
{
    public function checkGegevens()
    {
        $email = $_POST['email'];
        $wachtwoord = $_POST['password'];

        $sql = "
        SELECT *
        FROM users
        WHERE Email IN (?)";


        $connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($connection, 'latin1');

        $stm = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stm, "s", $email);
        mysqli_stmt_execute($stm);
        $result = mysqli_stmt_get_result($stm);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if (count($result) !== 0) {
            $test = password_verify($wachtwoord, $result[0]["Password"]);
            if (password_verify($wachtwoord, $result[0]["Password"])) {
                $_SESSION['voornaam'] = $result[0]["Voornaam"];
                $_SESSION['achternaam'] = $result[0]["Achternaam"];
            } else {
                return "combinatie email en wachtwoord klopt niet";
            }
        }
    }
}
