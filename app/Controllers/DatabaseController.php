<?php

namespace PhpYourAdimn\App\Controllers;

use Exception;
use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Query;
use PhpYourAdimn\App\Requests\DatabaseRequest;

class DatabaseController extends Controller
{
  public function __construct(Query $query)
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

  /**
   * Returns all tables 
   * 
   * @param Request $request
   */
  public function showTable(Request $request)
  {
    $tableData = $this->query->selectAll($request->getParameter('table'));

    $columns = !empty($tableData) ?
      array_keys($tableData[0]) :
      $this->query->getTableColumns($request->getParameter('table'));

    return $this->view('home', compact('tableData', 'columns'));
  }

  /**
   * Returns the home view with the correct data
   * 
   * @param Request $request
   */
  public function userQuery(Request $request)
  {
    $message = '';
    $tableData = [];
    $columns = [];

    try {
      $tableData = $this->query->rawSql($request->getParameter('sql'));
      $columns = !empty($tableData) ?
        array_keys($tableData[0]) :
        $this->query->getTableColumns($request->getParameter('table'));
    } catch (Exception $e) {
      $message = $e->getMessage();
    }
    return $this->view('home', compact('tableData', 'columns', 'message'));
  }

  /**
   * Show the database create form 
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
  public function store(Request $request): void
  {
    $databaseRequest = new DatabaseRequest($request->postParameters());

    $request = $databaseRequest->validate($this->query->getDatabases());

    $dbOptions = $this->query->getCollationById($request['collationId']);

    $this->query->createDatabase($request['dbName'], $dbOptions['Charset'], $dbOptions['Collation']);

    Route::redirectHome(['success', 'Database Created!']);
  }
}
