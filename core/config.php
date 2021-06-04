<?php

use PhpYourAdmin\Core\Request;
use PhpYourAdmin\App\File\UserFile;
use PhpYourAdmin\App\Helpers\Cookie;
use PhpYourAdmin\App\Helpers\Session;
use PhpYourAdmin\Core\Log\FileLogger;
use PhpYourAdmin\Core\Database\Connection;

return [
    'PhpYourAdmin\\Core\\Database\\Connection' => Connection::getInstance(
        new Request(
            new Session(),
            new Cookie()
        ),
        new UserFile(),
        new FileLogger()
    ),
];
