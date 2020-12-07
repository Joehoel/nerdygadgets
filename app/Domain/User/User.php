<?php

namespace App\Domain\User;


use App\Domain\Database\DatabaseInstance;

class User
{
    private $db;

    public function __construct()
    {
        $db = new DatabaseInstance();
        $this->db = $db->create();
    }

    public function find($id)
    {
        $sth = $this->db->prepare("SELECT * FROM users WHERE UserID = ?");
        $sth->bindParam(1, $id);
        $sth->execute();

        return $sth->fetch();
    }

    public function updateAddress($data)
    {
        $fields = ['PhoneNumber', 'Adress', 'City', 'PostalCode', 'Country', 'Company'];
        $user = $this->find($_SESSION['User']['UserID']);
        $sth = $this->db->prepare("UPDATE users SET PhoneNumber = :PhoneNumber, Adress = :Adress, 
            City = :City, PostalCode = :PostalCode, Country = :Country, Company = :Company
            WHERE UserID = :UserID");
        $sth->bindValue('UserID', $_SESSION['User']['UserID']);

        foreach($data as $key => $value)
        {
            if(in_array($key, $fields)) {
                $sth->bindValue(':' . $key, $data[$key]);
            } else {
                $sth->bindValue(':' . $key, $user[$key]);
            }
        }
        return $sth->execute();
    }

    public function updateProfile($data)
    {
        $fields = ['FirstName', 'LastName', 'Email'];
        $user = $this->find($_SESSION['User']['UserID']);
        $sth = $this->db->prepare("
            UPDATE users SET FirstName = :FirstName, LastName = :LastName, Email = :Email WHERE UserID = :UserID
        ");
        $sth->bindValue('UserID', $_SESSION['User']['UserID']);

        foreach($data as $key => $value)
        {
            if(in_array($key, $fields)) {
                $sth->bindValue(':' . $key, $data[$key]);
            } else {
                $sth->bindValue(':' . $key, $user[$key]);
            }
        }
        return $sth->execute();
    }

    public function updatePassword($data)
    {
        $user = $this->find($_SESSION['User']['UserID']);

        $uppercase = preg_match('@[A-Z]@', $data['NewPassword']);
        $lowercase = preg_match('@[a-z]@', $data['NewPassword']);
        $number    = preg_match('@[0-9]@', $data['NewPassword']);

        if(password_verify($data['OldPassword'], $user['Password'])) {
            if($data['NewPassword'] === $data['ConfirmPassword']) {
                if (strlen($data['NewPassword']) >= 7
                    && $uppercase && $lowercase && $number) {
                    $sth = $this->db->prepare("UPDATE users SET Password = :Password
                                                        WHERE UserID = :UserID");
                    $sth->bindValue(':Password', $this->hashPassword($data['NewPassword']));
                    $sth->bindValue(':UserID', $user['UserID']);
                } else {
                    $_SESSION['errors'] = ['Make sure your password is at least 7 characters, has a uppercase, 
                                            lowercase and a number inside.'];
                }
            } else {
                $_SESSION['errors'] = ['Mismatch between the new passwords'];
            }
        } else {
            $_SESSION['errors'] = ['Old password is invalid'];
        }
    }

    public function hashPassword(String $password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
