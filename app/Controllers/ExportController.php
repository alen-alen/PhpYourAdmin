<?php

namespace PhpYourAdmin\App\Controllers;

use PhpYourAdmin\Core\Request;
use PhpYourAdmin\App\Auth\UserAuth;
use PhpYourAdmin\App\File\UserFile;
use PhpYourAdmin\App\Helpers\Route;
use PhpYourAdmin\Core\Database\Query;
use PhpYourAdmin\Core\Log\FileLogger;

class ExportController extends Controller
{
    /**
     * @var UserFile $userFile
     */
    public UserFile $userFile;

    /**
     * Translate constructor.
     * @param Route $route
     * @param Query $query
     * @param UserAuth $userAuth
     * @param Request $request
     * @param UserFile $userFile
     * @param FileLogger $logger
     */
    public function __construct(
        Query $query,
        Request $request,
        Route $route,
        UserFile $userFile,
        UserAuth $userAuth,
        FileLogger $logger
    ) {
        parent::__construct($query, $request, $route, $userAuth, $logger);
        $this->userAuth->autorize();
        $this->userFile = $userFile;
    }

    /**
     * Exports and downloads the selected database
     * @return void
     */
    public function export(): void
    {
        if (empty($this->request->parameter('db'))) {

            $this->route->redirectHome(['error', 'Please select a database!']);
        }

        $userCredentials = $this->userFile->getUserById($this->request->cookie->get('user'));

        $username = $userCredentials['username'];
        $password = $userCredentials['password'];
        $hostname = $userCredentials['host'];
        $dbname   =  $this->request->parameter('db');
        $dumpFileName = $dbname . ".sql";
        $command = getenv('MYSQL_DUMP') . " --host $hostname --user $username ";

        if (!empty($password)) {
            $command .= "--password $password";
        }
        $command .= "--database $dbname";

        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=$dumpFileName");

        passthru($command);

        exit();
    }
}
