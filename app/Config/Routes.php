<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('inicio', 'Home::inicio');
$routes->get('quienes-somos', 'Home::quienes_somos');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::procesarLogin');
$routes->get('logout', 'AuthController::logout');
$routes->get('mi-cuenta', 'ProfesionalController::miCuenta');
$routes->post('mi-cuenta/actualizar', 'ProfesionalController::actualizarMiCuenta');

$routes->get('turnos', 'TurnoController::index');
$routes->get('turnos/nuevo', 'TurnoController::new');
$routes->post('turnos', 'TurnoController::create');
$routes->get('turnos/(:num)', 'TurnoController::show/$1');
$routes->post('turnos/(:num)/cancelar', 'TurnoController::cancelar/$1');
$routes->post('turnos/(:num)/confirmar', 'TurnoController::confirmar/$1');
$routes->post('turnos/(:num)/completar', 'TurnoController::completar/$1');
$routes->post('turnos/(:num)/delete', 'TurnoController::delete/$1');