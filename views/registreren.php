<?php
include __DIR__ . "/connect.php";
include __DIR__ . "/header.php";

?>
<div class="pop-up" id="pop-up"></div>
<?php if (isset($_GET['error'])) {
    echo '<script> popup("' . $_GET['error'] . '", true); </script>';
} ?>
<div class="registreren-container">
    <div class="information">
        <div>
            <h1>Customer information</h1>
            <form class="form-1" method="post" action="<?php echo base_url; ?>addNewUser">
                <input type="text" placeholder="Email" name="email">
                <input type="password" placeholder="Password" name="password-1">
                <input type="password" placeholder="Confirm password" name="password-2">
                <h1>shipping address</h1>
                <input type="text" placeholder="First name" name="f-name">
                <input type="text" placeholder="Last name" name="l-name">
                <input type="text" placeholder="Company (optional)" name="c-name">
                <input type="text" placeholder="Address" name="address">
                <input type="text" placeholder="City" name="city">
                <input type="text" placeholder="Country" name="country">
                <input type="text" placeholder="Postal code" name="p-c">
                <input type="text" placeholder="Phone" name="tel">
                <input type="submit" id="button" value="Registreren" />
            </form>
        </div>
    </div>
</div>