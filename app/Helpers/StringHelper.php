<?php

namespace PhpYourAdimn\App\Helpers;

class StringHelper
{
    /**
     * Converts a string to an array
     * 
     * @param string $string
     * @return array
     */
    public static function convertStringToArray($string)
    {
        $fileUsers = explode('|', $string);

        $array = [];

        foreach ($fileUsers as $user) {
            if (empty($user)) {
                continue;
            }
            $userCredentials = [];
            foreach (explode(',', $user) as $credential) {
                $tmp = explode(':', $credential);

                $userCredentials[$tmp[0]] = $tmp[1];
            }
            $array[] = $userCredentials;
        }

        return $array;
    }

    /**
     * Converts an array in to a string
     * 
     * @param array $array
     * @return string
     */
    public static function convertArrayToString($array)
    {
        $string = '';

        foreach ($array as $arrayElement) {
            $string .= "username:{$arrayElement['username']},password:{$arrayElement['password']},host:localhost,id:{$arrayElement['id']}|";
        }
        return $string;
    }
}
