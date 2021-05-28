<?php

namespace PhpYourAdimn\App\Controllers;

use Exception;
use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Query;
use PhpYourAdimn\App\Requests\DatabaseRequest;


class DatabaseController extends Controller
{
  /**
   * @param Route $route
   * @param Query $query
   * @param UserAuth $userAuth
   * @param Request $request
   */
  public function __construct(
    Query $query,
    Request $request,
    Route $route,
    UserAuth $userAuth
  ) {
    parent::__construct($query, $request, $route, $userAuth);

    $this->userAuth->autorize();
  }

  /**
   * Database dashboard
   * 
   * @param $request
   */
  public function dashboard()
  {
    $this->query->getDatabases();
    return $this->view('home');
  }

  /**
   * Returns all tables 
   */
  public function showTable()
  {
    $tableData = $this->query->selectAll($this->request->parameter('table'));

    $columns = !empty($tableData) ?
      array_keys($tableData[0]) :
      $this->query->getTableColumns($this->request->parameter('table'));

    return $this->view('home', compact('tableData', 'columns'));
  }

  /**
   * Returns the home view with the correct data
   */
  public function userQuery()
  {
    $message = '';
    $tableData = [];
    $columns = [];

    try {
      $tableData = $this->query->rawSql($this->request->parameter('sql'));
      $columns = !empty($tableData) ?
        array_keys($tableData[0]) :
        $this->query->getTableColumns($this->request->parameter('table'));
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
  public function store(): void
  {
    $databaseRequest = new DatabaseRequest($this->request->requestData(), $this->route);

    $request = $databaseRequest->validate($this->query->getDatabases());

    $dbOptions = $this->query->getCollationById($request['collationId']);

    $this->query->createDatabase($request['dbName'], $dbOptions['Charset'], $dbOptions['Collation']);

    $this->route->redirectHome(['success', 'Database Created!']);
  }
}
