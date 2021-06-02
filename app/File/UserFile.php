<?php

namespace PhpYourAdimn\App\File;

use PhpYourAdimn\App\File\File;

class UserFile extends File
{
    /**
     * Check if the file exists and create a new file
     * 
     * @param string $filePath
     * @return void
     */
    public function createFile(string $filePath): void
    {
        if (!file_exists($filePath)) {
            fopen($filePath, 'w');
        }
    }
    /**
     * Retrun the active user as an array
     * or false if there is no user
     * 
     * @param string $userId
     * @return array
     */
    public function getUserById(string $userId)
    {

        $users = $this->convertToArray($this->getDecryptedData(getenv('FILE_PATH')));

        $user = array_filter($users, function ($user) use ($userId) {
            return $user['id'] == $userId;
        });

        return count($user) > 0 ? $user[0] : [];
    }

    /**
     * Retrun the active user as an array
     * or false if there is no user
     * 
     * @param string $username
     * @return array|false
     */
    public function getUserByName(string $username)
    {
        $users = $this->convertToArray($this->getDecryptedData(getenv('FILE_PATH')));

        $user = array_filter($users, function ($user) use ($username) {
            return $user['username'] == $username;
        });

        return count($user) > 0 ? $user[0] : false;
    }

    /**
     * Save a user to the txt file
     * 
     * @return void|false
     */
    public function saveUser(string $userHost, string $username, string $password, string $id)
    {
        if ($this->getUserByName($username)) {
            return false;
        }
        $decryptedData = $this->getDecryptedData(getenv('FILE_PATH'));

        $newUser = "username:$username,password:$password,host:$userHost,id:{$id}|";

        $decryptedData .= $newUser;

        $this->save($decryptedData, getenv('FILE_PATH'));
    }

    /**
     * Deletes a user from the txt file
     * 
     * @param int $userId
     * @return void
     */
    public function deleteUser(string $userId)
    {
        $decryptedData = $this->getDecryptedData(getenv('FILE_PATH'));

        $arrayOfUsers = $this->convertToArray($decryptedData);

        $user = array_search($userId, $arrayOfUsers);

        unset($arrayOfUsers[$user]);

        $newString = $this->convertToString($arrayOfUsers);

        $this->save($newString, getenv('FILE_PATH'));
    }
}
