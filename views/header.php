<!DOCTYPE html>
<html lang="en" style="background-color: rgb(35, 35, 47);">

<head>
    <script src="<?php echo base_url ?>/Public/JS/fontawesome.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url ?>/Public/JS/jquery.min.js"></script>
    <script src="<?php echo base_url ?>/Public/JS/bootstrap.min.js"></script>
    <script src="<?php echo base_url ?>/Public/JS/popper.min.js"></script>
    <script src="<?php echo base_url ?>/Public/JS/Resizer.js"></script>
    <script src="<?php echo base_url ?>/Public/JS/jquery-3.4.1.js"></script>
    <script src="<?php echo base_url ?>/Public/JS/popup.js"></script>
    <style>
        @font-face {
            font-family: MmrText;
            src: url(<?php echo base_url ?>/Public/fonts/mmrtext.ttf);
        }
    </style>
    <meta charset="ISO-8859-1">
    <title>NerdyGadgets</title>
    <link rel="stylesheet" href="<?php echo base_url ?>Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url ?>Public/CSS/nha3fuq.css">
    <link rel="stylesheet" href="<?php echo base_url ?>Public/CSS/main.css" type="text/css">
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url ?>Public/Favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url ?>Public/Favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url ?>Public/Favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url ?>Public/Favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url ?>Public/Favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url ?>Public/Favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url ?>Public/Favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url ?>Public/Favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url ?>Public/Favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo base_url ?>Public/Favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url ?>Public/Favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url ?>Public/Favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url ?>Public/Favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url ?>/Public/Favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo base_url ?>/Public/Favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>

<body>
    <div class="background">
        <div id="header">
            <div class="col-2">
                <a href="<?php echo base_url ?>" id="LogoA">
                    <img id="LogoImage" src="<?php echo base_url ?>Public/Img/logo.png">
                </a>
            </div>
            <div class="col-8" id="CategoriesBar">
                <ul id="ul-class">
                    <?php
                        $Query = "
                            SELECT StockGroupID, StockGroupName, ImagePath
                            FROM stockgroups
                            WHERE StockGroupID IN (
                                                    SELECT StockGroupID
                                                    FROM stockitemstockgroups
                                                    ) AND ImagePath IS NOT NULL
                            ORDER BY StockGroupID ASC";
                        $Statement = mysqli_prepare($Connection, $Query);
                        mysqli_stmt_execute($Statement);
                        $HeaderStockGroups = mysqli_stmt_get_result($Statement);
                    ?>
                    <?php foreach ($HeaderStockGroups as $HeaderStockGroup) { ?>
                        <li>
                            <a href="<?php echo base_url; ?>browse?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>" class="HrefDecoration">
                                <?php print $HeaderStockGroup['StockGroupName']; ?>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo base_url; ?>categories" class="HrefDecoration">
                            <?= gettext("Alle categorieën") ?>
                        </a>
                    </li>
                </ul>
            </div>
            <ul id="ul-class-navigation">
                <li>
                    <a href="<?php echo base_url; ?>browse" class="HrefDecoration"><img src="<?php echo base_url ?>/Public/Img/search.svg"></a>
                </li>
                <li class="drop-down">
                    <span><?= gettext("Talen") ?></span>
                    <ul class="items">
                        <li>
                            <a href="<?= base_url ?>taal/nederlands">Nederlands</a>
                        </li>
                        <li>
                            <a href="<?= base_url ?>taal/english">Engels</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo base_url; ?>cart" class="HrefDecoration"><img src="<?php echo base_url ?>/Public/Img/cart.svg"></a>
                </li>
                <li>
                    <a href="<?php echo base_url; ?>inloggen" class="HrefDecoration"><img src="<?php echo base_url ?>/Public/Img/profile.svg"></a>
                </li>
            </ul>
        </div>
        <div class="row" id="Content">
            <div class="col-12">
                <div id="SubContent">