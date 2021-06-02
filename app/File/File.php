<?php

namespace PhpYourAdimn\App\File;

use PhpYourAdimn\App\Helpers\Hash;

class File
{
    /**
     * Returns the file contents of specified path as a string if it exists
     * 
     * @param string $filePath
     * 
     * @return string on success
     * @return false if the file dosent exist
     */
    public function getFile($filePath)
    {
        return file_exists($filePath) ? file_get_contents($filePath) : false;
    }
    /**
     * Returns the decrypted txt file as a string
     * 
     * @param string $filePath
     * @return string
     */
   protected function getDecryptedData(string $filePath): string
    {
        return Hash::decrypt(file_get_contents($filePath));
    }

    /**
     * Converts an array in to a string in format,
     *  username:*****,password:****,host:****,id:***|
     * 
     * @param array $array
     * @return string
     */
   protected function convertToString(array $array): string
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
   protected function convertToArray(string $data): array
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

    /**
     * Hash and save the data to the file
     * @param string $data 
     * @param string $filePath 
     * @return void
     */
   protected function save(string $data, $filePath)
    {
        $encryptNewStrig = Hash::encrypt($data);

        file_put_contents($filePath, $encryptNewStrig);
    }
}
