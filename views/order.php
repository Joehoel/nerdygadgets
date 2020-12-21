<?php

use App\Domain\Cart\Cart;

include __DIR__ . "/connect.php";
include __DIR__ . "./header.php";
$controller = new Cart;

$user = $_SESSION['User'];

$total = $controller->GetTotalCartPrice()['total'];

$methods = [
    'paypal' => "PayPal",
    'credit' => "Credit Card",
    'ideal' => "iDeal",
];
$method = $methods[$_POST['method']];
?>

<div class="order-container">
    <h1 class="title">Bestelling</h1>
    <p>Bedankt voor uw bestelling!</p>
    <div class="container-grid">
        <div class="order-products">
            <h3>Bestelde producten</h3>
            <ul>
                <?php foreach ($products as $key => $value) : ?>
                    <li><?= $value['StockItemName'] ?></li>
                <?php endforeach; ?>
            </ul>
            <hr>
            <div class="order-info">
                <h3>Totaal</h3>
                <h3><?= $total ?></h3>
            </div>
        </div>
        <div class="customer-info">
            <h3>Klant informatie</h3>
            <p><strong>Email:</strong> <?= $user['Email'] ?></p>
            <p><strong>Naam:</strong> <?= $user['FirstName'] . " " . $user['LastName'] ?></p>
            <p><strong>Telefoonnummer:</strong> <?= $user['PhoneNumber'] ?></p>
            <p><strong>Land:</strong> <?= $user['Country'] ?></p>
            <p><strong>Stad:</strong> <?= $user['City'] ?></p>
            <p><strong>Straat:</strong> <?= $user['Adress'] ?></p>
            <p><strong>Postcode:</strong> <?= $user['PostalCode'] ?></p>
            <p><strong>Bedrijf:</strong> <?= $user['Company'] ?></p>
            <hr>
            <h3>Betaalinformatie</h3>
            <p><strong>ID:</strong> <?= $order['OrderID'] ?></p>
            <p><strong>Methode:</strong> <?= $method ?></p>
            <?php if ($_POST['method'] === 'credit') : ?>
                <p><strong>Kaart Nummer:</strong> <?= $_POST['card-number'] ?></p>
                <p><strong>Kaart Verloopdatum:</strong> <?= $_POST['card-date'] ?></p>
                <p><strong>Kaart Naamhouder:</strong> <?= $_POST['card-name'] ?></p>
                <p><strong>CVC:</strong> <?= $_POST['card-cvc'] ?></p>
            <?php endif ?>
            <?php if ($_POST['method'] === 'ideal') : ?>
                <p><strong>Bank naam: </strong> <?= $_POST['bank-name'] ?></p>
            <?php endif ?>
        </div>
    </div>
</div>
