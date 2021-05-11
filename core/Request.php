<?php

namespace PhpYourAdimn\Core;

class Request
{
    public static function uri()
    {
        trim($_SERVER['REQUEST_URI'], '/');
        return  trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function requestData()
    {
        if (self::isPost()) {
            return $_POST;
        }
        return $_GET;
    }

    public static function isPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return true;
        }
        return false;
    }
}
