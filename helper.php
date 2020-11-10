<?php

if(!function_exists('view')) {
    function view($name)
    {
        $path = base_dir . DIRECTORY_SEPARATOR
            . 'views' . DIRECTORY_SEPARATOR .'home.php';
        include ($path);
    }
}