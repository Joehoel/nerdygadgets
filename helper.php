<?php

use App\Domain\Route\Header;

if(!function_exists('view')) {
    function view($name, $variables = []) {
        $filePath = base_dir . DIRECTORY_SEPARATOR
            . 'views' . DIRECTORY_SEPARATOR . $name . '.php';
        if(file_exists($filePath)){
            /**
             *
             * OK, extract might be kind of complex to understand.
             * Simply said, it it makes the array $variables ["id" => "5"]
             * into local variables. After that, you can use $id in this function's scope.
             *
             */
            extract($variables);

            /*
             * if you want to try extract, uncomment this code:
             *
             * die($id)
             *
             * on the homepage, you'll see it won't work. but if you use it on a product page
             * it show $id.
             *
             * */

            /*
             * Now when we include, it'll have all the variables that we used in the extract as well.
             * These variables are the parameters. This allows us to make a url like /product/5
             * 5 can now be used as $id in the product.php
             *
             **/
            include $filePath;
        }
    }
}
/**
 * Helper function that returns full proper URL
 */
if(!function_exists('url')) {
    function url($path) {
        return base_url . $path;
    }
}

if(!function_exists('back')) {
    function back() {
        $header = new Header();
        $header->back();
        exit;
    }
}

if(!function_exists('redirect')) {
    function redirect($url) {
        $header = new Header();
        $header->redirect($url);
        exit;
    }
}