<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\Core\Database\Connection;

class HomeController extends Controller
{
  public function __construct()
  {
    UserAuth::autorize();
  }

  public function index()
  {
    $databases = Connection::getInstance()->getDatabases();

    return $this->view('home', compact('databases'));
  }
}
