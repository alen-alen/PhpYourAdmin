<?php

namespace PhpYourAdmin\App\Controllers;

use PhpYourAdmin\Core\Request;
use PhpYourAdmin\App\File\File;
use PhpYourAdmin\App\Auth\UserAuth;
use PhpYourAdmin\App\Helpers\Route;
use PhpYourAdmin\Core\Database\Query;
use PhpYourAdmin\Core\Log\FileLogger;
use PhpYourAdmin\App\Controllers\Controller;
use PhpYourAdmin\App\Exceptions\RequestException;
use PhpYourAdmin\App\Requests\ImportRequest;

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
        UserAuth $userAuth,
        FileLogger $logger
    ) {
        parent::__construct($query, $request, $route, $userAuth, $logger);
        $this->userAuth->autorize();
        $this->file = $file;
    }

    /**
     * Return the import form view
     */
    public function importForm(): void
    {
        $this->view('database/import');
    }

    /**
     * Imports the selected file in the selected database
     */
    public function import(): void
    {
        $importRequest = new ImportRequest($this->request->file('database'));
        try {
            $importRequest->validate();
        } catch (RequestException $e) {
            $this->logger->notice($e->getMessage());
            $this->route->redirect('database/import?db=' . $this->request->parameter('db'), ['error', $e->getMessage()]);
        }

        $query = $this->file->getFile($this->request->file('database')['tmp_name']);

        try {
            $this->query->rawSql($query);
            $this->route->redirectHome(['success', 'Succesfuly imported database']);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $this->route->redirect("database/import?db=" . $this->request->parameter('db'), ['errors', $e->getMessage()]);
        }
    }
}
