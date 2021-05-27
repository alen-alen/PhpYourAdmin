<?php

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Cookie;
use PhpYourAdimn\App\Helpers\Session;
use PhpYourAdimn\Core\Database\Connection;

return [
    'PhpYourAdimn\\Core\\Database\\Connection' => function () {
        return Connection::getInstance(new Request(new Session(), new Cookie()),new UserFile());
    }
];
