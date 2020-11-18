<?php
include __DIR__ . "/connect.php";
include __DIR__ . "/header.php";
?>
<!DOCTYPE html>
<html lang="en">

<body>
    <div class="content">
        <div class="information">
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

        <div class="payment">
            <table>
            <?php $totaalPrijs = 0; foreach($stockitem as $item) { ?>
                <tr>
                    <td><?php echo($item['StockItemName'])?></td>
                    <td><?php echo(number_format($item['UnitPrice'] * $_SESSION['Cart'][$item['StockItemID']],2));
                        $totaalPrijs = $totaalPrijs + $item['UnitPrice']; ?></td>
                </tr>
            <?php } ?>
            </table>
            <table>
                <tr>
                    <td>Subtotaal (excl. BTW)</td>
                    <td><?php
                        echo(number_format($totaalPrijs, 2)); 
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>BTW</td>
                    <td><?php 
                        $btw = $totaalPrijs / 100 * 9;
                        echo(number_format($btw, 2));?></td>
                </tr>
                <tr>
                    <td>Verzendkosten</td>
                    <td><?php 
                        if($totaalPrijs < 50) {
                            echo("6.95");
                            $totaalPrijs = $totaalPrijs + 6.95;
                        } else {
                            echo("Gratis");
                        }?>
                    </td>
                </tr>
                <tr>
                    <td>Totaal</td>
                    <td><?php echo(number_format($totaalPrijs, 2));?></td>
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
</body>

</html>
