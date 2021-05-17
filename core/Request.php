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
        if (self::method() === "POST") {
            return $_POST;
        }
        return $_GET;
    }

    public static function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET' ? true : false;
    }
    public static function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST' ? true : false;
    }

    /**
     * @return string database name
     */
    public static function getDatabaseName()
    {
        if (isset(self::requestData()['db'])) {
            return self::requestData()['db'];
        }
    }
}
