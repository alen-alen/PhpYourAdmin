<?php

namespace PhpYourAdimn\App\Controllers;


use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\App\Helpers\Route;

class DashboardController extends Controller
{

  public function __construct($query)
  {
    parent::__construct($query);

    UserAuth::autorize();
  }

  public function index($request)
  {
    if (empty($request)) {
      Route::redirect('');
    }

    $databases = $this->query->getDatabases($request);

    $tables = $this->query->getTables();

    if (isset($request['table'])) {

      $columns =  $this->query->getTableColumns($request['table']);

      $data =  $this->query->selectAll($request['table']);

      return $this->view('home', compact('databases', 'tables', 'columns', 'data'));
    }
    return $this->view('home', compact('databases', 'tables'));
  }
}
