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
                <input type="text" placeholder="Email" name="email" value="<?php if (isset($_SESSION["User"])) {
                                                                                echo $_SESSION["User"]["Email"];
                                                                            }
                                                                            ?>">
                <h1><?= _("Verzendingsadres") ?></h1>
                <input type="text" placeholder="<?= _("Voornaam") ?>" name="f-name" value="<?php if (isset($_SESSION["User"])) {
                                                                                                echo $_SESSION["User"]["FirstName"];
                                                                                            }
                                                                                            ?>">
                <input type="text" placeholder="<?= _("Achternaam") ?>" name="l-name" value="<?php if (isset($_SESSION["User"])) {
                                                                                                    echo $_SESSION["User"]["LastName"];
                                                                                                }
                                                                                                ?>">
                <input type="text" placeholder="<?= _("Bedrijf (Optioneel)") ?>" name="c-name" value="<?php if (isset($_SESSION["User"])) {
                                                                                                            if ($_SESSION["User"]["Company"] !== '') {
                                                                                                                echo $_SESSION["User"]["Company"];
                                                                                                            }
                                                                                                        }
                                                                                                        ?>">
                <input type="text" placeholder="<?= _("Adres") ?>" name="address" value="<?php if (isset($_SESSION["User"])) {
                                                                                                echo $_SESSION["User"]["Adress"];
                                                                                            }
                                                                                            ?>">
                <input type="text" placeholder="<?= _("Stad") ?>" name="city" value="<?php if (isset($_SESSION["User"])) {
                                                                                            echo $_SESSION["User"]["City"];
                                                                                        }
                                                                                        ?>">
                <input type="text" placeholder="<?= _("Land") ?>" name="country" value="<?php if (isset($_SESSION["User"])) {
                                                                                            echo $_SESSION["User"]["Country"];
                                                                                        }
                                                                                        ?>" value="<?php if (isset($_SESSION["User"])) {
                                                                                                        echo $_SESSION["User"]["Email"];
                                                                                                    }
                                                                                                    ?>">
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
                <td><?php echo ('€' . number_format(berekenSubtotaal($stockitem), 2, ",", ".")); ?>
                </td>
            </tr>
            <tr>
                <td>BTW</td>
                <td></td>
                <td><?php $subTotaalprijs = berekenSubtotaal($stockitem);
                    echo ('€' . number_format(berekenBtw($subTotaalprijs), 2, ",", ".")) ?></td>
            </tr>
            <tr>
                <td>Verzendkosten</td>
                <td></td>
                <td><?php echo ('€' . number_format(berekenVerzendkosten($subTotaalprijs), 2, ",", ".")) ?>
                </td>
            </tr>
            <tr>
                <td>Totaal</td>
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
                    <input type="text" placeholder="Card number" name="card-number">
                    <input type="text" placeholder="Name on card" name="card-name">
                    <input class="start-column" type="text" placeholder="Expiration date (MM / YY)" name="card-number">
                    <input class="end-column" type="text" placeholder="Security code" name="card-name">
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
        <button><?= _("Doorgaan naar versturen") ?></button>
    </div>
</div>