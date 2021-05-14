<?php

namespace PhpYourAdimn\App\Helpers;

class Route
{


    /**
     * 
     * @param $path redirect route
     */
    public static function redirect($path, array $data = null)
    {
        if (!$data) {
            header("Location:/{$path}");
            die();
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
    public static function path($path = null, $params = [])
    {
        if (!$path) {
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

        return "$path";
    }
}
