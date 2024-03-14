<?php

require_once 'libs/Router.php';
require_once 'app/api/api.tabla_prendas.controller.php';
require_once 'app/api/api.tabla_detalles.controller.php';
require_once 'app/api/api.usuarios.controller.php';

$router= new Router();

/**
 *  SECCIÓN TABLA PRENDAS
 */

//Para obtener todas las prendas y ordenar ASC o DESC
$router->addRoute('prendas', 'GET', 'ApiTablaPrendasController','get');

// Para obtener una prenda dado un ID
$router->addRoute('prendas/:ID', 'GET', 'ApiTablaPrendasController','get');

// Para eliminar una prenda dado un ID
$router->addRoute('prendas/:ID', 'DELETE', 'ApiTablaPrendasController','delete');

// Para agregar una prenda
$router->addRoute('prendas', 'POST', 'ApiTablaPrendasController','add');

// Para editar una prenda dado un ID
$router->addRoute('prendas/:ID', 'PUT', 'ApiTablaPrendasController','update');

// Para filtrar por costo menor a
$router->addRoute('prendas/filtro/costos', 'GET', 'ApiTablaPrendasController','filter');

/**
 *  SECCIÓN TABLA DETALLES
 */

// Para obtener todos los detalles de las prendas y ordenar ASC o DESC
$router->addRoute('detalles', 'GET', 'ApiTablaDetallesController','get');

// Para obtener el detalle de una prenda dado un ID
$router->addRoute('detalles/:ID', 'GET', 'ApiTablaDetallesController','get');

// Para eliminar el detalle de una prenda dado un ID
$router->addRoute('detalles/:ID', 'DELETE', 'ApiTablaDetallesController','delete');

// Para agregar un nuevo detalle de una prenda 
$router->addRoute('detalles', 'POST', 'ApiTablaDetallesController','add');

// Para editar el detalle de una prenda dado un ID
$router->addRoute('detalles/:ID', 'PUT', 'ApiTablaDetallesController','update');

// Para filtrar por stock de una prenda menor a
$router->addRoute('detalles/filtro/stock', 'GET', 'ApiTablaDetallesController','filter');

// Endpoint para obtener el token y consumir (POST, PUT y DELETE)
$router->addRoute('user/token', 'GET', 'ApiUsuariosController','getToken');


$router->route($_REQUEST['resource'], $_SERVER['REQUEST_METHOD']);

?>