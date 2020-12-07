<?php
include __DIR__ . "/connect.php";
include __DIR__ . "/header.php";
if (isset($_SESSION["User"])) {
    echo '<script>window.location.href = "' . base_url . 'browse"</script>';
}
?>
<div class="pop-up" id="pop-up"></div>
<?php if (isset($_GET['error'])) {
    echo '<script> popup("' . $_GET['error'] . '", true); </script>';
} ?>
<div class="registreren-container">
    <div class="information">
        <div>
            <h1><?= _("Klant informatie") ?></h1>
            <form class="form-1" method="post" action="<?php echo base_url; ?>addNewUser">

                <input type="text" placeholder="Email" name="email">
                <input type="password"
                       oninvalid="this.setCustomValidity('Password should be at least 8 characters in length and ' +
                        'should include at least one upper case letter and one number.')"
                       pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$"
                       placeholder="Password" name="password-1">
                <input type="password"
                       oninvalid="this.setCustomValidity('Password should be at least 8 characters in length and ' +
                        'should include at least one upper case letter and one number.')"
                       pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$"
                       placeholder="<?= _("Wachtwoord bevestigen") ?>" name="password-2">

                <h1><?= _("Verzend adres") ?></h1>

                <input type="text" placeholder="<?= _("Voornaam") ?>" name="f-name">
                <input type="text" placeholder="<?= _("Achternaam") ?>" name="l-name">
                <input type="text" placeholder="<?= _("Bedrijf (Optioneel)") ?>" name="c-name">
                <input type="text" placeholder="<?= _("Adres") ?>" name="address">
                <input type="text" placeholder="<?= _("Stad") ?>" name="city">
                <input type="text" placeholder="<?= _("Land") ?>" name="country">
                <input type="text" placeholder="<?= _("Postcode") ?>" name="p-c">
                <input type="text" placeholder="<?= _("Telefoonnummer") ?>" name="tel">
                <input type="submit" id="button" value="<?= _("Registreren") ?>" />

            </form>
        </div>
    </div>
</div>
