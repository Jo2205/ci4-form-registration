<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Auth Routes
$routes->get('register', 'Register::index');
$routes->post('register/store', 'Register::store');
$routes->get('register/success', 'Register::success');

$routes->get('login', 'Login::index');
$routes->post('login/authenticate', 'Login::authenticate');
$routes->get('login/logout', 'Login::logout');

// Dashboard (Protected)
$routes->get('dashboard', 'Dashboard::index');
