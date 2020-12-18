<?php
include __DIR__ . "/connect.php";
include __DIR__ . "/header.php";
?>

<div class="container">
    <?php if(isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger mt-3 pl-0 ml-0" role="alert">
            <ul class="mt-0 ml-0 pt-0">
            <?php foreach($_SESSION['errors'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="block col-12">
            <div class="logout">
                <a class="logout" href="<?php echo base_url; ?>uitloggen">
                    <?= _("Uitloggen") ?>
                </a>
            </div>
        </div>
        <div class="block col-md-6">
            <h3><?= _("Aanpassen adres") ?></h3>
            <form method="POST" action="<?= url('profile/address-update') ?>">

                <div class="form-group">
                    <label><?= _("Telefoonnummer") ?></label>
                    <input type="text" name="PhoneNumber" placeholder="<?= _("Telefoonnummer")?>"
                           value="<?= $user["PhoneNumber"] ?? null?>" />
                </div>

                <div class="form-group">
                        <label><?= _("Straatnaam + huisnummer") ?></label>
                        <input type="text" class="form-control" name="Adress" placeholder="<?= _("Straatnaam + huisnummer")?>"
                               value="<?= $user["Adress"] ?? null?>" />
                </div>

                <div class="form-group">
                    <label><?= _("Woonplaats") ?></label>
                    <input type="text" name="City" placeholder="<?= _("Woonplaats")?>"
                           value="<?= $user["City"] ?? null?>" />
                </div>

                <div class="form-group">
                    <label><?= _("Postcode") ?></label>
                    <input type="text" name="PostalCode" placeholder="<?= _("Postcode")?>"
                           value="<?= $user["PostalCode"] ?? null?>" />
                </div>

                <div class="form-group">
                    <label><?= _("Land") ?></label>
                    <input type="text" name="Country" placeholder="<?= _("Land")?>"
                           value="<?= $user["Country"] ?? null?>"/>
                </div>

                <div class="form-group">
                    <label><?= _("Bedrijf (optioneel)") ?></label>
                    <input type="text" name="Company" placeholder="<?= _("Bedrijf (optioneel)")?>"
                           value="<?= $user["Company"] ?? null?>"/>
                </div>

                <button class="btn btn-outline-primary">
                    <?= _("Aanpassingen opslaan")?>
                </button>
            </form>
        </div>

        <div class="block col-md-6">
            <div class="ml-3">
                <h3><?= _("Profiel aanpassen") ?></h3>
                <form method="POST" action="<?= url('profile/profile-update') ?>">

                    <div class="form-group">
                        <label><?= _("Voornaam") ?></label>
                        <input type="text" name="FirstName" placeholder="<?= _("Voornaam")?>"
                               value="<?= $user["FirstName"] ?? null?>" />
                    </div>

                    <div class="form-group">
                        <label><?= _("Achternaam") ?></label>
                        <input type="text" name="LastName" placeholder="<?= _("Achternaam")?>"
                               value="<?= $user["LastName"] ?? null?>" />
                    </div>

                    <div class="form-group">
                        <label><?= _("E-Mail") ?></label>
                        <input type="text" name="Email" placeholder="<?= _("E-Mail")?>"
                               value="<?= $user["Email"] ?? null?>" />
                    </div>

                    <button class="btn btn-outline-primary">
                        <?= _("Profiel opslaan")?>
                    </button>
                </form>
            </div>
            <div class="block ml-3">
                <h3><?= _("Wachtwoord aanpassen") ?></h3>
                <form method="POST" action="<?= url('profile/password-update') ?>">

                    <div class="form-group">
                        <label>
                            <?= _("Ter verificatie hier het oude wachtwoord invullen") ?>
                        </label>
                        <input type="password" name="OldPassword" placeholder="<?= _("Oude wachtwoord")?>"/>
                    </div>

                    <div class="form-group">
                        <label><?= _("Nieuwe wachtwoord") ?></label>
                        <input type="password" name="NewPassword" placeholder="<?= _("Nieuwe wachtwoord")?>"/>
                    </div>

                    <div class="form-group">
                        <label><?= _("Nieuwe wachtwoord (herhaling)") ?></label>
                        <input type="password" name="ConfirmPassword" placeholder="<?= _("Nieuwe wachtwoord (herhaling)")?>"/>
                    </div>

                    <button class="btn btn-outline-primary">
                        <?= _("Nieuw wachtwoord opslaan")?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
