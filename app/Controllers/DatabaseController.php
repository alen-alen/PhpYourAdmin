<?php

namespace PhpYourAdimn\App\Controllers;

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
  public function dashboard($request)
  {
    $databases = $this->query->getDatabases();

    $tables = [];
    $columns = [];
    $data = [];

    if (!empty($request)) {
      $tables = $this->query->getTables();
      if (isset($request['table'])) {

        $columns =  $this->query->getTableColumns($request['table']);

        $data =  $this->query->selectAll($request['table']);
      }
    }
    return $this->view('home', compact('databases', 'tables', 'columns', 'data'));
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
