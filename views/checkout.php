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
<div class="payments-container">
    <div class="information">
        <div>
            <h1><?= _("Klant informatie") ?></h1>
            <form class="form-2">
               <input type="text" placeholder="Email" name="email">
                <h1><?= _("Verzendadres") ?></h1>
                <input type="text" placeholder="<?= _("Voornaam") ?>" name="f-name">
                <input type="text" placeholder="<?= _("Achternaam") ?>" name="l-name">
                <input type="text" placeholder="<?= _("Bedrijf (optioneel)") ?>" name="c-name">
                <input type="text" placeholder="<?= _("Adres")?>" name="address">
                <input type="text" placeholder="<?= _("Stad") ?>" name="city">
                <input type="text" placeholder="<?= _("Land") ?>" name="country">
                <input type="text" placeholder="<?= _("Postcode") ?>" name="p-c">
                <input type="text" placeholder="<?= _("Telefoonnummer")?> >" name="tel">
            </form>
        </div>
    </div>

    <div class="payment">
        <table>
            <?php berekenTotaallijst($stockitem); ?>
            <tr>
                <td><?= _("Subtotaal (excl. BTW)") ?></td>
                <td></td>
                <td><?php echo ('€' . number_format(berekenSubtotaal($stockitem), 2, ",", ".")); ?>
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
            <form>
                <div class="inline-radio">
                    <input type="radio" name="method" value="Credit">
                    <p>Credit card</p>
                </div>
                <div class="credit-card">
                    <input type="text" placeholder="<?= _("Card number") ?>" name="card-number">
                    <input type="text" placeholder="<?= _("Naam op kaart") ?>" name="card-name">
                    <input class="start-column" type="text" placeholder="<?= _("Vervaldatum (mm/yy)") ?>" name="card-number">
                    <input class="end-column" type="text" placeholder="<?= _("CVC") ?>" name="card-name">
                </div>
                <div class="inline-radio">
                    <input type="radio" name="method" value="PayPal">
                    <p>PayPal</p>
                </div>
                <div class="inline-radio">
                    <input type="radio" name="method" value="IDEAL">
                    <p>IDEAL</p>
                </div>
                <div class="IDEAL">
                    <input type="text" placeholder="Bank name" name="method">
                </div>
            </form>

        </div>
        <button><?= _("Verder naar verzenden") ?></button>
    </div>
</div>
