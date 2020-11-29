<?php

include __DIR__ . "/connect.php";
include __DIR__ . "/header.php";

if (isset($_GET['update']) && $_GET['update'] === "true") {
    echo '<div class="pop-up">'. gettext('De winkelwagen is geüpdate') .'</div>';
}

$prices = $cartClass->GetTotalCartPrice();

?>
<div class="cart">
    <?php if (count($cart) == 0) { ?>
        <div class='empty'>
            <h4>
                <?= gettext("De winkelwagen is leeg, klik") ?>
                <a class='empty-cart-link' href='<?=base_url?>categories'>
                    <?= gettext('hier') ?>
                </a>
                <?= gettext("om iets aan de winkelwagen toe te voegen") ?>
            </h4>
        </div>
    <?php } else { ?>
        <div class="list">
            <?php
            foreach ($cart as $key => $value) {
                $productData = $cartClass->GetProductData($key);
            ?>
                <div class="list-item">
                    <?php
                    if (isset($productData['ImagePath'])) { ?>
                        <div class="ImgFrame" style="background-image: url('<?php print "Public/StockItemIMG/" . $productData['ImagePath']; ?>'); background-size: 230px; background-repeat: no-repeat; background-position: center;"></div>
                    <?php } else if (isset($productData['BackupImagePath'])) { ?>
                        <div class="ImgFrame" style="background-image: url('<?php print "Public/StockGroupIMG/" . $productData['BackupImagePath'] ?>'); background-size: cover;"></div>
                    <?php }
                    ?>
                    <div class="item-info">
                        <div>
                            <h1><?=gettext('Artikelnummer')?>: <?php print $productData["StockItemID"]; ?></h1>
                            <a href='product/<?php print $productData['StockItemID']; ?>'>
                                <p><?php print $productData["StockItemName"]; ?></p>
                                <p><?php print $productData["MarketingComments"]; ?></p>
                            </a>
                            <form action="<?php echo base_url; ?>update-cart/<?php echo $productData["StockItemID"]; ?>" method="POST" class="update-count">
                                <label for="aantal"><?=gettext('Aantal')?>: </label>
                                <input type="number" name="aantal" value="<?php print $value ?>" min="0" max="<?php echo $productData['voorraad'] ?>">
                                <input type="submit" value="Update">
                            </form>
                        </div>
                        <div>
                            <form class="delete-form" action="<?php echo base_url ?>delete-from-cart/<?php echo $productData["StockItemID"] ?>">
                                <button type="submit" class="delete-button">
                                    <img src="<?php echo base_url ?>Public/Img/delete.svg" alt="delete">
                                </button>
                            </form>
                            <div class="price">
                                <!-- Weet niet zeker of de prijs klopt -->
                                <h2><?php print sprintf("€%0.2f", $productData["SellPrice"] * $value); ?></h2>
                                <h6><?=gettext('Inclusief BTW')?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

        </div>
        <?php if (count($cart) > 0) { ?>
            <div class="total">
                <div class="item">
                    <h3><?= gettext('Totaal artikelen') ?>:</h3><span><?php echo $prices['articleTotal']; ?></span>
                </div>
                <div class="item">
                    <h5><?= gettext('Korting') ?>:</h5><span><?php echo $prices['discount']; ?></span>
                </div>
                <div class="item">
                    <h5><?= gettext('Verzendkosten') ?>:</h5><span><?php echo $prices['shipping']; ?></span>
                </div>
                <hr>
                <div class="item">
                    <h3><?= gettext('Totaal') ?>:</h3><span><?php echo $prices['total']; ?></span>
                </div>
                <a class="to-checkout" href="<?php echo base_url ?>checkout">
                    <?= gettext('Verder naar checkout') ?>
                </a>
            </div>
        <?php } ?>
</div>

<?php
include __DIR__ . "/footer.php";
