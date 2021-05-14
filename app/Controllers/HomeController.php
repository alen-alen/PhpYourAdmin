<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\Core\Database\Query;

class HomeController extends Controller
{
  public function __construct(Query $query)
  {
    parent::__construct($query);

    UserAuth::autorize();
  }

  public function index()
  {
    $databases = $this->query->getDatabases();

    return $this->view('home', compact('databases'));
  }
}
