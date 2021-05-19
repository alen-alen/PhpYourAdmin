<?php

$router->get('database/dashboard', 'DatabaseController@dashboard');
$router->get('database/table', 'DatabaseController@showTable');
$router->get('database/query', 'DatabaseController@userQuery');

$router->get('database/create', 'DatabaseController@create');
$router->post('database/store', 'DatabaseController@store');

$router->get('login', 'LoginController@index');
$router->post('login', 'LoginController@login');
$router->get('logout', 'LogoutController@logout');

$router->get('api/dashboard', 'ApiController@dashboard');
$router->get('api/getTables', 'ApiController@getTables');
