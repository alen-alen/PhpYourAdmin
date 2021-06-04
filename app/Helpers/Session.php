<?php

namespace PhpYourAdmin\App\Helpers;

class Session
{
    /**
     * Active session flag
     * 
     * @var bool $active 
     */
    private bool $active = false;

    /**
     * Start a session
     * 
     * @return void
     */
    public function start(): void
    {
        if (!$this->active) {
            session_start();
            $this->active = true;
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
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get a session item by it's key
     * @param string $key
     * @param string $secondKey if session value is an array
     * 
     * @return mixed session item value array|string
     */
    public function get(string $key, $secondKey = false)
    {
        if ($secondKey) {
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
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Destroy the active session
     * 
     * @return void
     */
    public function destroy(): void
    {
        if ($this->active) {
            session_destroy();
            $this->active = false;
        }
    }
}
