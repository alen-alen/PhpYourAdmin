<?php

namespace PhpYourAdimn\App\Helpers;

class Cookie
{
    /**
     * Returns the value of the Cookie,
     * $key is the index of the Cookie.
     * 
     * @param string  $key 
     * 
     * @return string|array
     */
    public function get(string $key)
    {
        $cookie = explode('--', $_COOKIE[$key]);
        $value = $cookie[0];
        return $value;
    }

    /**
     * Set a cookie,The value allways has the end date of the cookie.
     * The cookie value cannot have '--' .
     * 
     * @param string $key
     * @param string|array $value
     * @param int $expireIn seconds until expiration date
     * @return void
     */
    public function set(string $key, string $value, int $expireIn = 86400): void
    {
        $time = time() + $expireIn;
        setcookie($key, $value . '--' . $time, $time);
    }

    /**
     * Delete a cookie
     * 
     * @param string $key
     */
    public function destroy(string $key): void
    {
        setcookie($key, ' ', time() - 64000);
        unset($_COOKIE['user']);
    }

    /**
     * Check if a cookie is set
     * 
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return isset($_COOKIE[$key]);
    }

    /**
     * Check if a cookie is expired
     * 
     * @param string $key
     * @return bool
     */
    public function isExpired(string $key): bool
    {
        $cookie = explode('--', $_COOKIE[$key]);
        $cookieEndDate = $cookie[1];

        if ($_COOKIE[$key][1] < $cookieEndDate) {
            return true;
        }
        return false;
    }
}
