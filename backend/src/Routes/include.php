<?php

use App\Router;

require_once __DIR__ . '/../Router.php';

$router = new Router();

require_once __DIR__ . '/ProductTypeRoutes.php';

require_once __DIR__ . '/ProductRoutes.php';

require_once __DIR__ . '/SaleRoutes.php';

require_once __DIR__ . '/InventoryMovementRoutes.php';

require_once __DIR__ . '/SaleItemRoutes.php';

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);