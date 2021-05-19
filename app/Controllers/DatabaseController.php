<?php

namespace PhpYourAdimn\App\Controllers;

use Exception;
use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Requests\DatabaseRequest;

class DatabaseController extends Controller
{
  public function __construct($query)
  {
    parent::__construct($query);

    UserAuth::autorize();
  }

  /**
   * Database dashboard
   * 
   * @param $request
   */
  public function dashboard()
  {
    return $this->view('home');
  }

  public function showTable(Request $request)
  {

    $tableData = $this->query->selectAll($request->getParameter('table'));

    if (!empty($tableData)) {
      $columns = array_keys($tableData[0]);
    } else {
      $columns = $this->query->getTableColumns($request->getParameter('table'));
    }
    return $this->view('home', compact('tableData', 'columns'));
  }

  public function userQuery($request)
  {
    $message = '';
    $tableData = [];
    $columns = [];

    try {
      $tableData = $this->query->userQuery($request->getParameter('sql'));
      if (!empty($tableData)) {
        $columns = array_keys($tableData[0]);
      } else {
        $columns = $this->query->getTableColumns($request->getParameter('table'));
      }
    } catch (Exception $e) {
      $message = $e->getMessage();
    }
    return $this->view('home', compact('tableData', 'columns', 'message'));
  }
  /**
   * Create database form
   */
  public function create()
  {
    $collations = $this->query->showCollations();

    sort($collations);

    return $this->view('database/create', compact('collations'));
  }

  /**
   * Save a new database
   * 
   * @param array $request
   * @return void
   */
  public function store(array $request): void
  {
    $databaseRequest = new DatabaseRequest($request);

    $request = $databaseRequest->validate($this->query->getDatabases());

    $dbOptions = $this->query->getCollationById($request['collationId']);

    $this->query->createDatabase($request['dbName'], $dbOptions['Charset'], $dbOptions['Collation']);

    Route::redirectHome(['success', 'Database Created!']);
  }
}
