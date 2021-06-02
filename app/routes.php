<?php
$router->get('/', 'DatabaseController@dashboard');

$router->get('database/dashboard', 'DatabaseController@dashboard');
$router->get('database/table', 'DatabaseController@showTable');
$router->get('database/query', 'DatabaseController@userQuery');

$router->get('database/users', 'UserController@index');
$router->get('database/users/create', 'UserController@create');
$router->post('database/users/store', 'UserController@store');
$router->get('database/users/delete', 'UserController@delete');

$router->get('database/import', 'ImportController@importForm');
$router->post('database/import', 'ImportController@import');

$router->get('database/export', 'ExportController@export');

$router->get('database/create', 'DatabaseController@create');
$router->post('database/store', 'DatabaseController@store');

$router->get('login', 'LoginController@index');
$router->post('login', 'LoginController@login');
$router->get('logout', 'LogoutController@logout');

$router->get('api/databases', 'ApiController@databases');
$router->get('api/getTables', 'ApiController@getTables');
