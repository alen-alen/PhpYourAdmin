<?php
namespace PhpYourAdimn\Core;

class Request
{
    public static function uri()
    {
        return  trim(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH),'/');
         trim($_SERVER['REQUEST_URI'],'/');
    }

    public static function method()
    {
       return $_SERVER['REQUEST_METHOD'];
    }

}