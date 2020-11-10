<?php

use App\Domain\Route\Route;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/autoload.php';
require __DIR__ . '/helper.php';

define("base_dir", __DIR__);

/*
 *
 * This code removes everything after the / in the URL.
 * so a URL like example.com/home/test becomes /hom/test
 *
 * */

$route = new Route();
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
    . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$route->match(trim(parse_url($url, PHP_URL_PATH), '/'));