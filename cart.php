<?php

include "header.php";
include 'Classes/Cart.php';
include 'Classes/Database.php';

use NerdyGadgests\Classes\Cart;
use NerdyGadgests\Classes\DataBase;

$CartHandeler = new Cart();
$database = new DataBase();

$cart = $CartHandeler->GetCartArray();

$database->MakeConnection();


foreach ($cart as $key => $value) {
    $productData = $database->GetProductData($key);
?>

    <a class="ListItem" href='view.php?id=<?php print $productData['StockItemID']; ?>'>
        <div id="ProductFrame">
            <?php
            if (isset($productData['ImagePath'])) { ?>
                <div class="ImgFrame" style="background-image: url('<?php print "Public/StockItemIMG/" . $productData['ImagePath']; ?>'); background-size: 230px; background-repeat: no-repeat; background-position: center;"></div>
            <?php } else if (isset($productData['BackupImagePath'])) { ?>
                <div class="ImgFrame" style="background-image: url('<?php print "Public/StockGroupIMG/" . $productData['BackupImagePath'] ?>'); background-size: cover;"></div>
            <?php }
            ?>

            <div id="StockItemFrameRight">
                <div class="CenterPriceLeftChild">
                    <h1 class="StockItemPriceText"><?php print sprintf("€ %0.2f", $productData["SellPrice"]); ?></h1>
                    <h6>Inclusief BTW </h6>
                </div>
            </div>
            <h1 class="StockItemID">Artikelnummer: <?php print $productData["StockItemID"]; ?></h1>
            <p class="StockItemName"><?php print $productData["StockItemName"]; ?></p>
            <p class="StockItemComments"><?php print $productData["MarketingComments"]; ?></p>
            <h4 class="ItemQuantity">Aantal: <?php print $value?></h4>
        </div>
    </a>

<?php
}

$database->CloseConnection();
?>



<?php
include "footer.php";
