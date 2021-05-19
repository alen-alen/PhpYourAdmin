<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\File\File;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Connection;
use PhpYourAdimn\App\Controllers\Controller;
use PhpYourAdimn\App\Requests\ImportRequest;

class ImportController extends Controller
{
    public function importForm()
    {
        return $this->view('database/import');
    }
    public function import(Request $request)
    {
        Connection::getInstance()->connectDb($request->postParameter('db'));

        $importRequest = new ImportRequest($request->file('database'));

        $importRequest->validate();

        $sql = File::getFile($request->file('database')['tmp_name']);
       

        try {
            $this->query->userQuery($sql);
            Route::redirectHome(['success', 'Succesfuly imported database']);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->view('database/import', compact('message'));
        }
    }
}
