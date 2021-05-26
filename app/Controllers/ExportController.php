<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Helpers\Cookie;

class ExportController extends Controller
{
    public function __construct()
    {
        UserAuth::autorize();
    }

    /**
     * Exports and downloads the selected database
     * 
     * @param Request $request
     * @return void
     */
    public function export(Request $request)
    {
        if (empty($request->getParameter('db'))) {
            Route::redirectHome(['error', 'Please select a database!']);
        }
        $userCredentials = UserFile::getUserById(Cookie::get('user'));

        $username = $userCredentials['username'];
        $password = $userCredentials['password'];
        $hostname = $userCredentials['host'];
        $dbname   =  $request->getParameter('db');
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
