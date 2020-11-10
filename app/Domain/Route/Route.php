<?php

namespace App\Domain\Route;

use App\Domain\Config\Config;

class Route
{
    private $config;

    public function __construct()
    {
        $this->config = new Config("routes");
    }

    public function isParameter($string)
    {
        preg_match('/{(.*?)}/', $string, $match);
        if(count($match)) {
            return true;
        }
        return false;
    }

    public function shouldBeMatching($route, $slug)
    {
        $route = explode('/', $route);
        $slug = explode('/', $slug);

        for($i = 0; $i < count($route); $i++) {
            //Check if we need to skip it due to it being a variable.
            if($this->isParameter($route[$i])) {
                continue;
            }
            if($slug[$i] !== $route[$i]) {
                return false;
            }
        }

        return true;
    }

    public function getParameters($route, $url)
    {
        $parameters = [];

        $route = explode('/', $route);
        $url = explode('/', $url);
        for($i = 0; $i < count($route); $i++) {
            if($this->isParameter($route[$i])) {
                $parameters[$route[$i]] = $url[$i];
            }
        }
        return $parameters;
    }

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
                // it calls, class + function ($data[0] is class, $data[1] is function name)
                $class = new $data[0]();

                $parameters = $this->getParameters($route, $url);
                call_user_func_array([
                    $class, $data[1]
                ], $parameters);
            }
        }
    }
}