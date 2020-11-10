<?php

use App\Domain\Route\Route;

require __DIR__ . '/autoload.php';

define("base_dir", __DIR__);

$route = new Route();
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
    . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$route->match(trim(parse_url($url, PHP_URL_PATH), '/'));