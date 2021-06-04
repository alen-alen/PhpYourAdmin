<?php

namespace PhpYourAdmin\Core;

use PhpYourAdmin\App\Helpers\Cookie;
use PhpYourAdmin\App\Helpers\Session;

class Request
{
    /**
     * @var Session $session
     */
    public Session $session;

    /**
     * @var Cookie $cookie
     */
    public Cookie $cookie;

    /**
     * @param Session $session
     * @param Cookie $cookie
     */
    public function __construct(Session $session, Cookie $cookie)
    {
        $this->session = $session;
        $this->cookie = $cookie;
    }

    /**
     * Check if the request has $key parameter
     * 
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($_POST[$key]) || isset($_GET[$key]);
    }

    /**
     * Return The data from the request 
     * 
     * @return array
     */
    public function requestData(): array
    {
        return self::method() === "POST" ? $_POST : $_GET;
    }

    /**
     * Return The data from the request with $key
     * 
     * @param string $key
     * 
     * @return string
     */
    public function parameter(string $key): string
    {
        return self::method() === "POST" ? $_POST[$key] : $_GET[$key];
    }

    /**
     * Check if the FILES parameter $key is set and return its value
     * 
     * @param string $key
     * 
     * @return array  $_FILES[$key] 
     */
    public  function file(string $name): array
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
}
