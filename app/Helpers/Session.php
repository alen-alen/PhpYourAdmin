<?php

namespace PhpYourAdimn\App\Helpers;

class Session
{
    private static $active = false;

    public static function start()
    {
        if (self::$active === false) {
            session_start();
            self::$active = true;
        }
    }
    
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $secondKey = false)
    {
        if ($secondKey === true) {
            if (isset($_SESSION[$key][$secondKey])) {
                return $_SESSION[$key][$secondKey];
            }
        }
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return false;
    }

    public static function display()
    {
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }

    public static function destroy()
    {
        if (self::$active === true) {
            session_destroy();
            self::$active = false;
        }
    }
}
