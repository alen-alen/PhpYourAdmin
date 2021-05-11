<?php

namespace PhpYourAdimn\Core;

class Request
{
    /**
     * Return the current uri
     * @return string
     */
    public static function uri(): string
    {
        trim($_SERVER['REQUEST_URI'], '/');
        return  trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    /**
     * Return the current method GET or POST
     * 
     * @return string
     */
    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Return The data from the request 
     * 
     * @return array
     */
    public static function requestData(): array
    {
        if (self::isPost()) {
            return $_POST;
        }
        return $_GET;
    }

    /**
     * Check if the request method is POST
     * 
     * @return bool;
     */
    public static function isPost(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return true;
        }
        return false;
    }
}
