<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

/*
GET    /turnos              -> TurnoController::index
GET    /turnos/nuevo        -> TurnoController::new
POST   /turnos              -> TurnoController::create
GET    /turnos/(:num)       -> TurnoController::show/$1
POST   /turnos/(:num)/cancelar -> TurnoController::cancelar/$1
*/

/*
 * Rutas para el controlador TestController
 */
//$routes->get('test/insertar', 'TestController::insertar');

$routes->get('turnos', 'TurnoController::index');
$routes->get('turnos/nuevo', 'TurnoController::new');
$routes->post('turnos', 'TurnoController::create');
$routes->get('turnos/(:num)', 'TurnoController::show/$1');
$routes->post('turnos/(:num)/cancelar', 'TurnoController::cancelar/$1');
$routes->post('turnos/(:num)/confirmar', 'TurnoController::confirmar/$1');
$routes->post('turnos/(:num)/completar', 'TurnoController::completar/$1');
$routes->post('turnos/(:num)/delete', 'TurnoController::delete/$1');