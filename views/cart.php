<?php

include __DIR__ . "/connect.php";
include __DIR__ . "/header.php";
?>
<div class="cart">
    <?php
    foreach ($cart as $key => $value) {
        $productData = $cartClass->GetProductData($key);
    ?>

        <div class="cart-item">

            <?php
            if (isset($productData['ImagePath'])) { ?>
                <div class="ImgFrame" style="background-image: url('<?php print "Public/StockItemIMG/" . $productData['ImagePath']; ?>'); background-size: 230px; background-repeat: no-repeat; background-position: center;"></div>
            <?php } else if (isset($productData['BackupImagePath'])) { ?>
                <div class="ImgFrame" style="background-image: url('<?php print "Public/StockGroupIMG/" . $productData['BackupImagePath'] ?>'); background-size: cover;"></div>
            <?php }
            ?>
            <div class="item-info">
                <div>
                    <h1>Artikelnummer: <?php print $productData["StockItemID"]; ?></h1>
                    <a href='product/<?php print $productData['StockItemID']; ?>'>
                        <p><?php print $productData["StockItemName"]; ?></p>
                        <p><?php print $productData["MarketingComments"]; ?></p>
                    </a>
                    <form action="<?php echo base_url; ?>update-cart/<?php echo $productData["StockItemID"]; ?>" method="POST" class="update-count">
                        <label for="aantal">Aantal: </label>
                        <input type="number" name="aantal" value="<?php print $value ?>">
                        <input type="submit" value="Update">
                    </form>
                </div>
                <div>
                    <form class="delete-form" action="<?php echo base_url ?>delete-from-cart/<?php echo $productData["StockItemID"] ?>">
                        <button type="submit" class="delete-button">

                            <svg style="width: 25px; height: 25px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </form>
                    <div class="price">
                        <!-- Weet niet zeker of de prijs klopt -->
                        <h2><?php print sprintf("€%0.2f", $productData["SellPrice"] * $value); ?></h2>
                        <h6>Inclusief BTW </h6>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>

<?php
include __DIR__ . "/footer.php";
