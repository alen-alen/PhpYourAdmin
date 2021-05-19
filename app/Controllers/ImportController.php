<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\App\File\File;
use PhpYourAdimn\Core\Database\Connection;
use PhpYourAdimn\App\Controllers\Controller;

class ImportController extends Controller
{
    public function importForm()
    {
        return $this->view('database/import');
    }
    public function import($request,$fileRequest)
    {
        Connection::getInstance()->connectDb($request['db']);

        // $importRequest = new ImportRequest($fileRequest['database']);

        // $importRequest->validate();

        $sql = File::getFile(($_FILES['database']['tmp_name']));

        $this->query->userQuery($sql);
    }
}
