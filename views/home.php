<?php
include __DIR__ . '/connect.php ';
include __DIR__ . '/header.php ';
?>

<!-- main product -->
<section class="home_container">

    <!-- the main product on the home page -->
    <div class="home_top_product">
        <div class="home_top_product_text">
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
        <div class="home_top_product_StockItemPicture"></div>
    </div>

    <!-- all the categories -->
    <div id="home_stockgroups_gridlayout">
        <?php if (isset($StockGroups)) {
            $i = 0;
            foreach ($StockGroups as $StockGroup) {
                if ($i < 6) {
        ?>
                    <!-- stockgroups -->
                    <a href="<?php echo base_url . "browse?category_id=" . $StockGroup["StockGroupID"] ?>">
                        <div class="StockGroup" style="background-image: url('Public/StockGroupIMG/<?php print $StockGroup["ImagePath"]; ?>')">
                            <div class="stockgroup_name_wrapper">
                                <h1><?php print $StockGroup["StockGroupName"]; ?></h1>
                            </div>
                        </div>
                    </a>
        <?php
                }
                $i++;
            }
        }       ?>
    </div>
</section>
<?php include __DIR__ . '/footer.php '; ?>