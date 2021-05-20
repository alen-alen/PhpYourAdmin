<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\File\File;
use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Connection;
use PhpYourAdimn\App\Controllers\Controller;
use PhpYourAdimn\App\Requests\ImportRequest;

class ImportController extends Controller
{
    public function __construct()
    {
        UserAuth::autorize();
    }
    /**
     * Return the import form view
     */
    public function importForm()
    {
        return $this->view('database/import');
    }

    /**
     * Imports the selected file in the selected database
     * 
     *@param Request $request 
     */
    public function import(Request $request)
    {
        Connection::getInstance()->connectDb($request->postParameter('db'));

        $importRequest = new ImportRequest($request->file('database'));

        $importRequest->validate();

        $query = File::getFile($request->file('database')['tmp_name']);

        try {
            $this->query->rawSql($query);
            Route::redirectHome(['success', 'Succesfuly imported database']);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->view('database/import', compact('message'));
        }
    }
}
