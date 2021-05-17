<?php

namespace PhpYourAdimn\App\Helpers;

class Route
{
    /**
     * Redirect to given path with $data in session
     * 
     * @param array $data
     * @param string $path redirect route
     */
    public static function redirect($path, array $data = null): void
    {
        if (!$data) {
            header("Location:/{$path}");
            exit();
        }
        Session::set($data[0], $data[1]);
        header("Location:/{$path}");
        exit();
    }

    /**
     * Returns the route path with the apropriete GET params
     * 
     * @param array $params params sent with GET
     * @param string $path
     * @return string
     */
    public static function path($path = null, $params = []): string
    {
        if ($path === null) {
            $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        }
        if (!empty($params)) {
            foreach ($params as $key => $param) {
                if ($key === 0) {
                    $path .= "?{$param[0]}={$param[1]}";
                } else {
                    $path .= "&{$param[0]}={$param[1]}";
                }
            }
        }
        return "http://{$_SERVER['HTTP_HOST']}/$path";
    }
}
