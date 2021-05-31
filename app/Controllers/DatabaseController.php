<?php

namespace PhpYourAdimn\App\Controllers;

use Exception;
use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Query;
use PhpYourAdimn\App\Requests\DatabaseRequest;
use PhpYourAdimn\Core\Log\FileLogger;

class DatabaseController extends Controller
{
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
    UserAuth $userAuth,
    FileLogger $logger
  ) {
    parent::__construct($query, $request, $route, $userAuth, $logger);

    $this->userAuth->autorize();
  }

  /**
   * Database dashboard
   * @return void
   */
  public function dashboard(): void
  {
    $this->query->getDatabases();
    $this->view('home');
  }

  /**
   * Returns home view with all database tables 
   * @return void
   */
  public function showTable(): void
  {
    $tableData = $this->query->selectAll($this->request->parameter('table'));

    $columns = !empty($tableData) ?
      array_keys($tableData[0]) :
      $this->query->getTableColumns($this->request->parameter('table'));

    $this->view('home', compact('tableData', 'columns'));
  }

  /**
   * Returns the home view with the correct data
   * @return void
   */
  public function userQuery(): void
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
      $this->logger->error($e->getMessage());
      $message = $e->getMessage();
    }
    $this->view('home', compact('tableData', 'columns', 'message'));
  }

  /**
   * Show the database create form 
   * 
   * @return void
   */
  public function create(): void
  {
    $collations = $this->query->showCollations();

    sort($collations);

    $this->view('database/create', compact('collations'));
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
