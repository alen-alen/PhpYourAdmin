<?php

namespace PhpYourAdimn\App\Helpers;

use PhpYourAdimn\App\Helpers\Hash;
use PhpYourAdimn\App\Helpers\StringHelper;

class UserFile
{
    const FILE_PATH = 'users.txt';

    /**
     * Retrun the active user as an array
     * or false if there is no user
     * 
     * @param string $userId
     * @return array|false
     */
    public static function getUserById($userId)
    {
        $users = StringHelper::convertStringToArray(self::getDecryptedData());

        $user = array_filter($users, function ($user) use ($userId) {
            return $user['id'] == $userId;
        });

        return count($user) > 0 ? $user[0] : false;
    }

    /**
     * Retrun the active user as an array
     * or false if there is no user
     * 
     * @param string $username
     * @return array|false
     */
    public static function getUserByName($username)
    {
        $users = StringHelper::convertStringToArray(self::getDecryptedData());

        $user = array_filter($users, function ($user) use ($username) {
            return $user['username'] == $username;
        });

        return count($user) > 0 ? $user[0] : false;
    }

    /**
     * returns the decrypted txt file as a string
     * 
     * @return string
     */
    public static function getDecryptedData()
    {
        return Hash::decrypt(file_get_contents(self::FILE_PATH));
    }

    /**
     * Save a user to the txt file
     * 
     * @return void|false
     */
    public static function saveUser($userHost, $username, $password, $id)
    {
        if (self::getUserByName($username)) {
            return false;
        }
        $decryptedData = self::getDecryptedData();

        $newUser = "username:$username,password:$password,host:$userHost,id:{$id}|";

        $decryptedData .= $newUser;

        $encryptNewStrig = Hash::encrypt($decryptedData);

        file_put_contents(self::FILE_PATH, $encryptNewStrig);
    }
    /**
     * Deletes a user from the txt file
     * 
     * @param int $userId
     * @return void
     */
    public static function deleteUser($userId)
    {
        $decryptedData = self::getDecryptedData();

        $arrayOfUsers = self::convertToArray($decryptedData);

        $user = array_search($userId, $arrayOfUsers);

        unset($arrayOfUsers[$user]);

        $newString = self::convertToString($arrayOfUsers);

        $encryptedString = Hash::encrypt($newString);

        file_put_contents(self::FILE_PATH, $encryptedString);
    }

    /**
     * Converts an array in to a string
     * 
     * @param array $array
     * @return string
     */
    private static function convertToString(array $array): string
    {
        $string = '';

        foreach ($array as $arrayElement) {
            $string .= "username:{$arrayElement['username']},password:{$arrayElement['password']},host:localhost,id:{$arrayElement['id']}|";
        }
        return $string;
    }

    /**
     * Converts a string to an array
     * 
     * @param string $string
     * @return array
     */
    private static function convertToArray(string $data): array
    {
        $fileUsers = explode('|', $data);

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
}
