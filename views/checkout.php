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
    if ($subTotaalprijs < 5) {
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
?>
<div class="payments-container">
    <div class="information">
        <div>
            <h1>Customer information</h1>
            <form class="form-1">
                <input type="text" placeholder="Email" name="email">
                <div>
                    <input type="checkbox" value="1" name="informed">
                    <p>Keep me up to date on news and exlusive offers.</p>
                </div>
            </form>
            <h1>shipping address</h1>
            <form class="form-2">
                <input type="text" placeholder="First name" name="f-name">
                <input type="text" placeholder="Last name" name="l-name">
                <input type="text" placeholder="Company (optional)" name="c-name">
                <input type="text" placeholder="Address" name="address">
                <input type="text" placeholder="Apt, suite, etc (optional)" name="apt">
                <input type="text" placeholder="City" name="city">
                <input type="text" placeholder="Country" name="country">
                <input type="text" placeholder="Postal code" name="p-c">
                <input type="text" placeholder="Phone" name="tel">
            </form>
        </div>
    </div>

    <div class="payment">
        <table>
            <tr>
                <td>Subtotaal (excl. BTW)</td>
                <td><?php echo (berekenSubtotaal($stockitem)); ?>
                </td>
            </tr>
            <tr>
                <td>BTW</td>
                <td><?php $subTotaalprijs = berekenSubtotaal($stockitem);
                    echo (berekenBtw($subTotaalprijs)) ?></td>
            </tr>
            <tr>
                <td>Verzendkosten</td>
                <td><?php echo (berekenVerzendkosten($subTotaalprijs)) ?>
                </td>
            </tr>
            <tr>
                <td>Totaal</td>
                <td><?php $verzendKosten = berekenVerzendkosten($subTotaalprijs);
                    echo (berekenTotaal($subTotaalprijs, $verzendKosten)); ?></td>
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
        <button>Continue to shipping</button>
    </div>
</div>

