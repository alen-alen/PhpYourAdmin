<?php

namespace PhpYourAdimn\App\Controllers;

use ZipArchive;
use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Helpers\Cookie;

class ExportController extends Controller
{
    public function export(Request $request)
    {

        $userCredentials = UserFile::getUserById(Cookie::get('user'));

        $username = $userCredentials['username'];
        $password = $userCredentials['password'];
        $hostname = $userCredentials['host'];
        $dbname   =  $request->getParameter('db');

        $dumpFileName = $dbname . ".sql";
        $command = "C:\xampp\mysql\bin\mysqldumb --add-drop-table --host=$hostname --user=$username ";

        if ($password)
            $command .= "--password=" . $password . " ";
        $command .= $dbname;
        $command .= " > " . $dumpFileName;

        // zip the dump file
        $zipfname = $dbname . "_" . date("Y-m-d_H-i-s") . ".zip";
        $zip = new ZipArchive();
        if ($zip->open($zipfname, ZIPARCHIVE::CREATE)) {
            $zip->addFile($dumpFileName, $dumpFileName);
            $zip->close();
        }
        // read zip file and send it to standard output
        if (file_exists($zipfname)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($zipfname));
            flush();
            readfile($zipfname);
            exit;
        }
        Route::redirectHome(['success','Sucessfuly exported database']);
    }
}
