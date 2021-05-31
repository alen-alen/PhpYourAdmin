<?php

use PhpYourAdimn\Core\Request;


use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Cookie;
use PhpYourAdimn\App\Helpers\Session;
use PhpYourAdimn\Core\Log\FileLogger;
use PhpYourAdimn\Core\Database\Connection;

return [
    'PhpYourAdimn\\Core\\Database\\Connection' => Connection::getInstance(
        new Request(
            new Session(),
            new Cookie()
        ),
        new UserFile(),
        new FileLogger()
    ),
];
