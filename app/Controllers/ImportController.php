<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\File\File;
use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Connection;
use PhpYourAdimn\App\Controllers\Controller;
use PhpYourAdimn\App\Requests\ImportRequest;
use PhpYourAdimn\Core\Database\Query;

class ImportController extends Controller
{
    public function __construct(Query $query, Request $request)
    {
        UserAuth::autorize();
        parent::__construct($query, $request);
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
    public function import()
    {
        Connection::getInstance()->connectDb($this->request->postParameter('db'));

        $importRequest = new ImportRequest($this->request->file('database'));

        $importRequest->validate();

        $query = File::getFile($this->request->file('database')['tmp_name']);

        try {
            $this->query->rawSql($query);
            Route::redirectHome(['success', 'Succesfuly imported database']);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->view('database/import', compact('message'));
        }
    }
}
