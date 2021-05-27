<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\Core\Traits\Auth;
use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Query;

class ExportController extends Controller
{
    public function __construct(Query $query, Request $request, Route $route, UserFile $userFile)
    {
        $this->autorize();
        
        $this->userFile = $userFile;

        parent::__construct($query, $request, $route);
    }

    /**
     * Exports and downloads the selected database
     * @return void
     */
    public function export()
    {
        if (empty($this->request->getParameter('db'))) {

            $this->route->redirectHome(['error', 'Please select a database!']);
        }

        $userCredentials = $this->userFile->getUserById($this->request->cookie->get('user'));

        $username = $userCredentials['username'];
        $password = $userCredentials['password'];
        $hostname = $userCredentials['host'];
        $dbname   =  $this->request->getParameter('db');
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
