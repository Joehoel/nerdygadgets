<?php

namespace App\Domain\Inloggen;

use App\Domain\Database\DatabaseInstance;
use mysqli;
use mysqli_stmt;

class Inloggen
{
    public function checkGegevens()
    {
        $email = $_POST['email'] ?? '';
        $wachtwoord = $_POST['password'] ?? '';
        if ($email != "" && $wachtwoord != "") {
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

            if (!empty($result)) {
                if (password_verify($wachtwoord, $result[0]["Password"])) {
                    $_SESSION["User"] = array(
                        "UserID" => $result[0]['UserID'],
                        "Email" => $result[0]['Email'],
                        "FirstName" => $result[0]['FirstName'],
                        "LastName" => $result[0]['LastName'],
                        "PhoneNumber" => $result[0]['PhoneNumber'],
                        "Adress" => $result[0]['Adress'],
                        "City" => $result[0]['City'],
                        "PostalCode" => $result[0]['PostalCode'],
                        "Company" => $result[0]['Company']
                    );
                    return true;
                } else {
                    return "combinatie email en wachtwoord klopt niet";
                }
            }
        } else {
            return "Niet alles is ingevult";
        }
    }
}
