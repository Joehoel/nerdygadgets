<?php

namespace App\Controller;

class RegisterController
{
  public function index()
  {
    echo view('register');
  }

  public function register()
  {
    if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password'])) {
      $firstName = $_POST['firstname'];
      $lastName = $_POST['lastname'];
      $email = $_POST['email'];
      $password = $_POST['password'];
    }
  }
}
