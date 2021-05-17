<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\App\Helpers\Route;

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

    if ($request) {

      $tables = $this->query->getTables();

      if (isset($request['table'])) {

        $columns =  $this->query->getTableColumns($request['table']);

        $data =  $this->query->selectAll($request['table']);

        return $this->view('home', compact('databases', 'tables', 'columns', 'data'));
      }
      return $this->view('home', compact('databases', 'tables'));
    }
    return $this->view('home', compact('databases'));
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
   * @param $request
   */
  public function store($request)
  {
    if (array_search($request['dbName'], $this->query->getDatabases())) {
      return Route::redirect('database/create', ['error', 'Database Already exists!']);
    }

    $dbOptions = $this->query->getCollationById($request['collationId']);

    $this->query->createDatabase($request['dbName'], $dbOptions['Charset'], $dbOptions['Collation']);

    return Route::redirect('database/dashboard', ['success', 'Database Created!']);
  }
}
