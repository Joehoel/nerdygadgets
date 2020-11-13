<?php
include __DIR__ . "/connect.php";
include __DIR__ . "/header.php";

?>

<div class="register">

  <form action="register-user" method="POST">
    <h1>Register</h1>
    <div class="form-group">
      <label for="firstname" class="hidden">First Name</label>
      <input type="text" name="firstname" placeholder="First name">
    </div>
    <div class="form-group">
      <label for="lastname" class="hidden">Last Name</label>
      <input type="text" name="lastname" placeholder="Last name">
    </div>
    <div class="form-group">
      <label for="email" class="hidden">Email</label>
      <input type="text" name="email" placeholder="Email">
    </div>
    <div class="form-group">
      <label for="password" class="hidden">Password</label>
      <input type="password" name="password" placeholder="Password">
    </div>
    <div class="form-group">
      <button type="submit">Register</button>
    </div>
  </form>

</div>
