<?php
include __DIR__ . '/connect.php ';
include __DIR__ . '/header.php ';
?>

<div class="IndexStyle">
    <div class="col-11">
        <div class="TextPrice">
            <a href="<?php echo base_url ?>product/<?php print($item['StockItemID']); ?>">
                <div class="TextMain">
                    <?php echo $item["StockItemName"]; ?>
                    <h6 class="description"><?php echo $item['SearchDetails']; ?></h6>
                </div>
                <ul id="ul-class-price">
                    <li class="HomePagePrice"><?php print sprintf("€ %.2f", $item['SellPrice']); ?></li>
                    <li class="btw"><?= gettext("Inclusief BTW") ?></li>
                </ul>
            </a>
        </div>
        <div class="HomePageStockItemPicture"></div>
    </div>
</div>
<?php include __DIR__ . '/footer.php '; ?>
