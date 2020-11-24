<?php

use App\Domain\Database\DatabaseInstance;
use App\Domain\Reviews\Reviews;

include __DIR__ . '/connect.php';
include __DIR__ . '/header.php';

$_GET['id'] = $id;

$Query = "
           SELECT SI.StockItemID,
            (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice,
            StockItemName,
            CONCAT('Voorraad: ',QuantityOnHand)AS QuantityOnHand,
            QuantityOnHand as voorraad,
            SearchDetails,
            (CASE WHEN (RecommendedRetailPrice*(1+(TaxRate/100))) > 50 THEN 0 ELSE 6.95 END) AS SendCosts, MarketingComments, CustomFields, SI.Video,
            (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath
            FROM stockitems SI
            JOIN stockitemholdings SIH USING(stockitemid)
            JOIN stockitemstockgroups ON SI.StockItemID = stockitemstockgroups.StockItemID
            JOIN stockgroups USING(StockGroupID)
            WHERE SI.stockitemid = ?
            GROUP BY StockItemID";

$ShowStockLevel = 1000;
$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "i", $_GET['id']);
mysqli_stmt_execute($Statement);
$ReturnableResult = mysqli_stmt_get_result($Statement);
if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
    $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
} else {
    $Result = null;
}
//Get Images
$Query = "
                SELECT ImagePath
                FROM stockitemimages
                WHERE StockItemID = ?";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "i", $_GET['id']);
mysqli_stmt_execute($Statement);
$R = mysqli_stmt_get_result($Statement);
$R = mysqli_fetch_all($R, MYSQLI_ASSOC);

if ($R) {
    $Images = $R;
}

if (isset($_GET['aantal'])) {
    $meer = ($_GET['aantal'] == 1) ? 'is ' . $_GET['aantal'] . ' artikel' : 'zijn ' . $_GET['aantal'] . ' artiekelen';
    echo '<div class="pop-up">Er ' . $meer . ' toegevoegd aan de winkelwagen</div>';
}

// Get reviews
$reviewsHandler = new Reviews();
$reviews = $reviewsHandler->getReviews($_GET['id'])
?>
<div id="CenteredContent">

    <?php


    if ($Result != null) {
    ?>
        <?php
        if (isset($Result['Video'])) {
        ?>
            <div id="VideoFrame">
                <?php print $Result['Video']; ?>
            </div>
        <?php }
        ?>


        <div id="ArticleHeader">
            <?php
            if (isset($Images)) {
                // print Single
                if (count($Images) == 1) {
            ?>
                    <div id="ImageFrame" style="background-image: url('<?php echo base_url ?>/Public/StockItemIMG/<?php print $Images[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                <?php
                } else if (count($Images) >= 2) { ?>
                    <div id="ImageFrame">
                        <div id="ImageCarousel" class="carousel slide" data-interval="false">
                            <!-- Indicators -->
                            <ul class="carousel-indicators">
                                <?php for ($i = 0; $i < count($Images); $i++) {
                                ?>
                                    <li data-target="#ImageCarousel" data-slide-to="<?php print $i ?>" <?php print(($i == 0) ? 'class="active"' : ''); ?>></li>
                                <?php
                                } ?>
                            </ul>

                            <!-- The slideshow -->
                            <div class="carousel-inner">
                                <?php for ($i = 0; $i < count($Images); $i++) {
                                ?>
                                    <div class="carousel-item <?php print ($i == 0) ? 'active' : ''; ?>">
                                        <img src="<?php echo base_url ?>/Public/StockItemIMG/<?php print $Images[$i]['ImagePath'] ?>">
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- Left and right controls -->
                            <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div id="ImageFrame" style="background-image: url('<?php echo base_url ?>/Public/StockGroupIMG/<?php print $Result['BackupImagePath']; ?>'); background-size: cover;"></div>
            <?php
            }
            ?>


            <h1 class="StockItemID">Artikelnummer: <?php print $Result["StockItemID"]; ?></h1>
            <h2 class="StockItemNameViewSize StockItemName">
                <?php print $Result['StockItemName']; ?>
            </h2>
            <div class="QuantityText"><?php print $Result['QuantityOnHand']; ?></div>
            <div id="StockItemHeaderLeft">
                <div class="CenterPriceLeft">
                    <div class="CenterPriceLeftChild">
                        <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $Result['SellPrice']); ?></b></p>
                        <h6> Inclusief BTW </h6>
                        <?php
                        if ($Result['voorraad'] != 0) {
                        ?>
                            <!-- TODO: Change so that this doesnt just update item count in cart but adds on to it -->
                            <form method="POST" action="<?php echo base_url; ?>add-to-cart-product/<?php echo $Result["StockItemID"]; ?>">
                                <input type="number" name="aantal" required value="1" min="1" max="<?php echo $Result['voorraad'] ?>" />
                                <input type="submit" name="voegtoe" value="In winkelwagen">
                            </form>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-information">
            <div id="StockItemDescription">
                <h3>Artikel beschrijving</h3>
                <p><?php print $Result['SearchDetails']; ?></p>
            </div>
            <div id="StockItemSpecifications">
                <h3>Artikel specificaties</h3>
                <?php
                $CustomFields = json_decode($Result['CustomFields'], true);
                if (is_array($CustomFields)) { ?>
                    <table>
                        <thead>
                            <th>Naam</th>
                            <th>Data</th>
                        </thead>
                        <?php
                        foreach ($CustomFields as $SpecName => $SpecText) { ?>
                            <tr>
                                <td>
                                    <?php print $SpecName; ?>
                                </td>
                                <td>
                                    <?php
                                    if (is_array($SpecText)) {
                                        foreach ($SpecText as $SubText) {
                                            print $SubText . " ";
                                        }
                                    } else {
                                        print $SpecText;
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table><?php
                        } else { ?>

                    <p><?php print $Result['CustomFields']; ?>.</p>
                <?php
                        }
                ?>
            </div>
        </div>

    <?php } else { ?>
        <h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2>
    <?php } ?>
    <div class="reviews">
        <h1>Reviews</h1>
        <?php foreach ($reviews as $review) { ?>
            <div class="review">
                <div class="review-header">
                    <img src="" alt="" class="user_image">
                    <h3 class="username"><?php echo $review['FirstName'] ?></h3>
                    <!-- <span class="date"><?php echo $review['Text'] ?></span> -->
                    <span class="rating">
                        <?php for ($i = 0; $i < $review['Rating']; $i++) { ?>
                            <img src="<?php echo base_url ?>Public/Img/star_full.svg" alt="star">
                        <?php } ?>
                        <?php for ($i = 5; $i > $review['Rating']; $i--) { ?>
                            <img src="<?php echo base_url ?>Public/Img/star_empty.svg" alt="star">
                        <?php } ?>
                    </span>
                </div>
                <div class="review-body">
                    <span class="text"><?php echo $review['Text'] ?></span>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
