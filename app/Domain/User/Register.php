<?php

namespace App\Domain\User;


class Register
{
    public function checkData()
    {
        $user = [
            "voornaam" => $_POST["f-name"] ?? "",
            "achternaam" => $_POST['l-name'] ?? "",
            "adres" => $_POST['address'] ?? "",
            "postcode" => $_POST['p-c'] ?? "",
            "email" => trim($_POST['email']) ?? "",
            "telefoonNummer" => $_POST['tel'],
            "bedrijf" => $_POST['c-name'] ?? "",
            "city" => $_POST['city'] ?? "",
            "country" => $_POST["country"] ?? "",
            "wachtwoord" => $_POST['password-1'] ?? ""
        ];

        foreach ($user as $key => $value) {
            if ($key === 'wachtwoord') if ($value != $_POST['password-2']) {
                return "Password do not match";
            } else {
                // password check
                $uppercase = preg_match('@[A-Z]@', $value);
                $lowercase = preg_match('@[a-z]@', $value);
                $number    = preg_match('@[0-9]@', $value);

                if (!$uppercase || !$lowercase || !$number  || strlen($value) < 8) {
                    return 'Password should be at least 8 characters in length and should include at least one upper case letter and one number.';
                } else {
                    // hash the password
                    $userInstance = new User();
                    $user[$key] = $userInstance->hashPassword($user[$key]);
                }
            }

            if ($key === 'email') {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return "Invalid email format";
                }
            }

            if ($key === "voornaam" || $key === "achternaam" || $key === "city") {
                if (preg_match('/[^A-Za-z]/', $value)) {
                    return "Foute gegevens";
                }
            }

            if ($key === "telefoonNummer" || $key === "country") {
                if (preg_match('/[^0-9]/', $value)) {
                    return "Foute gegevens";
                }
            }

            if ($value === '' && $key != 'bedrijf') {
                return "Missende " . $key;
            }
        }
        $error = $this->emailCheck($user);
        if ($error !== '') {
            return $error;
        }
    }

    public function insertData($user)
    {
        $connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($connection, 'latin1');

        $sql = "
        INSERT INTO users (Email, FirstName, LastName, Password, PhoneNumber, Adress, City, Country, PostalCode, Company)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stm = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stm, "ssssisssss", $user["email"], $user["voornaam"], $user["achternaam"], $user["wachtwoord"], $user["telefoonNummer"], $user["adres"], $user["city"], $user["country"], $user["postcode"], $user["bedrijf"]);
        mysqli_stmt_execute($stm);
    }

    public function emailCheck($user)
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
            $this->insertData($user);
        } else {
            return "E-mail is al geregistreerd";
        }
    }

    public function getCountries()
    {
        $db = new DatabaseInstance();
        $conn = $db->create();

        $stmt = $conn->prepare("SELECT CountryName, CountryID FROM countries;");

        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }
}
