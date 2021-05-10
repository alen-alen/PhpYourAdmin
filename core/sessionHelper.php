<?php

function sessionGet($key, $secondKey = false)
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


