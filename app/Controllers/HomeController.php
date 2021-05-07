<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\App\Auth\UserAuth;


class HomeController extends Controller
{
  public function __construct()
  {
    UserAuth::autorize();
  }
  public function index()
  {
    return $this->view('home');
  }
}
