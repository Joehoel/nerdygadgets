<?php

namespace App\Domain\Route;

use App\Domain\Config\Config;
use App\Domain\Locale\Locale;

class Route
{
    private $config;

    /**
     * Route constructor.
     *
     * Uses the $config above to store a new
     * instance of Config class. The string inside the Config() is linked with the constructor inside Config.
     *
     * We use $this->config later on because it contains all defined routes.
     *
     */
    public function __construct()
    {
        $this->config = new Config("routes");
    }

    /**
     * @param $string
     * @return bool
     *
     * isParameter returns a boolean (true/false)
     * preg_match matches a regex string (first param) where it basically looks
     * for anything inside { and } then it stores the found 'matches' to the $matches.
     *
     * If the given string contains {*} {anything} {id} it will added to $match.
     * We then count $match to see if there are any matches.
     *
     */
    public function isParameter($string)
    {
        preg_match('/{(.*?)}/', $string, $match);
        if(count($match)) {
            return true;
        }
        return false;
    }

    /**
     * @param $route
     * @param $slug
     * @return bool
     *
     * This function accepts a $route and a $slug.
     *
     */
    public function shouldBeMatching($route, $slug)
    {
        $route = explode('/', $route);
        $slug = explode('/', $slug);

        for($i = 0; $i < count($route); $i++) {
            //Check if we need to skip it due to it being a variable.
            if (isset($route[$i]) && $this->isParameter($route[$i])) {
                continue;
            }
            if(isset($route[$i]) && isset($slug[$i])) {
                if ($slug[$i] !== $route[$i]) {
                    return false;
                }
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $route
     * @param $url
     * @return array
     *
     *
     * It loops through both $route and $url
     * if a $route[$i] is a parameter the value in the same location
     * of $url is being added as a parameter.
     *
     * The name inside the {brackets} is being added as a key. You'll end up with an array like this:
     *
     * ["id" => 5]
     *
     * If there are no found parameters it just returns an empty array [] because
     * the $parameters array would be untouched by the for loop.
     *
     */
    public function getParameters($route, $url)
    {
        $parameters = [];

        //The explode function 'explodes' a string into a array. The delimiter ('/') is how it decides what is going
        //to be the values of that array.
        $route = explode('/', $route);
        $url = explode('/', $url);

        /**
         * $route and $url should always be the same length. Because /home/{id} would match /home/5
         * Therefor, we can loop through each $route (or $url, it would not matter
         * because they should always be the same for a valid URL match)
         *
         */
        for($i = 0; $i < count($route); $i++) {
            if($this->isParameter($route[$i])) {
                $parameters[$route[$i]] = $url[$i];
            }
        }
        return $parameters;
    }

    /**
     * @param $url
     *
     * This would be the main function that gets called in index.php
     * It matches a $url with any of the defined routes inside routes config.
     *
     * If it's a match, we'll load up the class and functions that we defined.
     * If it doesn't match, an empty page will be shown. We should later add a 404 page.
     *
     * TODO: add 404 if there are no matches.
     *
     */
    public function match($url)
    {
        foreach($this->config->get("routes") as $route => $data) {
            /*
             * The if statement checks whether the $route (from the routes.php,
             * retrieved as an array from $this->config->get('routes') is equal to the current route ($slug)
             *
             * If you added a route called "home" in routes.php and the current url after the base_url (like, example.com)
             * ends with home (example.com/home) matches and the request type inside the array matches the REQUEST_METHOD
             * then it will execute the corresponding class and function.
             *
             * */
            if($this->shouldBeMatching($route, $url) && $data[2]["type"] === $_SERVER['REQUEST_METHOD'])
            {
                // The call_user_func is
                // described here: https://www.php.net/manual/en/function.call-user-func.php
                // it calls, class + function + parameters
                $class = new $data[0]();
                $parameters = $this->getParameters($route, $url);
                $this->loadCorrectLocale();
                call_user_func_array([
                    $class, $data[1]
                ], $parameters);
            }
        }
    }

    public function loadCorrectLocale()
    {
        $langCode = $_SESSION['language'] ?? null;
        $locale = new Locale();
        if($langCode && $langCode !== 'nl') {
            $locale->setPageLocale($langCode);
        }
    }
}