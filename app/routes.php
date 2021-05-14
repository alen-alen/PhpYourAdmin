<?php

$router->get('', 'HomeController@index');

$router->get('dashboard', 'DashboardController@index');

$router->get('login', 'LoginController@index');

$router->post('login', 'LoginController@login');

$router->get('logout', 'LogoutController@logout');
