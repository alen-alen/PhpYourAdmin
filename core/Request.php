<?php

namespace PhpYourAdimn\Core;

use PhpYourAdimn\App\Helpers\Cookie;
use PhpYourAdimn\App\Helpers\Session;

class Request
{
    public Session $session;
    public Cookie $cookie;

    public $data = [];

    public function __construct(Session $session, Cookie $cookie)
    {
        $this->session = $session;
        $this->cookie = $cookie;

        $this->setData();
    }

    /**
     * Check if the request method is GET and if the requested parameter is set
     * 
     * @param string $key 
     * @return bool
     */
    public function isGet($key)
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET[$key]);
    }
    public function setData()
    {
        $this->data=self::method()==='POST'? $_POST: $_GET;
    }

    /**
     * Check if the request method is POST and if the requested parameter is set
     * 
     * @param string $key 
     * @return bool
     */
    public function isPost($key)
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[$key]);
    }

    /**
     * Return the all GET parameters
     * 
     * @return $_GET
     */
    public function getParameters()
    {
        return $_GET;
    }

    /**
     * Return all POST parameters
     * 
     * @return array $_POST
     */
    public function postParameters(): array
    {
        return $_POST;
    }

    /**
     * Check if the GET parameter $key is set and return its value
     * 
     * @param string $key
     * 
     * @return string|array|null depending on the $_GET[$key] value
     */
    public function getParameter($key)
    {
        return $this->isGet($key) ? $_GET[$key] : null;
    }

    /**
     * Check if the POST parameter $key is set and return its value
     * 
     * @param string $key
     * 
     * @return string|array|null depending on the $_POST[$key] value
     */
    public function postParameter($parameter)
    {
        return $this->isPost($parameter) ? $_POST[$parameter] : null;
    }

    /**
     * Check if the FILES parameter $key is set and return its value
     * 
     * @param string $key
     * 
     * @return array  $_FILES[$key] 
     */
    public  function file($name)
    {
        if (isset($_FILES[$name])) {
            return $_FILES[$name];
        }
    }

    /**
     * Return the current uri
     * 
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
    public function requestData(): array
    {
       
        if (self::method() === "POST") {
            return $_POST;
        }
        return $_GET;
    }

    // /**
    //  * @return string $_GET['db'] database name
    //  */
    // public static function getParameterbaseName()
    // {
    //     if (isset(self::requestData()['db'])) {
    //         return self::requestData()['db'];
    //     }
    // }
}
