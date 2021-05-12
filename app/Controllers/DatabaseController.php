<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\Core\Database\Connection;

class DatabaseController extends Controller
{
  public function __construct()
  {
    UserAuth::autorize();
  }

  public function index($request)
  {
    $connection = Connection::getInstance();

    $databases = $connection->getDatabases($request);

    $tables = $connection->getTables();

    if (isset($request['table'])) {

      $columns = $connection->getTableColumns($request['table']);
      $data = $connection->select($request['table']);

      return $this->view('home', compact('databases', 'tables', 'columns', 'data'));
    }
    return $this->view('home', compact('databases', 'tables'));
  }
}
