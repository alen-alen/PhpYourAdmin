<?php

$router->get('', 'LoginController@index');

$router->get('home', 'HomeController@index');

$router->post('login', 'LoginController@login');

$router->get('logout', 'LogoutController@logout');
