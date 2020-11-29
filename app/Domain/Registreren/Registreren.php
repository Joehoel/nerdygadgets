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
            if ($key === 'wachtwoord') {
                if ($value != $_POST['password-2']) {
                    return "Password do not match";
                } else {
                    // password check
                    $uppercase = preg_match('@[A-Z]@', $value);
                    $lowercase = preg_match('@[a-z]@', $value);
                    $number    = preg_match('@[0-9]@', $value);
                    $specialChars = preg_match('@[^\w]@', $value);

                    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($value) < 8) {
                        return 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
                    } else {
                        // hash the password
                        $user[$key] = password_hash($value, PASSWORD_DEFAULT);
                    }
                }
            }

            if ($key === 'email') {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return "Invalid email format";
                }
            }

            if ($key === "voornaam" || $key === "achternaam" || $key === "city") {
                if (preg_match('/[^A-Za-z]/', $value)) {
                    return "fouten gegevens";
                }
            }

            if ($key === "telefoonNummer") {
                if (preg_match('/[^0-9]/', $value)) {
                    return "fouten gegevens";
                }
            }

            if ($value === '' && $key != 'bedrijf') {
                return "missende " . $key;
            }
        }
        $error = $this->EmailCheck($user);
        if ($error !== '') {
            return $error;
        }
    }

    public function InsertGegevens($user)
    {
        $connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($connection, 'latin1');

        $sql = "
        INSERT INTO users (Email, FirstName, LastName, Password, PhoneNumber, Adress, City, PostalCode, Company)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stm = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stm, "ssssissss", $user["email"], $user["voornaam"], $user["achternaam"], $user["wachtwoord"], $user["telefoonNummer"], $user["adres"], $user["city"], $user["postcode"], $user["bedrijf"]);
        mysqli_stmt_execute($stm);
    }

    public function EmailCheck($user)
    {
        $connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($connection, 'latin1');

        $sql = "
        SELECT Email
        FROM users
        WHERE Email IN (?)";

        $stm = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stm, "s", $user['email']);
        mysqli_stmt_execute($stm);
        $result = mysqli_stmt_get_result($stm);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $test = count($result);
        if (count($result) === 0) {
            // email is niet geregistreerd
            $this->InsertGegevens($user);
        } else {
            return "E-mail is al geregistreerd";
        }
    }
}
