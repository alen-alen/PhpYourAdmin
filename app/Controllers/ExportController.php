<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\Core\Request;
use PhpYourAdimn\Core\Traits\Auth;
use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Query;

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
     */
    public function __construct(
        Query $query,
        Request $request,
        Route $route,
        UserFile $userFile,
        UserAuth $userAuth
    ) {
        parent::__construct($query, $request, $route, $userAuth);

        $this->userAuth->autorize();
        $this->userFile = $userFile;
    }

    /**
     * Exports and downloads the selected database
     * @return void
     */
    public function export()
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
