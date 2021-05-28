<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\File\File;
use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Query;
use PhpYourAdimn\App\Controllers\Controller;
use PhpYourAdimn\App\Requests\ImportRequest;

class ImportController extends Controller
{
    /**
     * @var File $file
     */

    public File $file;
    /**
     * Translate constructor.
     * @param Route $route
     * @param Query $query
     * @param UserAuth $userAuth
     * @param Request $request
     */
    public function __construct(
        Query $query,
        Request $request,
        Route $route,
        File $file,
        UserAuth $userAuth
    ) {
        parent::__construct($query, $request, $route, $userAuth);
        $this->userAuth->autorize();
        $this->file = $file;
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
     */
    public function import()
    {
        $importRequest = new ImportRequest($this->request->file('database'), $this->route);

        $importRequest->validate();

        $query = $this->file->getFile($this->request->file('database')['tmp_name']);

        try {
            $this->query->rawSql($query);
            $this->route->redirectHome(['success', 'Succesfuly imported database']);
        } catch (\Exception $e) {

            $message = $e->getMessage();

            return $this->view('database/import', compact('message'));
        }
    }
}
