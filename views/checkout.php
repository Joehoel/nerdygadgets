<?php
include __DIR__ . "/connect.php";
include __DIR__ . "/header.php";

/**
 * Deze functie geeft het subtotaal terug
 *
 * @param arr $stockitem
 * @return int
 */

function berekenSubtotaal($stockitem)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $subTotaalprijs = 0;
    foreach ($stockitem as $key => $values) {
        $subTotaalprijs += ($values[1] * $_SESSION['Cart'][$values[0]]);
    }
    return $subTotaalprijs;
}

function berekenBtw($subTotaalprijs)
{
    $btw = $subTotaalprijs / 100 * 9;
    return $btw;
}

function berekenVerzendkosten($subTotaalprijs)
{
    if ($subTotaalprijs < 80) {
        return 6.95;
    } else {
        return 0;
    }
}

function berekenTotaal($subTotaalprijs, $verzendKosten)
{
    $totaalPrijs = $subTotaalprijs + $verzendKosten;
    return $totaalPrijs;
}

function berekenTotaallijst($stockitem)
{
    foreach ($stockitem as $item) {
        $totaalPerproduct = $item['SellPrice'] * $_SESSION['Cart'][$item['StockItemID']];
        echo ('<tr>');
        echo ('<td>' . $item['StockItemName'] . '</td>');
        echo ('<td>' . $_SESSION['Cart'][$item['StockItemID']] . '</td>');
        echo ('<td>€' . number_format($totaalPerproduct, 2, ",", ".") . '</td>');
        echo ('</tr>');
    }
}
?>
<div class="pop-up" id="pop-up"></div>
<?php if (isset($_GET['error'])) {
    echo '<script> popup("' . $_GET['error'] . '", true); </script>';
} ?>
<div class="payments-container">
    <div class="information">
        <div>
            <h1><?= _("Klant informatie") ?></h1>
            <form class="form-2">
                <input type="text" placeholder="Email" name="email" value="<?php if (isset($_SESSION["User"])) {
                                                                                echo $_SESSION["User"]["Email"];
                                                                            }
                                                                            ?>">
                <h1><?= _("Verzendingsadres") ?></h1>
                <input type="text" placeholder="<?= _('Voornaam') ?>" name="f-name" value="<?php if (isset($_SESSION["User"])) {
                                                                                                echo $_SESSION["User"]["FirstName"];
                                                                                            }
                                                                                            ?>">
                <input type="text" placeholder="<?= _('Achternaam') ?>" name="l-name" value="<?php if (isset($_SESSION["User"])) {
                                                                                                    echo $_SESSION["User"]["LastName"];
                                                                                                }
                                                                                                ?>">
                <input type="text" placeholder="<?= _('Bedrijf (Optioneel)') ?>" name="c-name" value="<?php if (isset($_SESSION["User"])) {
                                                                                                            if ($_SESSION["User"]["Company"] !== '') {
                                                                                                                echo $_SESSION["User"]["Company"];
                                                                                                            }
                                                                                                        }
                                                                                                        ?>">
                <input type="text" placeholder="<?= _('Adres') ?>" name="address" value="<?php if (isset($_SESSION["User"])) {
                                                                                                echo $_SESSION["User"]["Adress"];
                                                                                            }
                                                                                            ?>">
                <input type="text" placeholder="<?= _('Stad') ?>" name="city" value="<?php if (isset($_SESSION["User"])) {
                                                                                            echo $_SESSION["User"]["City"];
                                                                                        }
                                                                                        ?>">
                <select type="text" placeholder="<?= _("Land") ?>" name="country" id="input">
                    <?php
                    foreach ($countries as $country) {
                        if (isset($_SESSION["User"])) {
                            if ((int)$country["CountryID"] === $_SESSION["User"]["Country"]) {
                                echo '<option selected="selected" value="' . $country["CountryID"] . '">' . $country["CountryName"] . '</option>';
                            } else {
                                echo '<option value="' . $country["CountryID"] . '">' . $country["CountryName"] . '</option>';
                            }
                        } else {
                            echo '<option value="' . $country["CountryID"] . '">' . $country["CountryName"] . '</option>';
                        }
                    }
                    ?>
                </select>
                <input type="text" placeholder="<?= _("Postcode") ?>" name="p-c" value="<?php if (isset($_SESSION["User"])) {
                                                                                            echo $_SESSION["User"]["PostalCode"];
                                                                                        }
                                                                                        ?>">
                <input type="text" placeholder="<?= _("Telefoonnummer") ?>" name="tel" value="<?php if (isset($_SESSION["User"])) {
                                                                                                    echo $_SESSION["User"]["PhoneNumber"];
                                                                                                }
                                                                                                ?>">
            </form>
        </div>
    </div>

    <div class="payment">
        <table>
            <?php berekenTotaallijst($stockitem); ?>
            <tr>
                <td><?= _("Subtotaal (excl. BTW)") ?></td>
                <td></td>
                <td><?php echo ('€' . number_format((berekenSubtotaal($stockitem) - berekenBtw(berekenSubtotaal($stockitem))), 2, ",", ".")); ?>
                </td>
            </tr>
            <tr>
                <td><?= _("BTW") ?></td>
                <td></td>
                <td><?php $subTotaalprijs = berekenSubtotaal($stockitem);
                    echo ('€' . number_format(berekenBtw($subTotaalprijs), 2, ",", ".")) ?></td>
            </tr>
            <tr>
                <td><?= _("Verzendkosten") ?></td>
                <td></td>
                <td><?php echo ('€' . number_format(berekenVerzendkosten($subTotaalprijs), 2, ",", ".")) ?>
                </td>
            </tr>
            <tr>
                <td><?= _("Totaal") ?></td>
                <td></td>
                <td><?php $verzendKosten = berekenVerzendkosten($subTotaalprijs);
                    echo ('€' . number_format(berekenTotaal($subTotaalprijs, $verzendKosten), 2, ",", ".")); ?></td>
            </tr>
        </table>
        <div class="pay-container">
            <form action="<?= base_url ?>order" method="POST" name="order-info">
                <div class="inline-radio">
                    <input type="radio" name="method" value="credit">
                    <label>
                        <h4>Credit card</h4>
                    </label>
                </div>
                <div class="credit-card">
                    <input type="text" placeholder="<?= _("Kaart nummer (3700 0000 0000 002)") ?>" name="card-number">
                    <input type="text" placeholder="<?= _("Naam op kaart") ?>" name="card-name">
                    <input class="start-column" type="text" placeholder="<?= _("Vervaldatum (mm/yy)") ?>" name="card-date">
                    <input class="end-column" type="text" placeholder="<?= _("CVC (7373)") ?>" name="card-cvc">
                </div>
                <div class="inline-radio">
                    <input type="radio" name="method" value="paypal">
                    <label>
                        <h4>PayPal</h4>
                    </label>
                </div>
                <div class="inline-radio">
                    <input type="radio" name="method" value="ideal">
                    <label>
                        <h4>iDeal</h4>
                    </label>
                </div>
                <div class="IDEAL">
                    <select name="bank-name">
                        <option value="ABN AMRO">
                            ABN AMRO
                        </option>
                        <option value="ASN Bank">
                            ASN Bank
                        </option>
                        <option value="Friesland Bank">
                            Friesland Bank
                        </option>
                        <option value="ING">
                            ING
                        </option>
                        <option value="Rabobank">
                            Rabobank
                        </option>
                        <option value="RegioBank">
                            RegioBank
                        </option>
                        <option value="SNS Bank">
                            SNS Bank
                        </option>
                        <option value="Triodos Bank">
                            Triodos Bank
                        </option>
                        <option value="Van Lanschot Bankiers">
                            Van Lanschot Bankiers
                        </option>
                    </select>
                </div>
                <button type="submit"><?= _("Bestel") ?></button>
            </form>
        </div>
    </div>
</div>