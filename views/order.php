<?php

use App\Domain\Cart\Cart;

include __DIR__ . "/connect.php";
include __DIR__ . "./header.php";

$controller = new Cart;

$user = $_SESSION['User'];
$cart = null;

foreach ($_SESSION['Cart'] as $key => $value) {
    $cart[$key] = $controller->GetProductData($key);
}

$total = $controller->GetTotalCartPrice()['total'];

print_r($_POST);
?>

<div class="order-container">
    <h1 class="title">Bestelling</h1>
    <p>Bedankt voor uw bestelling!</p>
    <div class="container-grid">

        <div class="order-products">
            <h3>Bestelde producten</h3>
            <ul>
                <?php foreach ($cart as $key => $value) : ?>
                    <li><?= $value['StockItemName'] ?></li>
                <?php endforeach; ?>
            </ul>
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
        </div>
    </div>
</div>
