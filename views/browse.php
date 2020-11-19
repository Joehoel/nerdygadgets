<?php

use App\Domain\Browse\Product;

include __DIR__ . "/connect.php";
include __DIR__ . "/header.php";

if (isset($_GET['products_on_page'])) {
    $ProductsOnPage = $_GET['products_on_page'];
    $_SESSION['products_on_page'] = $_GET['products_on_page'];
} else if (isset($_SESSION['products_on_page'])) {
    $ProductsOnPage = $_SESSION['products_on_page'];
} else {
    $ProductsOnPage = 25;
    $_SESSION['products_on_page'] = 25;
}

if (isset($_GET['page_number'])) {
    $PageNumber = $_GET['page_number'];
} else {
    $PageNumber = 0;
}

$AmountOfPages = 0;
$Offset = $PageNumber * $ProductsOnPage;
$ShowStockLevel = 1000;
$ReturnableResult = $sortproducts;
$amount = $_SESSION["results"];

if (isset($amount)) {
    $AmountOfPages = ceil($amount / $ProductsOnPage);
}

if (isset($_GET['aantal'])) {
    $meer = ($_GET['aantal'] == 1) ? 'is ' . $_GET['aantal'] . ' artikel' : 'zijn ' . $_GET['aantal'] . ' artiekelen';
    echo '<div class="pop-up">Er ' . $meer . ' toegevoegd aan de winkelwagen</div>';
}
?>
<div id="FilterFrame">
    <h2 class="FilterText"><i class="fas fa-filter"></i> Filteren </h2>
    <form>
        <div id="FilterOptions">

            <h4 class="FilterTopMargin"><i class="fas fa-search"></i> Zoeken</h4>

            <input type="text" name="search_string" id="search_string" value="<?php print (isset($_GET['search_string'])) ? $_GET['search_string'] : ""; ?>" class="form-submit" autofocus>

            <h4 class="FilterTopMargin"><i class="fas fa-list-ol"></i>Aantal producten op pagina</h4>

            <input type="hidden" name="category_id" id="category_id" value="<?php print (isset($_GET['category_id'])) ? $_GET['category_id'] : ""; ?>">

            <!-- select 1 -->
            <select name="products_on_page" id="products_on_page" onchange="this.form.submit()">>
                <option value="25" <?php if ($_SESSION['products_on_page'] == 25) {
                                        print "selected";
                                    } ?>>25
                </option>
                <option value="50" <?php if ($_SESSION['products_on_page'] == 50) {
                                        print "selected";
                                    } ?>>50
                </option>
                <option value="75" <?php if ($_SESSION['products_on_page'] == 75) {
                                        print "selected";
                                    } ?>>75
                </option>
            </select>

            <h4 class="FilterTopMargin"><i class="fas fa-sort"></i> Sorteren</h4>

            <!-- select 2 -->
            <select name="sort" id="sort" onchange="this.form.submit()">>
                <option value="price_low_high" <?php if ($_SESSION['sort'] == "price_low_high") {
                                                    print "selected";
                                                } ?>>Prijs oplopend
                </option>
                <option value="price_high_low" <?php if ($_SESSION['sort'] == "price_high_low") {
                                                    print "selected";
                                                } ?>>Prijs aflopend
                </option>
                <option value="name_low_high" <?php if ($_SESSION['sort'] == "name_low_high") {
                                                    print "selected";
                                                } ?>>Naam oplopend
                </option>
                <option value="name_high_low" <?php if ($_SESSION['sort'] == "name_high_low") {
                                                    print "selected";
                                                } ?>>Naam aflopend
                </option>
            </select>
        </div>
    </form>
</div>
</div>
<div class="list browse">
    <?php
    if (isset($ReturnableResult) && count($ReturnableResult) > 0) {
        foreach ($ReturnableResult as $row) {
    ?>
            <div class="list-item">
                <?php
                if (isset($row['ImagePath'])) { ?>
                    <div class="ImgFrame" style="background-image: url('<?php print "Public/StockItemIMG/" . $row['ImagePath']; ?>'); background-size: 230px; background-repeat: no-repeat; background-position: center;"></div>
                <?php } else if (isset($row['BackupImagePath'])) { ?>
                    <div class="ImgFrame" style="background-image: url('<?php print "Public/StockGroupIMG/" . $row['BackupImagePath'] ?>'); background-size: cover;"></div>
                <?php }
                ?>
                <div class="item-info">
                    <div>
                        <h1>Artikelnummer: <?php print $row["StockItemID"]; ?></h1>
                        <a href='product/<?php print $row['StockItemID']; ?>'>
                            <p><?php print $row["StockItemName"]; ?></p>
                            <p><?php print $row["MarketingComments"]; ?></p>
                        </a>
                    </div>
                    <div class="voorraad">
                        <h6><span>Voorraad:</span> <?php print $row["voorraad"]; ?></h6>
                    </div>
                    <div>
                        <div class="item-right">
                            <?php
                            if ($row['voorraad'] != 0) {
                            ?>
                                <div class="addcard">
                                    <h3>add to card</h3>
                                    <form method="POST" action="<?php echo base_url; ?>add-to-cart-browse/<?php echo $row["StockItemID"]; ?>">
                                        <input type="hidden" value="<?php echo $_GET["category_id"]; ?>" name="category_id">
                                        <input type="hidden" value="1" name="aantal">
                                        <input type="submit" value="">
                                    </form>
                                </div>
                                <div class="price">
                                    <h2><?php print sprintf("€%0.2f", $row["SellPrice"]); ?></h2>
                                    <h6>Inclusief BTW </h6>
                                </div>

                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <form id="PageSelector">
            <input type="hidden" name="search_string" id="search_string" value="<?php if (isset($_GET['search_string'])) {
                                                                                    print($_GET['search_string']);
                                                                                } ?>">
            <input type="hidden" name="category_id" id="category_id" value="<?php if (isset($_GET['category_id'])) {
                                                                                print($_GET['category_id']);
                                                                            } ?>">
            <input type="hidden" name="result_page_numbers" id="result_page_numbers" value="<?php print (isset($_GET['result_page_numbers'])) ? $_GET['result_page_numbers'] : "0"; ?>">
            <input type="hidden" name="products_on_page" id="products_on_page" value="<?php print($_SESSION['products_on_page']); ?>">
            <input type="hidden" name="sort" id="sort" value="<?php print($_SESSION['sort']); ?>">

            <?php
            if ($AmountOfPages > 0) {
                for ($i = 1; $i <= $AmountOfPages; $i++) {
                    if ($PageNumber == ($i - 1)) {
            ?>
                        <div id="SelectedPage"><?php print $i; ?></div><?php
                                                                    } else { ?>
                        <button id="page_number" class="PageNumber" value="<?php print($i - 1); ?>" type="submit" name="page_number"><?php print($i); ?></button>
            <?php }
                                                                }
                                                            }
            ?>
        </form>
    <?php
    } else {
    ?>
        <h2 id="NoSearchResults">
            Yarr, er zijn geen resultaten gevonden.
        </h2>
    <?php
    }
    ?>
</div>

<?php
include __DIR__ . "/footer.php";
?>