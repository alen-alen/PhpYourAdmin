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

    public function isGet($param)
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET[$param]);
    }
    public function isPost($param)
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[$param]);
    }

    public function getParameter($parameter)
    {
        return $this->isGet($parameter) ? $_GET[$parameter] : null;
    }

    public function postParameter($parameter)
    {
        return $this->isPost($parameter) ? $_POST[$parameter] : null;
    }
    public  function file($name)
    {
        if (isset($_FILES[$name])) {
            return $_FILES[$name];
        }
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
