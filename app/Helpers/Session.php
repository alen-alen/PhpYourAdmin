<?php

namespace PhpYourAdimn\App\Helpers;

class Session
{
    /**
     * Active session flag
     * 
     * @var bool $active 
     */
    private static $active = false;

    /**
     * Start a session
     * 
     * @return void
     */
    public static function start()
    {
        if (self::$active === false) {
            session_start();
            self::$active = true;
        }
    }

    /**
     * Set a new session item 
     * 
     * @param string $key
     * @param string|array $value
     * 
     * @return void
     */
    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }
    /**
     * Get a session item by it's key
     * @param string $key
     * @param string $secondKey if session value is an array
     * 
     * @return mixed session item value
     */
    public static function get(string $key, $secondKey = false)
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

    /**
     * Check if a session item is set
     * 
     * @param string $key
     * @return bool
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }
    /**
     * Destroy the active session
     * 
     * @return void
     */
    public static function destroy(): void
    {
        if (self::$active === true) {
            session_destroy();
            self::$active = false;
        }
    }
}
